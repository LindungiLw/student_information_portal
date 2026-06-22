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
  <title>Academics | JIU Student Portal</title>
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
       <div class="section-header">
          <div class="section-title">
             <svg class="custom-icon"><use href="#icon-book"></use></svg> 
             Academic Policies and Procedures
          </div>
       </div>

       <!-- Bento Box Grid Layout -->
       <div class="policy-grid">
           <!-- Card 1 -->
           <div class="policy-card">
               <div class="policy-card-content">
                   <div class="policy-card-icon icon-purple">
                       <i class="fas fa-clock"></i>
                   </div>
                   <h3>Length of Study & Credits</h3>
                   <p>Regular undergraduate program spans <strong>8 to 10 semesters</strong>.<br><br>To graduate, students must complete a minimum of <strong>144 credits</strong>.</p>
               </div>
               <a href="javascript:void(0)" onclick="openPdfSection('Length of Undergraduate Study', 1)" class="policy-card-link">Read Full Details <i class="fas fa-arrow-right" style="font-size: 11px;"></i></a>
           </div>
           
           <!-- Card 2 -->
           <div class="policy-card">
               <div class="policy-card-content">
                   <div class="policy-card-icon icon-blue">
                       <i class="fas fa-user-check"></i>
                   </div>
                   <h3>Class Attendance</h3>
                   <p>Strict attendance required. A maximum of <strong>3 unauthorized absences</strong> is allowed per subject to qualify for final exams.<br><br>Medical/official leave requires documentation.</p>
               </div>
               <a href="javascript:void(0)" onclick="openPdfSection('Class Attendance', 2)" class="policy-card-link">Read Full Details <i class="fas fa-arrow-right" style="font-size: 11px;"></i></a>
           </div>

           <!-- Card 3 -->
           <div class="policy-card">
               <div class="policy-card-content">
                   <div class="policy-card-icon icon-orange">
                       <i class="fas fa-clipboard-list"></i>
                   </div>
                   <h3>Assessments & Exams</h3>
                   <p>Evaluated through Mid/Final exams, Quizzes, and Projects.<br><br><strong style="color:#e53e3e;">Strict Anti-Cheating Rule:</strong> Any violation automatically results in a failing grade.</p>
               </div>
               <a href="javascript:void(0)" onclick="openPdfSection('Assessment', 3)" class="policy-card-link">Read Full Details <i class="fas fa-arrow-right" style="font-size: 11px;"></i></a>
           </div>

           <!-- Card 4 -->
           <div class="policy-card">
               <div class="policy-card-content">
                   <div class="policy-card-icon icon-green">
                       <i class="fas fa-star"></i>
                   </div>
                   <h3>Grading & GPA</h3>
                   <ul>
                       <li><strong>A (4.0):</strong> Outstanding (85-100)</li>
                       <li><strong>C (2.0):</strong> Passing (55-59)</li>
                       <li><strong>Fail:</strong> Below 54.9</li>
                       <li style="margin-top:8px;"><strong>Cum Laude:</strong> GPA 3.75 - 4.00</li>
                   </ul>
               </div>
               <a href="javascript:void(0)" onclick="openPdfSection('Grading System', 4)" class="policy-card-link">Read Full Details <i class="fas fa-arrow-right" style="font-size: 11px;"></i></a>
           </div>

           <!-- Card 5 -->
           <div class="policy-card">
               <div class="policy-card-content">
                   <div class="policy-card-icon icon-teal">
                       <i class="fas fa-exchange-alt"></i>
                   </div>
                   <h3>Transfer & Leave</h3>
                   <p>Academic leave is permitted for up to <strong>2 semesters</strong>.<br><br><strong>Drop Out Rule:</strong> Triggers if cumulative GPA falls below 2.0 or earning < 30 credits after 4 semesters.</p>
               </div>
               <a href="javascript:void(0)" onclick="openPdfSection('Academic Leave', 5)" class="policy-card-link">Read Full Details <i class="fas fa-arrow-right" style="font-size: 11px;"></i></a>
           </div>

           <!-- Card 6 -->
           <div class="policy-card">
               <div class="policy-card-content">
                   <div class="policy-card-icon icon-pink">
                       <i class="fas fa-graduation-cap"></i>
                   </div>
                   <h3>Judicium & Graduation</h3>
                   <p>Requirements include:<br>- Fulfilling 144 credits without D/E<br>- Completing Thesis/Final Project<br>- Settling all financial obligations<br>- Minimum C on Internships</p>
               </div>
               <a href="javascript:void(0)" onclick="openPdfSection('Judicium', 6)" class="policy-card-link">Read Full Details <i class="fas fa-arrow-right" style="font-size: 11px;"></i></a>
           </div>
       </div>

       <!-- Full Document PDF Viewer Section -->
       <div class="section-header" style="margin-top: 40px;">
          <div class="section-title">
             <svg class="custom-icon"><use href="#icon-book"></use></svg> 
             Full Academic Policy Document
          </div>
       </div>
       <div class="custom-pdf-container">
           <!-- Custom Premium Header -->
           <div class="pdf-header">
               <div class="pdf-title">
                   <i class="fas fa-file-pdf" style="color: #e53e3e; font-size: 18px;"></i> 
                   Official Academic Guidelines
               </div>
               <div class="pdf-actions">
                   <a href="/assets/documents/Academics.pdf" download class="btn-download">
                       <svg class="custom-icon" style="width: 16px; height: 16px;"><use href="#icon-download"></use></svg> Download PDF
                   </a>
                   <a href="/assets/documents/Academics.docx" download class="btn-download">
                       <svg class="custom-icon" style="width: 16px; height: 16px;"><use href="#icon-download"></use></svg> Download DOCX
                   </a>
                   <button class="btn-fullscreen" onclick="document.getElementById('acad-pdf').requestFullscreen()">
                       <svg class="custom-icon" style="width: 16px; height: 16px;"><use href="#icon-expand"></use></svg> Fullscreen
                   </button>
               </div>
           </div>
           
           <!-- Iframe -->
           <div class="pdf-body" style="height: 800px;">
               <iframe id="acad-pdf" src="/assets/documents/Academics.pdf#toolbar=0&navpanes=0&view=FitH" width="100%" height="100%" style="border: none;">
                    <div style="padding: 2rem; text-align: center;">
                        <i class="fas fa-file-pdf" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                        <p>Your browser does not support PDF iframes.<br><a href="/assets/documents/Academics.pdf" target="_blank">Download Guidelines here</a></p>
                    </div>
               </iframe>
           </div>
       </div>

    </div>
  </main>
  
  <script>
    function openPdfSection(keyword, estimatedPage) {
        // 1. Scroll smooth ke container PDF
        const pdfContainer = document.querySelector('.custom-pdf-container');
        if(pdfContainer) {
            pdfContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            // Highlight effect sebentar
            pdfContainer.style.transition = "box-shadow 0.3s ease";
            pdfContainer.style.boxShadow = "0 0 0 4px var(--purple-accent)";
            setTimeout(() => {
                pdfContainer.style.boxShadow = "0 4px 15px rgba(0,0,0,0.02)";
            }, 1500);
        }

        // 2. Ganti URL iframe dengan parameter 'search' dan 'page'
        // Kita tambahkan parameter ?t=timestamp agar browser terpaksa memuat ulang iframe PDF dari awal
        // sehingga fitur lompat halaman dari plugin PDF bawaan browser benar-benar dieksekusi.
        const iframe = document.getElementById('acad-pdf');
        if(iframe) {
            const baseUrl = '/assets/documents/Academics.pdf';
            const timestamp = new Date().getTime();
            // Format yang diwajibkan oleh PDF viewer browser (harus ada ? lalu #)
            iframe.src = `${baseUrl}?t=${timestamp}#toolbar=0&navpanes=0&view=FitH&search=${encodeURIComponent(keyword)}&page=${estimatedPage}`;
        }
    }
  </script>
  <script src="/assets/js/main.js"></script>
</body>
</html>
