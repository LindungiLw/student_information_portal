<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Services | JIU Student Portal</title>
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
       <div class="section-header" style="flex-direction: column; align-items: flex-start; gap: 8px;">
          <div class="section-title" style="font-size: 28px;">
             <i class="fas fa-hands-helping" style="color: var(--purple-accent); margin-right: 12px;"></i> Student Services
          </div>
          <p style="color: var(--text-muted); font-size: 15px; margin: 0;">Comprehensive support services to ensure your success, well-being, and comfortable campus life.</p>
       </div>

       <!-- Grid Cards (Kotak dengan gambar Bulat) -->
       <div class="services-grid">
           
           <a href="/pages/services/dormitory.php" class="service-tile">
               <div class="service-shape">
                   <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Dormitory">
               </div>
               <h3>Dormitory</h3>
           </a>

           <a href="/pages/services/library.php" class="service-tile">
               <div class="service-shape">
                   <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Library">
               </div>
               <h3>Library</h3>
           </a>

           <a href="/pages/services/counseling.php" class="service-tile">
               <div class="service-shape">
                   <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Counseling">
               </div>
               <h3>Counseling</h3>
           </a>

           <a href="/pages/services/forms.php" class="service-tile">
               <div class="service-shape">
                   <img src="https://images.unsplash.com/photo-1568225367111-4405249a514c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Forms">
               </div>
               <h3>Forms</h3>
           </a>

           <a href="/pages/services/feedback.php" class="service-tile">
               <div class="service-shape">
                   <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Feedback and Report">
               </div>
               <h3>Feedback and Report</h3>
           </a>

       </div>
    </div>
  </main>
  
  <script src="/assets/js/main.js"></script>
</body>
</html>
