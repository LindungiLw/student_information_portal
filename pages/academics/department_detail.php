<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

$dept_id = isset($_GET['dept']) ? $_GET['dept'] : 'is';

// Data Jurusan dinamis
$departments = [
    'english' => ['name' => 'English Literature', 'color' => '#d53f8c', 'icon' => 'fa-book-reader'],
    'japanese' => ['name' => 'Japanese Literature', 'color' => '#e53e3e', 'icon' => 'fa-torii-gate'],
    'accounting' => ['name' => 'Accounting', 'color' => '#3182ce', 'icon' => 'fa-chart-pie'],
    'vcd' => ['name' => 'Visual Communication Design', 'color' => '#805ad5', 'icon' => 'fa-palette'],
    'it' => ['name' => 'Information Technology', 'color' => '#00b5d8', 'icon' => 'fa-network-wired'],
    'is' => ['name' => 'Information System', 'color' => '#dd6b20', 'icon' => 'fa-laptop-code']
];

if (!array_key_exists($dept_id, $departments)) {
    $dept_id = 'is';
}

$current_dept = $departments[$dept_id];
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
  <link rel="stylesheet" href="/assets/css/dashboard.css">
  <link rel="stylesheet" href="/assets/css/sidebar.css">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  
  <main class="main">
    <div class="bottom-dashboard-section" style="padding-top: 20px;">
        
       <!-- Back Button & Header -->
       <div class="dept-detail-header" style="--dept-theme: <?php echo $current_dept['color']; ?>">
           <a href="/pages/academics/department.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Departments</a>
           <div class="header-content">
               <div class="header-icon"><i class="fas <?php echo $current_dept['icon']; ?>"></i></div>
               <div>
                   <h2><?php echo $current_dept['name']; ?></h2>
                   <p>Department Information Portal</p>
               </div>
           </div>
       </div>

       <!-- Tambahkan CSS Khusus untuk Halaman Ini -->
       <style>
           .modern-detail-grid {
               display: grid;
               grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
               gap: 24px;
               margin-top: 30px;
           }

           .detail-card {
               background: var(--card-bg);
               border: 1px solid var(--border-color);
               border-radius: 16px;
               overflow: hidden;
               text-decoration: none;
               display: flex;
               flex-direction: column;
               transition: all 0.3s ease;
               box-shadow: var(--shadow-sm);
           }

           .detail-card:hover {
               transform: translateY(-5px);
               box-shadow: 0 12px 24px rgba(0,0,0,0.06);
               border-color: rgba(107, 33, 168, 0.2);
           }

           .detail-img-wrap {
               width: 100%;
               height: 180px;
               overflow: hidden;
               background-color: var(--border-color); /* Fallback color */
           }

           .detail-img-wrap img {
               width: 100%;
               height: 100%;
               object-fit: cover;
               transition: transform 0.5s ease;
           }

           .detail-card:hover .detail-img-wrap img {
               transform: scale(1.05);
           }

           .detail-content {
               padding: 24px;
               display: flex;
               flex-direction: column;
               flex: 1;
           }

           .detail-title {
               font-size: 18px;
               font-weight: 800;
               color: var(--text-main);
               margin-bottom: 10px;
               transition: color 0.3s ease;
           }

           .detail-card:hover .detail-title {
               color: var(--purple-accent);
           }

           .detail-desc {
               font-size: 14px;
               color: var(--text-muted);
               line-height: 1.6;
               margin: 0;
           }
           
           .detail-icon-badge {
               width: 40px;
               height: 40px;
               background: rgba(107, 33, 168, 0.08);
               color: var(--purple-accent);
               border-radius: 10px;
               display: flex;
               align-items: center;
               justify-content: center;
               font-size: 18px;
               margin-bottom: 16px;
           }
       </style>

       <!-- Grid Section -->
       <div class="modern-detail-grid">
           
           <!-- 1. Vision & Mission -->
           <a href="#" class="detail-card">
               <div class="detail-img-wrap">
                   <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=600&q=80" alt="Vision & Mission">
               </div>
               <div class="detail-content">
                   <div class="detail-icon-badge"><i class="fas fa-bullseye"></i></div>
                   <h3 class="detail-title">Vision & Mission</h3>
                   <p class="detail-desc">Discover the core values, long-term vision, and educational goals of the <?php echo strtoupper($dept_id); ?> department.</p>
               </div>
           </a>

           <!-- 2. Curriculum -->
           <a href="#" class="detail-card">
               <div class="detail-img-wrap">
                   <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=600&q=80" alt="Curriculum">
               </div>
               <div class="detail-content">
                   <div class="detail-icon-badge"><i class="fas fa-book"></i></div>
                   <h3 class="detail-title">Curriculum</h3>
                   <p class="detail-desc">Explore the complete course structure and syllabus organized by academic batch (2022 - 2025).</p>
               </div>
           </a>

           <!-- 3. Degree Requirement -->
           <a href="#" class="detail-card">
               <div class="detail-img-wrap">
                   <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&q=80" alt="Degree requirement">
               </div>
               <div class="detail-content">
                   <div class="detail-icon-badge"><i class="fas fa-graduation-cap"></i></div>
                   <h3 class="detail-title">Degree Requirement</h3>
                   <p class="detail-desc">A comprehensive checklist of credits, thesis guidelines, and requirements for graduation.</p>
               </div>
           </a>

           <!-- 4. Academic Advisors -->
           <a href="#" class="detail-card">
               <div class="detail-img-wrap">
                   <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?auto=format&fit=crop&w=600&q=80" alt="Academic Advisors">
               </div>
               <div class="detail-content">
                   <div class="detail-icon-badge"><i class="fas fa-user-tie"></i></div>
                   <h3 class="detail-title">Academic Advisors</h3>
                   <p class="detail-desc">Find your assigned academic advisor and schedule mentoring or consultation sessions.</p>
               </div>
           </a>

           <!-- 5. Additional Programs/ Resources -->
           <a href="#" class="detail-card">
               <div class="detail-img-wrap">
                   <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=600&q=80" alt="Additional Programs/ Resources">
               </div>
               <div class="detail-content">
                   <div class="detail-icon-badge"><i class="fas fa-folder-open"></i></div>
                   <h3 class="detail-title">Resources & Programs</h3>
                   <p class="detail-desc">Access exclusive <?php echo strtoupper($dept_id); ?> digital libraries, software licenses, and extracurricular programs.</p>
               </div>
           </a>

       </div>
    </div>
  </main>
  
  <script src="/assets/js/main.js"></script>
</body>
</html>
