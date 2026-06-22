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

       <!-- The 5 Sections Grid -->
       <div class="dept-info-container">
           
           <!-- Top Row: 3 Cards -->
           <div class="dept-info-grid top-row">
               
               <!-- 1. Vision & Mission -->
               <a href="#" class="info-card">
                   <div class="img-wrapper">
                       <!-- Placeholder image for Vision -->
                       <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Vision & Mission">
                   </div>
                   <div class="text-wrapper">
                       <h3 class="purple-link">Vision & Mission</h3>
                       <p>Vision, Mission, and Goal of <?php echo strtoupper($dept_id); ?> department</p>
                   </div>
               </a>

               <!-- 2. Curriculum -->
               <a href="#" class="info-card">
                   <div class="img-wrapper">
                       <!-- Placeholder image for Curriculum -->
                       <img src="https://images.unsplash.com/photo-1512758684632-a2530dbbe707?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Curriculum">
                   </div>
                   <div class="text-wrapper">
                       <h3 class="purple-link">Curriculum</h3>
                       <p>Curriculum by batch<br>(2022 batch to 2025 batch)</p>
                   </div>
               </a>

               <!-- 3. Degree Requirement -->
               <a href="#" class="info-card">
                   <div class="img-wrapper">
                       <!-- Placeholder image for Degree Requirement -->
                       <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Degree requirement">
                   </div>
                   <div class="text-wrapper">
                       <h3 class="purple-link">Degree requirement</h3>
                       <p>Checklist for graduation and academic completion</p>
                   </div>
               </a>

           </div>

           <!-- Bottom Row: 2 Cards (Centered) -->
           <div class="dept-info-grid bottom-row">
               
               <!-- 4. Academic Advisors -->
               <a href="#" class="info-card">
                   <div class="img-wrapper">
                       <!-- Placeholder image for Academic Advisors -->
                       <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Academic Advisors">
                   </div>
                   <div class="text-wrapper">
                       <h3 class="purple-link">Academic Advisors</h3>
                       <p>Advisor Assignments</p>
                   </div>
               </a>

               <!-- 5. Additional Programs/ Resources -->
               <a href="#" class="info-card">
                   <div class="img-wrapper">
                       <!-- Placeholder image for Resources -->
                       <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Additional Programs/ Resources">
                   </div>
                   <div class="text-wrapper">
                       <h3 class="purple-link">Additional Programs/ Resources</h3>
                       <p>Access to the <?php echo strtoupper($dept_id); ?> resources folder</p>
                   </div>
               </a>

           </div>

       </div>
    </div>
  </main>
  
  <script src="/assets/js/main.js"></script>
</body>
</html>
