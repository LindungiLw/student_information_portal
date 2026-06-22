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
  <title>Forms | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css">
  <link rel="stylesheet" href="/assets/css/sidebar.css">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <style>
      .page-intro {
          margin-bottom: 40px;
      }
      .page-intro h1 {
          font-size: 36px;
          font-weight: 800;
          color: #1e293b;
          margin: 0 0 10px 0;
          letter-spacing: -1px;
      }
      .page-intro p {
          font-size: 16px;
          color: #64748b;
          margin: 0;
      }

      /* Modern Steps Timeline */
      .steps-timeline {
          display: flex;
          gap: 24px;
          margin-bottom: 50px;
          flex-wrap: wrap;
      }
      .step-card {
          flex: 1;
          min-width: 250px;
          background: #ffffff;
          border-radius: 24px;
          padding: 30px;
          border: 1px solid var(--border-color);
          box-shadow: 0 4px 20px rgba(0,0,0,0.02);
          position: relative;
          overflow: hidden;
          transition: transform 0.3s;
      }
      .step-card:hover {
          transform: translateY(-4px);
          box-shadow: 0 12px 30px rgba(0,0,0,0.04);
      }
      .step-number {
          position: absolute;
          bottom: -20px;
          right: -10px;
          font-size: 120px;
          font-weight: 800;
          color: #f1f5f9; /* Very subtle background text */
          z-index: 0;
          line-height: 1;
      }
      .step-card h5 {
          position: relative;
          z-index: 1;
          color: #ec4899; /* Pink accent */
          font-weight: 800;
          margin: 0 0 12px 0;
          font-size: 15px;
          text-transform: uppercase;
          letter-spacing: 1px;
      }
      .step-card p {
          position: relative;
          z-index: 1;
          color: #334155;
          font-size: 15px;
          margin: 0;
          line-height: 1.6;
          font-weight: 500;
      }

      /* Compact Horizontal Grid for Forms (Flat Style) */
      .forms-horizontal-grid {
          display: grid;
          grid-template-columns: repeat(4, 1fr);
          gap: 16px;
      }
      .flat-compact-card {
          background: #ffffff;
          border: 1px solid var(--border-color);
          border-radius: 16px;
          padding: 24px 16px;
          text-decoration: none;
          color: inherit;
          display: flex;
          flex-direction: column;
          align-items: center;
          text-align: center;
          transition: background-color 0.2s ease, border-color 0.2s ease;
      }
      .flat-compact-card:hover {
          background-color: #f8fafc;
          border-color: #cbd5e1;
      }
      .fcc-icon {
          width: 52px;
          height: 52px;
          border-radius: 14px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 24px;
          margin-bottom: 16px;
      }
      .icon-docs { color: #4285F4; background: rgba(66, 133, 244, 0.1); }
      .icon-sheets { color: #0F9D58; background: rgba(15, 157, 88, 0.1); }
      .icon-pdf { color: #EA4335; background: rgba(234, 67, 53, 0.1); }

      .fcc-text {
          flex-grow: 1; /* allow text to fill space */
      }
      .fcc-text h4 {
          margin: 0 0 8px 0;
          font-size: 15px;
          font-weight: 800;
          color: #1e293b;
          line-height: 1.3;
          letter-spacing: -0.2px;
      }
      .fcc-text p {
          margin: 0;
          font-size: 12px;
          color: #64748b;
          line-height: 1.5;
          /* Truncate text beautifully to max 3 lines */
          display: -webkit-box;
          -webkit-line-clamp: 3;
          -webkit-box-orient: vertical;  
          overflow: hidden;
      }

      .fcc-action {
          margin-top: 16px;
          padding-top: 16px;
          width: 100%;
          border-top: 1px solid #f1f5f9;
          font-weight: 800;
          font-size: 13px;
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 6px;
      }
      .icon-docs-text { color: #4285F4; }
      .icon-sheets-text { color: #0F9D58; }
      .icon-pdf-text { color: #EA4335; }
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

       <div class="page-intro">
           <h1>Administrative Forms</h1>
           <p>Download, fill, and submit official university forms for your academic and service needs.</p>
       </div>

       <!-- Section 1: Modern Instructions Timeline -->
       <h3 style="margin-bottom: 20px; font-size: 22px; color: #1e293b; font-weight: 800;">How to use Google Forms?</h3>
       <div class="steps-timeline">
           <div class="step-card">
               <div class="step-number">1</div>
               <h5>Copy File</h5>
               <p>Go to <strong>File > Make a Copy</strong>. Save it directly to your personal Google Drive folder.</p>
           </div>
           <div class="step-card">
               <div class="step-number">2</div>
               <h5>Fill Data</h5>
               <p>Open the copied file from your Drive and fill in all the required information accurately.</p>
           </div>
           <div class="step-card">
               <div class="step-number">3</div>
               <h5>Share & Submit</h5>
               <p><strong>Option A:</strong> Share Docs Link (File > Share > Copy link)<br><br><strong>Option B:</strong> Download as PDF/Word and submit the file.</p>
           </div>
       </div>

       <!-- Section 2: Minimalist Horizontal Forms Grid -->
       <h3 style="margin-bottom: 24px; font-size: 22px; color: #1e293b; font-weight: 800;">Available Forms</h3>
       
       <div class="forms-horizontal-grid">
           <!-- Form 1 -->
           <a href="#" class="flat-compact-card" target="_blank">
               <div class="fcc-icon icon-docs">
                   <i class="fas fa-file-word"></i>
               </div>
               <div class="fcc-text">
                   <h4>SSS Agreement</h4>
                   <p>Student Service Scholarship program agreement form.</p>
               </div>
               <div class="fcc-action icon-docs-text">
                   Akses <i class="fas fa-arrow-right"></i>
               </div>
           </a>

           <!-- Form 2 -->
           <a href="#" class="flat-compact-card" target="_blank">
               <div class="fcc-icon icon-sheets">
                   <i class="fas fa-file-excel"></i>
                   </div>
               <div class="fcc-text">
                   <h4>Service Report</h4>
                   <p>Report form for student service activities.</p>
               </div>
               <div class="fcc-action icon-sheets-text">
                   Akses <i class="fas fa-arrow-right"></i>
               </div>
           </a>

           <!-- Form 3 -->
           <a href="#" class="flat-compact-card" target="_blank">
               <div class="fcc-icon icon-docs">
                   <i class="fas fa-file-word"></i>
               </div>
               <div class="fcc-text">
                   <h4>Tuition Deferral (Doc)</h4>
                   <p>Permohonan Penangguhan Biaya Kuliah (Docs).</p>
               </div>
               <div class="fcc-action icon-docs-text">
                   Akses <i class="fas fa-arrow-right"></i>
               </div>
           </a>

           <!-- Form 4 -->
           <a href="#" class="flat-compact-card" target="_blank">
               <div class="fcc-icon icon-pdf">
                   <i class="fas fa-file-pdf"></i>
               </div>
               <div class="fcc-text">
                   <h4>Tuition Deferral (PDF)</h4>
                   <p>Permohonan Penangguhan Biaya Kuliah (PDF).</p>
               </div>
               <div class="fcc-action icon-pdf-text">
                   Akses <i class="fas fa-arrow-right"></i>
               </div>
           </a>
       </div>

    </div>
  </main>
  
  <script src="/assets/js/main.js"></script>
</body>
</html>
