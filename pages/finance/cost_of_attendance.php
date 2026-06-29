<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}
$current_page = basename($_SERVER['PHP_SELF']);

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

// Fetch the latest finance document from the database
$finance_pdf_path = '';
$finance_pdf_title = '';

try {
    $stmt = $pdo->query("SELECT title, file_path FROM finance_documents ORDER BY id DESC LIMIT 1");
    $doc = $stmt->fetch();
    if ($doc && !empty($doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
        $finance_pdf_path = $doc['file_path'];
        $finance_pdf_title = $doc['title'];
    }
} catch (PDOException $e) {
    // If table doesn't exist yet, fallback to empty state
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cost of Attendance | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=10">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=3">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=26">
  <style>
      .pdf-container {
          height: 600px;
          border-radius: 12px;
          overflow: hidden;
          border: 1px solid var(--border-color);
          margin-top: 16px;
          box-shadow: 0 10px 30px rgba(0,0,0,0.05);
      }
      @media (max-width: 768px) {
          .pdf-container {
              height: 400px;
          }
      }
  </style>
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>
  
  <main class="main">
    <div class="page-header">
       <h1><i class="fas fa-coins"></i> Cost of Attendance</h1>
       <p>Tuition, Fees, and Payment Guidelines for Domestic and International Students.</p>
    </div>
    <div class="bottom-dashboard-section" style="padding-top: 0;">

       <!-- Finance Pricing Grid -->
       <div class="finance-grid" style="margin-top: 30px;">
           <!-- Card 1: Domestic Tuition -->
           <div class="finance-card">
               <div class="finance-icon" style="background: rgba(49, 130, 206, 0.1); color: #3182ce;">
                   <i class="fas fa-graduation-cap"></i>
               </div>
               <h3>Domestic Tuition</h3>
               <div class="finance-price">
                   <span class="currency">Rp</span> <span class="amount">12.5M - 15M</span>
                   <span style="color:var(--text-muted); font-size:13px; font-weight:600;">/sem</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #3182ce;"></i> <div class="text-content"><strong>ELL / JLL / ACC:</strong> <span class="val">Rp 12,500,000</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #3182ce;"></i> <div class="text-content"><strong>IT / IS / VCD:</strong> <span class="val">Rp 15,000,000</span></div></li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('Domestic Student', 1)" class="finance-card-link" style="color: #3182ce;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>
           
           <!-- Card 2: One-Time Fees -->
           <div class="finance-card">
               <div class="finance-icon" style="background: rgba(213, 63, 140, 0.1); color: #d53f8c;">
                   <i class="fas fa-file-invoice-dollar"></i>
               </div>
               <h3>One-Time Fees</h3>
               <div class="finance-price">
                   <span class="currency">Rp</span> <span class="amount">13.3M</span>
                   <span style="color:var(--text-muted); font-size:13px; font-weight:600;"> total</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #d53f8c;"></i> <div class="text-content"><strong>Registration:</strong> <span class="val">Rp 300,000</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #d53f8c;"></i> <div class="text-content"><strong>Development:</strong> <span class="val">Rp 10,000,000</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #d53f8c;"></i> <div class="text-content"><strong>Matriculation:</strong> <span class="val">Rp 3,000,000</span></div></li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('Registration Fee', 1)" class="finance-card-link" style="color: #d53f8c;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 3: Living Accommodations -->
           <div class="finance-card">
               <div class="finance-icon" style="background: rgba(221, 107, 32, 0.1); color: #dd6b20;">
                   <i class="fas fa-bed"></i>
               </div>
               <h3>Living Needs</h3>
               <div class="finance-price">
                   <span class="currency">Rp</span> <span class="amount">5.2M</span>
                   <span style="color:var(--text-muted); font-size:13px; font-weight:600;">/sem</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #dd6b20;"></i> <div class="text-content"><strong>Dorm Fee:</strong> <span class="val">Rp 2,800,000</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #dd6b20;"></i> <div class="text-content"><strong>Meal Fee:</strong> <span class="val">Rp 2,400,000</span></div></li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('Dorm Fee', 1)" class="finance-card-link" style="color: #dd6b20;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 4: Payment Installments -->
           <div class="finance-card">
               <div class="finance-icon" style="background: rgba(128, 90, 213, 0.1); color: #805ad5;">
                   <i class="fas fa-calendar-check"></i>
               </div>
               <h3>Payment Installments</h3>
               <div class="finance-price">
                   <span class="amount">Milestones</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #805ad5;"></i> <div class="text-content"><strong>25% Paid:</strong> <span class="val">Eligible for Enrollment</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #805ad5;"></i> <div class="text-content"><strong>50% Paid:</strong> <span class="val">Eligible for Midterms</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #805ad5;"></i> <div class="text-content"><strong>100% Paid:</strong> <span class="val">Eligible for Finals</span></div></li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('Note', 1)" class="finance-card-link" style="color: #805ad5;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 5: International Students -->
           <div class="finance-card">
               <div class="finance-icon" style="background: rgba(0, 181, 216, 0.1); color: #00b5d8;">
                   <i class="fas fa-globe-asia"></i>
               </div>
               <h3>International Std.</h3>
               <div class="finance-price">
                   <span class="currency">$</span> <span class="amount">2.2K - 3.5K</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #00b5d8;"></i> <div class="text-content"><strong>In State:</strong> <span class="val">~$2,256 USD (Sem 1)</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #00b5d8;"></i> <div class="text-content"><strong>Out of State:</strong> <span class="val">~$3,500 USD (Sem 1)</span></div></li>
                   <li><i class="fas fa-info-circle" style="color: #00b5d8;"></i> <div class="text-content"><strong>Visa App:</strong> <span class="val">+ USD 650</span></div></li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('International Students', 2)" class="finance-card-link" style="color: #00b5d8;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 6: How to Pay -->
           <div class="finance-card">
               <div class="finance-icon" style="background: rgba(39, 174, 96, 0.1); color: #27ae60;">
                   <i class="fas fa-mobile-alt"></i>
               </div>
               <h3>How to Pay</h3>
               <div class="finance-price">
                   <span class="amount">Methods</span>
               </div>
               <ul class="finance-list" style="margin-bottom: 15px;">
                   <li><i class="fas fa-check-circle" style="color: #27ae60;"></i> <div class="text-content"><strong>SIAKAD:</strong> <span class="val">Student Portal</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #27ae60;"></i> <div class="text-content"><strong>CIVITAS:</strong> <span class="val">Mobile App</span></div></li>
                   <li><i class="fas fa-check-circle" style="color: #27ae60;"></i> <div class="text-content"><strong>Cash:</strong> <span class="val">JIU Finance Dept.</span></div></li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('How to pay', 3)" class="finance-card-link" style="color: #27ae60;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>
       </div>

       <!-- Interactive PDF Viewer -->
       <?php if (!empty($finance_pdf_path)): ?>
         <div id="finance-pdf-container" style="margin-top: 50px;">
             <h3 style="color: var(--text-main); margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                 <i class="fas fa-file-pdf" style="color: #ef4444;"></i> 
                 <span id="finance-pdf-title-text"><?php echo htmlspecialchars($finance_pdf_title); ?></span>
             </h3>
             <p style="color: var(--text-muted); margin-bottom: 20px; font-size: 14px;">Review the official tuition, fees, and payment guidelines below.</p>
             
             <div class="pdf-container">
                 <iframe 
                     id="finance-pdf"
                     src="<?php echo htmlspecialchars($finance_pdf_path); ?>#toolbar=0&navpanes=0&view=Fit" 
                     width="100%" 
                     height="100%" 
                     style="border: none; display: block;"
                     type="application/pdf">
                 </iframe>
             </div>
             
             <div style="margin-top: 16px; display: flex; justify-content: flex-end;">
                 <a href="<?php echo htmlspecialchars($finance_pdf_path); ?>" download id="finance-pdf-download-btn" style="color: var(--purple-accent); font-weight: 600; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
                     <i class="fas fa-download"></i> Download PDF
                 </a>
             </div>
         </div>
       <?php else: ?>
         <div class="empty-state-container" style="background: white; padding: 60px 40px; border-radius: 16px; text-align: center; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-top: 50px;">
             <div class="empty-state-icon" style="font-size: 56px; color: #cbd5e1; margin-bottom: 20px;"><i class="fas fa-file-invoice-dollar"></i></div>
             <div class="empty-state-title" style="font-size: 22px; font-weight: 800; color: #334155; margin-bottom: 12px;">No Documents Available</div>
             <div class="empty-state-desc" style="font-size: 15px; color: #64748b; max-width: 400px; margin: 0 auto;">Official tuition and fee guidelines have not been uploaded yet. Please check back later.</div>
         </div>
       <?php endif; ?>

    </div>
  </main>
  
  <script>
    function openPdfSection(keyword, estimatedPage) {
        const pdfContainer = document.querySelector('.custom-pdf-container');
        if(pdfContainer) {
            pdfContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
            pdfContainer.style.transition = "box-shadow 0.3s ease";
            pdfContainer.style.boxShadow = "0 0 0 4px var(--purple-accent)";
            setTimeout(() => {
                pdfContainer.style.boxShadow = "0 4px 15px rgba(0,0,0,0.02)";
            }, 1500);
        }

        const baseUrl = '<?php echo $finance_pdf_path; ?>';
        const timestamp = new Date().getTime();
        const fullUrl = `${baseUrl}?t=${timestamp}#toolbar=0&navpanes=0&view=Fit&search=${encodeURIComponent(keyword)}&page=${estimatedPage}`;

        // Update Desktop Iframe
        const iframe = document.getElementById('finance-pdf');
        if(iframe && iframe.style.display !== 'none') {
            iframe.src = fullUrl;
        }

        // Update Mobile Fallback Card (if it exists)
        const mobileFallbackLink = document.querySelector('.mobile-pdf-card a');
        if (mobileFallbackLink) {
            mobileFallbackLink.href = `${baseUrl}#search=${encodeURIComponent(keyword)}&page=${estimatedPage}`;
            const mobileFallbackTitle = document.querySelector('.mobile-pdf-card h4');
            if (mobileFallbackTitle) {
                mobileFallbackTitle.innerText = `Official Tuition Document - ${keyword}`;
            }
        }
    }

  </script>
  <script src="/assets/js/main.js"></script>
</body>
</html>






