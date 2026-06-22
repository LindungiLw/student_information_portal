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
  <title>External Activities | JIU Student Portal</title>
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
             <i class="fas fa-globe-americas" style="color: var(--purple-accent); margin-right: 12px;"></i> External Activities
          </div>
          <p style="color: var(--text-muted); font-size: 15px; margin: 0;">Broaden your horizons through global exchanges, professional internships, and service scholarships.</p>
       </div>

       <!-- Horizontal Cards Container (Menggunakan style premium dari urusan Student Affairs) -->
       <div class="affairs-container">
           
           <!-- Program 1: Student Exchange -->
           <div class="affairs-card" onclick="window.location.href='/pages/external_programs/exchange_program.php'" style="cursor: pointer;">
               <div class="affairs-img-wrapper">
                   <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Student Exchange Program">
               </div>
               <div class="affairs-content">
                   <div class="affairs-badge" style="background: rgba(49, 130, 206, 0.1); color: #3182ce;">Global Experience</div>
                   <h2 style="color: #1e293b;">Student Exchange Program</h2>
                   <p>Discover the world and expand your academic boundaries. Join our international exchange programs and study abroad for a semester.</p>
                   <p><strong>Status:</strong> Applications open for Spring 2026</p>
               </div>
           </div>

           <!-- Program 2: Internship -->
           <div class="affairs-card" onclick="window.location.href='/pages/external_programs/internship.php'" style="cursor: pointer;">
               <div class="affairs-img-wrapper">
                   <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Internship Program">
               </div>
               <div class="affairs-content">
                   <div class="affairs-badge" style="background: rgba(221, 107, 32, 0.1); color: #dd6b20;">Career Prep</div>
                   <h2 style="color: #1e293b;">Internship</h2>
                   <p>Gain real-world industry experience before you graduate. We partner with top companies to provide meaningful internship opportunities for our students.</p>
                   <p><strong>Status:</strong> Career fair upcoming next month</p>
               </div>
           </div>

           <!-- Program 3: Student Service Scholarship -->
           <div class="affairs-card" onclick="window.location.href='/pages/external_programs/scholarship.php'" style="cursor: pointer;">
               <div class="affairs-img-wrapper">
                   <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Student Service Scholarship">
               </div>
               <div class="affairs-content">
                   <div class="affairs-badge" style="background: rgba(56, 161, 105, 0.1); color: #38a169;">Financial Aid & Service</div>
                   <h2 style="color: #1e293b;">Student Service Scholarship</h2>
                   <p>Give back to the JIU community while earning a scholarship. This program rewards students who contribute actively to campus life and services.</p>
                   <p><strong>Status:</strong> Accepting proposals</p>
               </div>
           </div>

       </div>
    </div>
  </main>
  
  <script src="/assets/js/main.js"></script>
</body>
</html>
