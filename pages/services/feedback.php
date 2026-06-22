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
  <title>Feedback & Report | JIU Student Portal</title>
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

      .feedback-container {
          display: flex;
          flex-direction: column;
          gap: 40px;
          align-items: center;
          margin-top: 20px;
          padding-bottom: 50px;
      }
      
      /* Main Poster */
      .feedback-poster-wrapper {
          background: #fff;
          padding: 20px;
          border-radius: 28px;
          border: 1px solid var(--border-color);
          box-shadow: 0 10px 30px rgba(0,0,0,0.03);
          max-width: 800px;
          width: 100%;
          text-align: center;
      }
      .feedback-poster-wrapper img {
          max-width: 100%;
          border-radius: 16px;
          display: block;
          margin: 0 auto;
      }

      /* QR Code Card */
      .feedback-qr-wrapper {
          display: flex;
          align-items: center;
          gap: 30px;
          background: #fff;
          padding: 30px;
          border-radius: 24px;
          border: 1px solid var(--border-color);
          box-shadow: 0 10px 30px rgba(0,0,0,0.03);
          max-width: 650px;
          width: 100%;
          transition: transform 0.3s;
      }
      .feedback-qr-wrapper:hover {
          transform: translateY(-4px);
          box-shadow: 0 15px 40px rgba(0,0,0,0.06);
      }
      .feedback-qr-wrapper img {
          width: 180px;
          height: 180px;
          border-radius: 16px;
          border: 1px solid #e2e8f0;
          object-fit: contain;
          padding: 10px;
          background: #f8fafc;
      }
      .qr-text {
          flex-grow: 1;
      }
      .qr-text h4 {
          font-size: 24px;
          font-weight: 800;
          color: #ef4444; /* Red accent matching services menu */
          margin: 0 0 12px 0;
      }
      .qr-text p {
          font-size: 15px;
          color: #475569;
          margin: 0 0 20px 0;
          line-height: 1.6;
      }
      .qr-btn {
          display: inline-block;
          background: #ef4444;
          color: #fff;
          padding: 12px 24px;
          border-radius: 12px;
          text-decoration: none;
          font-weight: 700;
          transition: all 0.3s;
          font-size: 15px;
      }
      .qr-btn:hover {
          background: #dc2626;
          transform: translateY(-2px);
          box-shadow: 0 6px 16px rgba(239, 68, 68, 0.3);
          color: #fff;
      }

      @media (max-width: 768px) {
          .feedback-qr-wrapper {
              flex-direction: column;
              text-align: center;
          }
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

       <div class="page-intro">
           <h1>Feedback and Report</h1>
           <p>Your voice matters. Help us improve the campus environment by submitting your feedback or reporting issues.</p>
       </div>

       <div class="feedback-container">
           
           <!-- QR Code Call to Action Card -->
           <div class="feedback-qr-wrapper">
               <img src="/assets/documents/feedback/barcode.png" alt="Scan QR Code to Submit Feedback">
               <div class="qr-text">
                   <h4>Scan to Report</h4>
                   <p>Scan the QR code using your smartphone camera to quickly access the feedback and report form. You can submit complaints or suggestions anonymously.</p>
                   <a href="#" class="qr-btn"><i class="fas fa-external-link-alt"></i> Open Form in Browser</a>
               </div>
           </div>

           <!-- Official Poster -->
           <div class="feedback-poster-wrapper">
               <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 20px; color: #1e293b; font-weight: 800; text-align: left;">Official Information</h3>
               <img src="/assets/documents/feedback/poster.png" alt="Feedback and Report Poster">
           </div>

       </div>

    </div>
  </main>
  
  <script src="/assets/js/main.js"></script>
</body>
</html>
