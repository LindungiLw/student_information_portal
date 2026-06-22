<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
$current_page = 'student_services.php'; // Keep sidebar active on Student Services
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Library | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css">
  <link rel="stylesheet" href="/assets/css/sidebar.css">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <style>
      .key-info-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
          gap: 24px;
          margin-top: 20px;
      }
      .info-box {
          background: #fff;
          border-radius: 24px;
          padding: 30px;
          border: 1px solid var(--border-color);
          box-shadow: 0 4px 15px rgba(0,0,0,0.02);
          transition: transform 0.3s;
      }
      .info-box:hover {
          transform: translateY(-4px);
          box-shadow: 0 12px 30px rgba(0,0,0,0.05);
      }
      .info-icon {
          width: 48px;
          height: 48px;
          background: rgba(14, 165, 233, 0.1);
          color: #0ea5e9;
          border-radius: 14px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 20px;
          margin-bottom: 20px;
      }
      .info-box h4 {
          font-size: 20px;
          font-weight: 800;
          color: #1e293b;
          margin: 0 0 16px 0;
          letter-spacing: -0.3px;
      }
      .info-box h5 {
          font-size: 14px;
          font-weight: 700;
          color: #475569;
          text-transform: uppercase;
          letter-spacing: 1px;
          margin: 0 0 8px 0;
      }
      .info-box p {
          font-size: 14px;
          color: #64748b;
          line-height: 1.6;
          margin: 0 0 16px 0;
      }
      .info-box p.note {
          font-size: 12px;
          font-style: italic;
          color: #94a3b8;
          margin: 0;
      }
      .info-box ul {
          padding-left: 20px;
          margin: 0;
          color: #64748b;
          font-size: 14px;
          line-height: 1.7;
      }
      .info-box ul li {
          margin-bottom: 8px;
      }
      .info-box ul li strong {
          color: #334155;
      }
      .points-grid {
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
          gap: 12px;
          margin-top: 20px;
      }
      .points-item {
          background: #f8fafc;
          padding: 12px 16px;
          border-radius: 12px;
          display: flex;
          align-items: center;
          gap: 12px;
          font-size: 13px;
          color: #475569;
          font-weight: 600;
      }
      .pts-badge {
          background: #0ea5e9;
          color: #fff;
          padding: 4px 8px;
          border-radius: 8px;
          font-size: 12px;
          font-weight: 800;
      }
      .contact-links p {
          font-size: 15px;
          margin-bottom: 10px;
      }
      .contact-links a {
          color: #0ea5e9;
          text-decoration: none;
          font-weight: 600;
      }
      .contact-links a:hover {
          text-decoration: underline;
      }
  </style>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  
  <main class="main">
    <div class="bottom-dashboard-section" style="padding-top: 20px;">
       <div style="margin-bottom: 30px;">
           <a href="/pages/services/student_services.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Student Services</a>
       </div>

       <!-- Section 1: Library User Guide (PDF) -->
       <h3 style="margin-bottom: 20px; font-size: 26px; color: #1e293b; font-weight: 800; letter-spacing: -0.5px;">Library User Guide</h3>
       
       <div class="custom-pdf-container" id="library-pdf-container">
           <div class="pdf-header">
               <div class="pdf-title">
                   <i class="fas fa-file-pdf"></i> <span>JIU Library Guide Book</span>
               </div>
               <div class="pdf-actions">
                   <a href="/assets/documents/library/JIU LIBRARY GUIDE BOOK.pdf" download class="pdf-btn pdf-btn-outline">
                       <i class="fas fa-download"></i> Download PDF
                   </a>
                   <button class="pdf-btn pdf-btn-primary" onclick="toggleFullscreen('library-pdf-container')">
                       <i class="fas fa-expand"></i> Fullscreen
                   </button>
               </div>
           </div>
           
           <div class="pdf-body">
               <iframe 
                   src="/assets/documents/library/JIU LIBRARY GUIDE BOOK.pdf#toolbar=0&navpanes=0&view=FitH" 
                   type="application/pdf">
               </iframe>
           </div>
       </div>

       <!-- Section 2: Key Information -->
       <h3 style="margin: 50px 0 20px 0; font-size: 26px; color: #1e293b; font-weight: 800; letter-spacing: -0.5px;">Key Information</h3>
       
       <div class="key-info-grid">
           <!-- Card 1: Operation Hours -->
           <div class="info-box">
              <div class="info-icon"><i class="fas fa-clock"></i></div>
              <h4>Operation Hour</h4>
              <h5>Semester Operation Hour</h5>
              <p>
                  <strong>Mon - Fri:</strong> 8:00am - 5:00pm, 6:00pm - 9:00pm<br>
                  <strong>Saturday:</strong> 8:00am - 5:00pm<br>
                  <strong>Sunday:</strong> Closed
              </p>
              <h5>Vacation Operation Hour</h5>
              <p>
                  <strong>Mon - Fri:</strong> 8:00am - 5:00pm<br>
                  <strong>Sat, Sun:</strong> Closed
              </p>
              <p class="note"><i class="fas fa-info-circle"></i> Subject to change. Updates announced on Instagram.</p>
           </div>

           <!-- Card 2: Borrowing Rules -->
           <div class="info-box">
              <div class="info-icon"><i class="fas fa-book-reader"></i></div>
              <h4>How to borrow books?</h4>
              <ul>
                 <li>You can borrow <strong>5 books for 14 days</strong>.</li>
                 <li>During the vacation, you can borrow up to <strong>7 books</strong>.</li>
                 <li>Extension requests are subject to availability.</li>
                 <li>Late fee applies: <strong>Rp 1.000 / day / book</strong>.</li>
                 <li>Please reach out to the librarian to book study rooms.</li>
              </ul>
           </div>

           <!-- Card 3: Point System (Spans 2 columns on desktop if space allows) -->
           <div class="info-box" style="grid-column: 1 / -1;">
              <div class="info-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;"><i class="fas fa-star"></i></div>
              <h4>Library Point System</h4>
              <p style="font-size: 15px; color: #334155;">Library is running a point system to encourage students to engage in various library programs. Each semester, two students will win a voucher to buy books <strong>(Rp 250.000/student)</strong>. Reading Ambassador will get an opportunity to order books for the library <strong>(Rp 500.000)</strong>.</p>
              
              <div class="points-grid">
                  <div class="points-item"><span class="pts-badge">10 pts</span> Write a short story (fiction)</div>
                  <div class="points-item"><span class="pts-badge">10 pts</span> Join library event</div>
                  <div class="points-item"><span class="pts-badge">10 pts</span> Feature on library IG</div>
                  <div class="points-item"><span class="pts-badge">10 pts</span> Fill library survey</div>
                  <div class="points-item"><span class="pts-badge" style="background: #8b5cf6;">3 pts</span> Borrow DVD</div>
                  <div class="points-item"><span class="pts-badge" style="background: #10b981;">2 pts</span> Borrow or extend books</div>
                  <div class="points-item"><span class="pts-badge" style="background: #10b981;">2 pts</span> Healing Corner items</div>
                  <div class="points-item"><span class="pts-badge" style="background: #64748b;">1 pt</span> Visiting</div>
              </div>
           </div>

           <!-- Card 4: Contact -->
           <div class="info-box" style="grid-column: 1 / -1; display: flex; align-items: center; gap: 30px;">
              <div class="info-icon" style="margin: 0; width: 64px; height: 64px; font-size: 28px; background: rgba(236, 72, 153, 0.1); color: #ec4899;"><i class="fas fa-id-badge"></i></div>
              <div class="contact-links" style="display: flex; gap: 40px; flex-wrap: wrap;">
                 <p style="margin: 0;"><strong>Librarian:</strong> Sena Afrina Simbolon <br><a href="mailto:sena44@k-eduplex.net"><i class="fas fa-envelope"></i> sena44@k-eduplex.net</a></p>
                 <p style="margin: 0;"><strong>Instagram:</strong> <br><a href="https://instagram.com/jiulibrary" target="_blank"><i class="fab fa-instagram"></i> @jiulibrary</a></p>
                 <p style="margin: 0;"><strong>Linktree:</strong> <br><a href="https://linktr.ee/jiulibrary" target="_blank"><i class="fas fa-link"></i> linktr.ee/jiulibrary</a></p>
              </div>
           </div>
       </div>

    </div>
  </main>
  
  <script>
    function toggleFullscreen(containerId) {
        const container = document.getElementById(containerId);
        if (!document.fullscreenElement) {
            if (container.requestFullscreen) {
                container.requestFullscreen();
            } else if (container.webkitRequestFullscreen) {
                container.webkitRequestFullscreen();
            } else if (container.msRequestFullscreen) {
                container.msRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }
  </script>
  <script src="/assets/js/main.js"></script>
</body>
</html>
