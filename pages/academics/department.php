<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Department | JIU Student Portal</title>
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
       <div class="section-header" style="flex-direction: column; align-items: flex-start; gap: 8px; border-bottom: none; margin-bottom: 0;">
          <div class="section-title" style="font-size: 28px;">
             <i class="fas fa-university" style="color: var(--purple-accent); margin-right: 12px;"></i> Academic Departments
          </div>
          <p style="color: var(--text-muted); font-size: 15px; margin: 0;">Explore the 6 major study programs offered at Jakarta International University.</p>
       </div>

       <div class="dept-grid">
           <!-- Card 1: English Lit -->
           <a href="/pages/academics/department_detail.php?dept=english" class="dept-card" style="--dept-color: #d53f8c; background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');">
               <div class="dept-bg-icon"><i class="fas fa-book-reader"></i></div>
               <div class="dept-icon"><i class="fas fa-book-reader"></i></div>
               <div class="dept-content">
                   <h3>English Literature</h3>
                   <p>Master the beauty of the English language, classical literature, and modern linguistics.</p>
               </div>
               <div class="dept-arrow"><i class="fas fa-arrow-right"></i></div>
           </a>

           <!-- Card 2: Japanese Lit -->
           <a href="/pages/academics/department_detail.php?dept=japanese" class="dept-card" style="--dept-color: #e53e3e; background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');">
               <div class="dept-bg-icon"><i class="fas fa-torii-gate"></i></div>
               <div class="dept-icon"><i class="fas fa-torii-gate"></i></div>
               <div class="dept-content">
                   <h3>Japanese Literature</h3>
                   <p>Explore the depths of Japanese culture, history, and profound literary arts.</p>
               </div>
               <div class="dept-arrow"><i class="fas fa-arrow-right"></i></div>
           </a>

           <!-- Card 3: Accounting -->
           <a href="/pages/academics/department_detail.php?dept=accounting" class="dept-card" style="--dept-color: #3182ce; background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');">
               <div class="dept-bg-icon"><i class="fas fa-chart-pie"></i></div>
               <div class="dept-icon"><i class="fas fa-chart-pie"></i></div>
               <div class="dept-content">
                   <h3>Accounting</h3>
                   <p>Develop expertise in financial management, auditing, and corporate accounting.</p>
               </div>
               <div class="dept-arrow"><i class="fas fa-arrow-right"></i></div>
           </a>

           <!-- Card 4: VCD -->
           <a href="/pages/academics/department_detail.php?dept=vcd" class="dept-card" style="--dept-color: #805ad5; background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');">
               <div class="dept-bg-icon"><i class="fas fa-palette"></i></div>
               <div class="dept-icon"><i class="fas fa-palette"></i></div>
               <div class="dept-content">
                   <h3>Visual Communication Design</h3>
                   <p>Unleash your creativity through digital arts, multimedia, and graphic design.</p>
               </div>
               <div class="dept-arrow"><i class="fas fa-arrow-right"></i></div>
           </a>

           <!-- Card 5: Information Technology -->
           <a href="/pages/academics/department_detail.php?dept=it" class="dept-card" style="--dept-color: #00b5d8; background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');">
               <div class="dept-bg-icon"><i class="fas fa-network-wired"></i></div>
               <div class="dept-icon"><i class="fas fa-network-wired"></i></div>
               <div class="dept-content">
                   <h3>Information Technology</h3>
                   <p>Build the future with advanced networking, cybersecurity, and cloud computing.</p>
               </div>
               <div class="dept-arrow"><i class="fas fa-arrow-right"></i></div>
           </a>

           <!-- Card 6: Information System -->
           <a href="/pages/academics/department_detail.php?dept=is" class="dept-card" style="--dept-color: #dd6b20; background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80');">
               <div class="dept-bg-icon"><i class="fas fa-laptop-code"></i></div>
               <div class="dept-icon"><i class="fas fa-laptop-code"></i></div>
               <div class="dept-content">
                   <h3>Information System</h3>
                   <p>Bridge the gap between business processes and cutting-edge software solutions.</p>
               </div>
               <div class="dept-arrow"><i class="fas fa-arrow-right"></i></div>
           </a>
       </div>

    </div>
  </main>
  <script src="/assets/js/main.js"></script>
</body>
</html>
