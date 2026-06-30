<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
$current_page = 'student_services.php'; // Keep sidebar active on Student Services

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

$feedback_docs = [];
try {
    $stmt = $pdo->query("SELECT * FROM feedback_documents ORDER BY id DESC");
    $all_docs = $stmt->fetchAll();
    foreach ($all_docs as $doc) {
        if (!empty($doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
            $feedback_docs[] = $doc;
        }
    }
} catch (PDOException $e) {}

$qr_code_path = null;
$poster_path = null;

foreach ($feedback_docs as $doc) {
    $title_lower = strtolower($doc['title']);
    if (strpos($title_lower, 'qr') !== false || strpos($title_lower, 'scan') !== false || strpos($title_lower, 'barcode') !== false || strpos($title_lower, 'form') !== false) {
        if (!$qr_code_path) $qr_code_path = $doc['file_path'];
    } elseif (strpos($title_lower, 'poster') !== false || strpos($title_lower, 'official') !== false) {
        if (!$poster_path) $poster_path = $doc['file_path'];
    } else {
        // Fallback: if it doesn't match either, assign to poster if poster is empty, else qr
        if (!$poster_path) $poster_path = $doc['file_path'];
        elseif (!$qr_code_path) $qr_code_path = $doc['file_path'];
    }
}
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
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=50">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=50">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=53">
  <style>
      .feedback-container {
          display: flex;
          flex-direction: column;
          gap: 40px;
          align-items: center;
          margin-top: 20px;
          padding-bottom: 50px;
      }
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
    <div style="margin-bottom: 16px;">
        <a href="/pages/services/student_services.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to Student Services</a>
    </div>
    <div class="page-header">
       <h1><i class="fas fa-comment-dots"></i> Feedback and Report</h1>
       <p>Your voice matters. Help us improve the campus environment by submitting your feedback or reporting issues.</p>
    </div>
    <div class="bottom-dashboard-section" style="padding-top: 0;">
       <?php if (empty($qr_code_path) && empty($poster_path)): ?>
           <div class="empty-state-container" style="background: white; padding: 60px 20px; border-radius: 20px; text-align: center; border: 1px solid var(--border-color); max-width: 800px; margin: 0 auto; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
               <div class="empty-state-icon" style="font-size: 64px; color: #cbd5e1; margin-bottom: 24px;"><i class="fas fa-bullhorn"></i></div>
               <div class="empty-state-title" style="font-size: 24px; font-weight: 800; margin-bottom: 12px; color: var(--text-main);">Information Not Available</div>
               <div class="empty-state-desc" style="color: #64748b; font-size: 16px;">The feedback form and official information poster have not been uploaded yet. Please check back later.</div>
           </div>
       <?php else: ?>
       <div class="feedback-container">
           <!-- QR Code Call to Action Card -->
           <?php if (!empty($qr_code_path)): ?>
           <div class="feedback-qr-wrapper">
               <img src="<?php echo htmlspecialchars($qr_code_path); ?>" alt="Scan QR Code to Submit Feedback">
               <div class="qr-text">
                   <h4>Scan to Report</h4>
                   <p>Scan the QR code using your smartphone camera to quickly access the feedback and report form. You can submit complaints or suggestions anonymously.</p>
                   <a href="#" class="qr-btn"><i class="fas fa-external-link-alt"></i> Open Form in Browser</a>
               </div>
           </div>
           <?php endif; ?>

           <!-- Official Poster -->
           <?php if (!empty($poster_path)): ?>
           <div class="feedback-poster-wrapper">
               <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 20px; color: #1e293b; font-weight: 800; text-align: left;">Official Information</h3>
               <img src="<?php echo htmlspecialchars($poster_path); ?>" alt="Feedback and Report Poster">
           </div>
           <?php endif; ?>
       </div>
       <?php endif; ?>
    </div>
  </main>
  
  <script src="/assets/js/main.js?v=54"></script>
</body>
</html>
