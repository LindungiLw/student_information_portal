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

       <style>
           .modern-dept-grid {
               display: grid;
               grid-template-columns: repeat(3, 1fr);
               gap: 24px;
               margin-top: 30px;
           }
           
           .modern-dept-card {
               background: var(--card-bg);
               border: 1px solid var(--border-color);
               border-radius: 16px;
               overflow: hidden;
               transition: all 0.3s ease;
               display: flex;
               flex-direction: column;
           }
           
           .modern-dept-card:hover {
               transform: translateY(-5px);
               box-shadow: 0 12px 24px rgba(0,0,0,0.06);
               border-color: rgba(107, 33, 168, 0.2);
           }
           
           .modern-dept-img {
               width: 100%;
               height: 180px;
               object-fit: cover;
           }
           
           .modern-dept-content {
               padding: 24px;
               display: flex;
               flex-direction: column;
               flex: 1;
           }
           
           .modern-dept-tag {
               display: inline-flex;
               align-items: center;
               gap: 6px;
               font-size: 11px;
               font-weight: 800;
               color: var(--purple-accent);
               text-transform: uppercase;
               letter-spacing: 1px;
               margin-bottom: 12px;
           }
           
           .modern-dept-title {
               font-size: 18px;
               font-weight: 800;
               color: var(--text-main);
               margin-bottom: 10px;
               line-height: 1.3;
           }
           
           .modern-dept-desc {
               font-size: 14px;
               color: var(--text-muted);
               line-height: 1.6;
               margin-bottom: 24px;
               flex: 1;
           }
           
           .modern-dept-btn {
               display: flex;
               align-items: center;
               justify-content: center;
               gap: 8px;
               width: 100%;
               padding: 12px;
               background: rgba(107, 33, 168, 0.08);
               color: var(--purple-accent);
               text-decoration: none;
               font-weight: 700;
               font-size: 13px;
               border-radius: 10px;
               transition: all 0.2s ease;
           }
           
           .modern-dept-btn:hover {
               background: var(--purple-accent);
               color: white;
           }

           @media screen and (max-width: 1024px) {
               .modern-dept-grid {
                   grid-template-columns: repeat(2, 1fr);
               }
           }

           @media screen and (max-width: 768px) {
               .modern-dept-grid {
                   grid-template-columns: 1fr;
               }
           }
       </style>

       <div class="modern-dept-grid">
           <!-- Card 1: English Lit -->
           <div class="modern-dept-card">
               <img src="https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&w=600&q=80" alt="English Literature" class="modern-dept-img">
               <div class="modern-dept-content">
                   <div class="modern-dept-tag"><i class="fas fa-book-open"></i> HUMANITIES</div>
                   <h3 class="modern-dept-title">English Literature</h3>
                   <p class="modern-dept-desc">Master the beauty of the English language, classical literature, and modern linguistics.</p>
                   <a href="/pages/academics/department_detail.php?dept=english" class="modern-dept-btn">View Department <i class="fas fa-arrow-right"></i></a>
               </div>
           </div>

           <!-- Card 2: Japanese Lit -->
           <div class="modern-dept-card">
               <img src="https://images.unsplash.com/photo-1528360983277-13d401cdc186?auto=format&fit=crop&w=600&q=80" alt="Japanese Literature" class="modern-dept-img">
               <div class="modern-dept-content">
                   <div class="modern-dept-tag"><i class="fas fa-language"></i> LINGUISTICS</div>
                   <h3 class="modern-dept-title">Japanese Literature</h3>
                   <p class="modern-dept-desc">Master the Japanese language and its profound cultural heritage through historical and contemporary texts.</p>
                   <a href="/pages/academics/department_detail.php?dept=japanese" class="modern-dept-btn">View Department <i class="fas fa-arrow-right"></i></a>
               </div>
           </div>

           <!-- Card 3: Accounting -->
           <div class="modern-dept-card">
               <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=600&q=80" alt="Accounting" class="modern-dept-img">
               <div class="modern-dept-content">
                   <div class="modern-dept-tag"><i class="fas fa-calculator"></i> BUSINESS</div>
                   <h3 class="modern-dept-title">Accounting</h3>
                   <p class="modern-dept-desc">Gain professional expertise in financial reporting, auditing, strategic taxation, and corporate governance.</p>
                   <a href="/pages/academics/department_detail.php?dept=accounting" class="modern-dept-btn">View Department <i class="fas fa-arrow-right"></i></a>
               </div>
           </div>

           <!-- Card 4: VCD -->
           <div class="modern-dept-card">
               <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?auto=format&fit=crop&w=600&q=80" alt="Visual Communication Design" class="modern-dept-img">
               <div class="modern-dept-content">
                   <div class="modern-dept-tag"><i class="fas fa-palette"></i> CREATIVE ARTS</div>
                   <h3 class="modern-dept-title">Visual Communication Design</h3>
                   <p class="modern-dept-desc">Develop creative solutions through visual storytelling, branding, and human-centered design systems.</p>
                   <a href="/pages/academics/department_detail.php?dept=vcd" class="modern-dept-btn">View Department <i class="fas fa-arrow-right"></i></a>
               </div>
           </div>

           <!-- Card 5: Information Technology -->
           <div class="modern-dept-card">
               <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80" alt="Information Technology" class="modern-dept-img">
               <div class="modern-dept-content">
                   <div class="modern-dept-tag"><i class="fas fa-microchip"></i> ENGINEERING</div>
                   <h3 class="modern-dept-title">Information Technology</h3>
                   <p class="modern-dept-desc">Engineering the digital future through software development, network architecture, and cloud infrastructure.</p>
                   <a href="/pages/academics/department_detail.php?dept=it" class="modern-dept-btn">View Department <i class="fas fa-arrow-right"></i></a>
               </div>
           </div>

           <!-- Card 6: Information System -->
           <div class="modern-dept-card">
               <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=600&q=80" alt="Information Systems" class="modern-dept-img">
               <div class="modern-dept-content">
                   <div class="modern-dept-tag"><i class="fas fa-chart-network"></i> TECHNOLOGY & BUSINESS</div>
                   <h3 class="modern-dept-title">Information Systems</h3>
                   <p class="modern-dept-desc">Bridge the gap between organizational business needs and complex technical data solutions.</p>
                   <a href="/pages/academics/department_detail.php?dept=is" class="modern-dept-btn">View Department <i class="fas fa-arrow-right"></i></a>
               </div>
           </div>
       </div>

    </div>
  </main>
  <script src="/assets/js/main.js"></script>
</body>
</html>
