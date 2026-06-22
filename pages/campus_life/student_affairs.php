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
  <title>Student Affairs | JIU Student Portal</title>
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
             <i class="fas fa-users" style="color: var(--purple-accent); margin-right: 12px;"></i> Student Affairs
          </div>
          <p style="color: var(--text-muted); font-size: 15px; margin: 0;">Explore your passions, join student clubs, and connect with the Student Union.</p>
       </div>

       <!-- Horizontal Cards Container -->
       <div class="affairs-container">
           
           <!-- Club Activities -->
           <div class="affairs-card">
               <div class="affairs-img-wrapper">
                   <!-- Fallback Unsplash image for Soccer/Clubs -->
                   <img src="https://images.unsplash.com/photo-1526232761682-d26e03ac148e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Club Activities">
               </div>
               <div class="affairs-content">
                   <div class="affairs-badge">Student Life</div>
                   <h2>Club Activities</h2>
                   <p>Explore your passions! A wide variety of student clubs are waiting for you. Stay tuned for registration details.</p>
               </div>
           </div>

           <!-- Student Union -->
           <div class="affairs-card">
               <div class="affairs-img-wrapper">
                   <!-- Fallback Unsplash image for Student Union/Lounge -->
                   <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Student Union">
               </div>
               <div class="affairs-content">
                   <div class="affairs-badge">Organization</div>
                   <h2>Student Union</h2>
                   <p>President: <strong>Lubiyani Tiiyo</strong></p>
                   <p>Vice President: <strong>Fadhil Ramadianshah</strong></p>
               </div>
           </div>

       </div>
    </div>
  </main>
  
  <script src="/assets/js/main.js"></script>
</body>
</html>
