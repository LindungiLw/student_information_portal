<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

$dept_id = isset($_GET['dept']) ? $_GET['dept'] : 'is';

// Data Jurusan dinamis
$departments = [
    'english' => ['name' => 'English Literature', 'color' => '#d53f8c', 'icon' => 'fa-book-reader', 'image' => 'english.jpg'],
    'japanese' => ['name' => 'Japanese Literature', 'color' => '#e53e3e', 'icon' => 'fa-torii-gate', 'image' => 'japanese.jpg'],
    'accounting' => ['name' => 'Accounting', 'color' => '#3182ce', 'icon' => 'fa-chart-pie', 'image' => 'accounting.jpg'],
    'vcd' => ['name' => 'Visual Communication Design', 'color' => '#805ad5', 'icon' => 'fa-palette', 'image' => 'vcd.jpg'],
    'it' => ['name' => 'Information Technology', 'color' => '#00b5d8', 'icon' => 'fa-network-wired', 'image' => 'it.jpg'],
    'is' => ['name' => 'Information System', 'color' => '#dd6b20', 'icon' => 'fa-laptop-code', 'image' => 'is.jpg']
];

// Auto-download logic to ensure image is available
$img_dir = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/departments';
if (!is_dir($img_dir)) { @mkdir($img_dir, 0777, true); }
$img_file = $img_dir . '/' . $departments[$dept_id]['image'];
if (!file_exists($img_file)) {
    // Basic fallback mapping just in case it is accessed directly without visiting department.php
    $urls = [
        'english.jpg' => 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&w=600&q=80',
        'japanese.jpg' => 'https://images.unsplash.com/photo-1528360983277-13d401cdc186?auto=format&fit=crop&w=600&q=80',
        'accounting.jpg' => 'https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=600&q=80',
        'vcd.jpg' => 'https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&w=600&q=80',
        'it.jpg' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80',
        'is.jpg' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80'
    ];
    $url = $urls[$departments[$dept_id]['image']];
    $content = @file_get_contents($url);
    if ($content !== false) { @file_put_contents($img_file, $content); }
}

if (!array_key_exists($dept_id, $departments)) {
    $dept_id = 'is';
}

$current_dept = $departments[$dept_id];

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';
$stmt = $pdo->prepare("SELECT * FROM department_documents WHERE department_id = ? ORDER BY uploaded_at DESC");
$stmt->execute([$dept_id]);
$all_docs = $stmt->fetchAll();

$docs_by_category = [
    'vision' => [],
    'curriculum' => [],
    'degree' => [],
    'advisors' => [],
    'resources' => []
];

foreach ($all_docs as $doc) {
    if (isset($docs_by_category[$doc['tab_category']])) {
        // Physical file check for direct uploads, links don't have local paths
        if (isset($doc['doc_type']) && $doc['doc_type'] === 'link') {
            $docs_by_category[$doc['tab_category']][] = $doc;
        } else if (!empty($doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
            $docs_by_category[$doc['tab_category']][] = $doc;
        }
    }
}

function renderDocs($docs, $icon, $title, $color) {
    if (count($docs) > 0) {
        foreach($docs as $doc) {
            echo '<div class="content-card" style="margin-bottom:20px;">';
            echo '<h3 style="color:'.$color.'; margin-bottom: 8px;"><i class="fas '.$icon.'"></i> ' . htmlspecialchars($doc['title']) . '</h3>';
            
            if (isset($doc['doc_type']) && $doc['doc_type'] === 'link') {
                echo '<p style="color: var(--text-muted); margin-bottom: 16px;">This document is hosted externally.</p>';
                echo '<a href="'.htmlspecialchars($doc['external_link']).'" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; background: '.$color.'; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;"><i class="fas fa-external-link-alt"></i> Open Document</a>';
            } else {
                echo '<div class="pdf-container">';
                echo '<iframe src="'.htmlspecialchars($doc['file_path']).'#toolbar=0&navpanes=0&view=Fit" width="100%" height="100%" style="border: none; display: block;"></iframe>';
                echo '</div>';
                
                echo '<div style="margin-top: 16px; display: flex; justify-content: flex-end;">';
                echo '<a href="'.htmlspecialchars($doc['file_path']).'" target="_blank" style="color: '.$color.'; font-weight: 600; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;"><i class="fas fa-expand"></i> View Fullscreen / Download</a>';
                echo '</div>';
            }
            echo '</div>';
        }
    } else {
        echo '<div class="content-card" style="text-align: center; padding: 60px 20px;">';
        echo '<i class="fas '.$icon.'" style="font-size: 48px; color: #cbd5e1; margin-bottom: 16px;"></i>';
        echo '<h3 style="justify-content: center; color: var(--text-main); margin-top:0;">No Documents Available</h3>';
        echo '<p style="margin-bottom:0;">There are currently no official documents uploaded for '.$title.'.</p>';
        echo '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $current_dept['name']; ?> | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=10">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=3">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=4">
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  
  <main class="main">
    <div class="bottom-dashboard-section" style="padding-top: 20px;">
        
       <!-- Back Button & Header -->
       <div class="dept-detail-header" style="--dept-theme: <?php echo $current_dept['color']; ?>; --bg-img: url('/assets/images/departments/<?php echo $current_dept['image']; ?>');">
           <a href="/pages/academics/department.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Departments</a>
           <div class="header-content">
               <div class="header-icon"><i class="fas <?php echo $current_dept['icon']; ?>"></i></div>
               <div>
                   <h2><?php echo $current_dept['name']; ?></h2>
                   <p>Department Information Portal</p>
               </div>
           </div>
       </div>

       <!-- Tambahkan CSS Khusus untuk Tab dan Ikon -->
       <style>
           .pdf-container {
               height: 500px;
               border-radius: 12px;
               overflow: hidden;
               border: 1px solid var(--border-color);
               margin-top: 16px;
           }
           @media (max-width: 768px) {
               .pdf-container {
                   height: 400px;
               }
           }
           
           /* Fix horizontal overflow on responsive desktop */
           .main {
               overflow-x: hidden;
               max-width: 100%;
           }
           
           .dept-detail-header {
               position: relative;
               overflow: hidden;
               z-index: 1;
               border-radius: 20px;
               padding: 32px;
               border: 1px solid rgba(0,0,0,0.05);
               box-shadow: 0 4px 20px rgba(0,0,0,0.02);
           }
           .dept-detail-header::before {
               content: '';
               position: absolute;
               top: 0; left: 0; right: 0; bottom: 0;
               background-image: var(--bg-img);
               background-size: cover;
               background-position: center;
               opacity: 1;
               z-index: -2;
           }
           .dept-detail-header::after {
               content: '';
               position: absolute;
               top: 0; left: 0; right: 0; bottom: 0;
               background: linear-gradient(to right, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 40%, transparent 65%);
               backdrop-filter: blur(12px);
               -webkit-backdrop-filter: blur(12px);
               -webkit-mask-image: linear-gradient(to right, black 40%, transparent 65%);
               mask-image: linear-gradient(to right, black 40%, transparent 65%);
               z-index: -1;
           }
           
           .dept-detail-header .back-btn {
               display: inline-flex;
               align-items: center;
               gap: 8px;
               color: var(--text-muted);
               text-decoration: none;
               font-weight: 600;
               font-size: 14px;
               margin-bottom: 24px;
               transition: color 0.2s;
           }
           .dept-detail-header .back-btn:hover {
               color: var(--dept-theme);
           }
           
           .header-content {
               display: flex;
               align-items: center;
               gap: 24px;
           }
           
           .header-icon {
               width: 80px;
               height: 80px;
               background: rgba(255, 255, 255, 0.4);
               backdrop-filter: blur(8px);
               -webkit-backdrop-filter: blur(8px);
               border: 1px solid rgba(255, 255, 255, 0.9);
               border-radius: 22px;
               display: flex;
               align-items: center;
               justify-content: center;
               font-size: 38px;
               color: var(--dept-theme);
               box-shadow: 0 10px 30px rgba(0,0,0,0.06), inset 0 2px 4px rgba(255,255,255,0.8);
               animation: iconPop 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
               opacity: 0;
               transform: scale(0.5);
               transition: all 0.3s ease;
           }
           
           .header-icon:hover {
               background: rgba(255, 255, 255, 0.8);
               transform: scale(1.08) translateY(-4px) !important;
               box-shadow: 0 15px 35px rgba(0,0,0,0.12), inset 0 2px 4px rgba(255,255,255,0.9);
               color: var(--dept-theme);
           }
           
           @keyframes iconPop {
               0% { opacity: 0; transform: scale(0.5) rotate(-10deg) translateY(20px); }
               100% { opacity: 1; transform: scale(1) rotate(0deg) translateY(0); }
           }
           
           .header-content h2 {
               font-size: 32px;
               font-weight: 800;
               color: var(--text-main);
               margin: 0 0 4px 0;
           }
           
           .header-content p {
               color: var(--text-muted);
               font-size: 16px;
               margin: 0;
           }

           .dept-tabs {
               display: flex;
               overflow-x: auto;
               border-bottom: 2px solid var(--border-color);
               margin-top: 30px;
               gap: 12px;
               padding-bottom: 4px;
               width: 100%;
               max-width: 100%;
           }
           
           /* Styling scrollbar tab for webkit */
           .dept-tabs::-webkit-scrollbar {
               height: 6px;
           }
           .dept-tabs::-webkit-scrollbar-track {
               background: #f1f5f9;
               border-radius: 4px;
           }
           .dept-tabs::-webkit-scrollbar-thumb {
               background: #cbd5e1;
               border-radius: 4px;
           }
           .dept-tabs::-webkit-scrollbar-thumb:hover {
               background: #94a3b8;
           }
           .dept-tab-btn {
               padding: 12px 24px;
               background: transparent;
               border: none;
               font-family: 'Manrope', sans-serif;
               font-size: 15px;
               font-weight: 700;
               color: var(--text-muted);
               cursor: pointer;
               border-radius: 8px 8px 0 0;
               transition: all 0.3s ease;
               white-space: nowrap;
               position: relative;
           }
           .dept-tab-btn:hover {
               color: var(--purple-accent);
               background: rgba(107, 33, 168, 0.05);
           }
           .dept-tab-btn.active {
               color: var(--purple-accent);
           }
           .dept-tab-btn.active::after {
               content: '';
               position: absolute;
               bottom: -6px;
               left: 0;
               width: 100%;
               height: 4px;
               background: var(--purple-accent);
               border-radius: 4px 4px 0 0;
           }
           
           .dept-tab-content {
               display: none;
               padding: 30px 0;
               animation: fadeIn 0.4s ease forwards;
           }
           .dept-tab-content.active {
               display: block;
           }
           @keyframes fadeIn {
               from { opacity: 0; transform: translateY(10px); }
               to { opacity: 1; transform: translateY(0); }
           }

           /* Content Styling */
           .content-card {
               background: #fff;
               border-radius: 16px;
               padding: 32px;
               border: 1px solid var(--border-color);
               box-shadow: 0 4px 20px rgba(0,0,0,0.02);
           }
           .content-card h3 {
               font-size: 22px;
               font-weight: 800;
               color: var(--text-main);
               margin-top: 0;
               margin-bottom: 16px;
               display: flex;
               align-items: center;
               gap: 12px;
           }
           .content-card p {
               color: var(--text-muted);
               line-height: 1.7;
               font-size: 15px;
               margin-bottom: 16px;
           }
           .curriculum-table {
               width: 100%;
               border-collapse: collapse;
               margin-top: 20px;
           }
           .curriculum-table th, .curriculum-table td {
               padding: 14px 16px;
               border-bottom: 1px solid var(--border-color);
               text-align: left;
           }
           .curriculum-table th {
               background: #f8fafc;
               font-weight: 800;
               color: var(--text-main);
               font-size: 14px;
               text-transform: uppercase;
               letter-spacing: 0.5px;
           }
       </style>

       <!-- Tab Navigation -->
       <div class="dept-tabs">
           <button class="dept-tab-btn active" onclick="openTab(event, 'tab-vision')"><i class="fas fa-bullseye"></i> Vision & Mission</button>
           <button class="dept-tab-btn" onclick="openTab(event, 'tab-curriculum')"><i class="fas fa-book"></i> Curriculum</button>
           <button class="dept-tab-btn" onclick="openTab(event, 'tab-degree')"><i class="fas fa-graduation-cap"></i> Degree Requirement</button>
           <button class="dept-tab-btn" onclick="openTab(event, 'tab-advisors')"><i class="fas fa-user-tie"></i> Academic Advisors</button>
           <button class="dept-tab-btn" onclick="openTab(event, 'tab-resources')"><i class="fas fa-folder-open"></i> Resources</button>
       </div>

       <!-- 1. Vision & Mission -->
       <div id="tab-vision" class="dept-tab-content active">
           <?php renderDocs($docs_by_category['vision'], 'fa-bullseye', 'Vision & Mission', '#805ad5'); ?>
       </div>

       <!-- 2. Curriculum -->
       <div id="tab-curriculum" class="dept-tab-content">
           <?php renderDocs($docs_by_category['curriculum'], 'fa-book', 'Curriculum', '#3182ce'); ?>
       </div>

       <!-- 3. Degree Requirement -->
       <div id="tab-degree" class="dept-tab-content">
           <?php renderDocs($docs_by_category['degree'], 'fa-graduation-cap', 'Degree Requirement', '#27ae60'); ?>
       </div>

       <!-- 4. Academic Advisors -->
       <div id="tab-advisors" class="dept-tab-content">
           <?php renderDocs($docs_by_category['advisors'], 'fa-user-tie', 'Academic Advisors', '#dd6b20'); ?>
       </div>

       <!-- 5. Resources & Programs -->
       <div id="tab-resources" class="dept-tab-content">
           <?php renderDocs($docs_by_category['resources'], 'fa-folder-open', 'Resources & Programs', '#e53e3e'); ?>
       </div>

       <script>
       function openTab(evt, tabId) {
           // Hide all tab content
           var tabContents = document.getElementsByClassName("dept-tab-content");
           for (var i = 0; i < tabContents.length; i++) {
               tabContents[i].classList.remove("active");
           }

           // Remove "active" class from all tab buttons
           var tabBtns = document.getElementsByClassName("dept-tab-btn");
           for (var i = 0; i < tabBtns.length; i++) {
               tabBtns[i].classList.remove("active");
           }

           // Show the current tab, and add an "active" class to the button that opened the tab
           document.getElementById(tabId).classList.add("active");
           evt.currentTarget.classList.add("active");
       }
       </script>
    </div>
  </main>
  
  <script src="/assets/js/main.js"></script>
</body>
</html>
