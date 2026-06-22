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
  <title>Cost of Attendance | JIU Student Portal</title>
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
             <i class="fas fa-coins" style="color: var(--purple-accent); margin-right: 12px;"></i> Cost of Attendance
          </div>
          <p style="color: var(--text-muted); font-size: 15px; margin: 0;">Tuition, Fees, and Payment Guidelines for Domestic and International Students.</p>
       </div>

       <!-- Finance Pricing Grid -->
       <div class="finance-grid" style="margin-top: 30px;">
           <!-- Card 1: Domestic Tuition -->
           <div class="finance-card">
               <div class="finance-bg-shape" style="background: #3182ce;"></div>
               <div class="finance-icon" style="background: rgba(49, 130, 206, 0.1); color: #3182ce;">
                   <i class="fas fa-graduation-cap"></i>
               </div>
               <h3>Domestic Tuition</h3>
               <div class="finance-price">
                   <span class="currency">Rp</span> <span class="amount">12.5M - 15M</span>
                   <span style="color:var(--text-muted); font-size:13px; font-weight:600;">/sem</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #3182ce;"></i> <strong>ELL / JLL / ACC:</strong> Rp 12,500,000</li>
                   <li><i class="fas fa-check-circle" style="color: #3182ce;"></i> <strong>IT / IS / VCD:</strong> Rp 15,000,000</li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('Domestic Student', 1)" class="finance-card-link" style="color: #3182ce;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>
           
           <!-- Card 2: One-Time Fees -->
           <div class="finance-card">
               <div class="finance-bg-shape" style="background: #d53f8c;"></div>
               <div class="finance-icon" style="background: rgba(213, 63, 140, 0.1); color: #d53f8c;">
                   <i class="fas fa-file-invoice-dollar"></i>
               </div>
               <h3>One-Time Fees</h3>
               <div class="finance-price">
                   <span class="currency">Rp</span> <span class="amount">13.3M</span>
                   <span style="color:var(--text-muted); font-size:13px; font-weight:600;"> total</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #d53f8c;"></i> <strong>Registration:</strong> Rp 300,000</li>
                   <li><i class="fas fa-check-circle" style="color: #d53f8c;"></i> <strong>Development:</strong> Rp 10,000,000</li>
                   <li><i class="fas fa-check-circle" style="color: #d53f8c;"></i> <strong>Matriculation:</strong> Rp 3,000,000</li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('Registration Fee', 1)" class="finance-card-link" style="color: #d53f8c;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 3: Living Accommodations -->
           <div class="finance-card">
               <div class="finance-bg-shape" style="background: #dd6b20;"></div>
               <div class="finance-icon" style="background: rgba(221, 107, 32, 0.1); color: #dd6b20;">
                   <i class="fas fa-bed"></i>
               </div>
               <h3>Living Needs</h3>
               <div class="finance-price">
                   <span class="currency">Rp</span> <span class="amount">5.2M</span>
                   <span style="color:var(--text-muted); font-size:13px; font-weight:600;">/sem</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #dd6b20;"></i> <strong>Dorm Fee:</strong> Rp 2,800,000</li>
                   <li><i class="fas fa-check-circle" style="color: #dd6b20;"></i> <strong>Meal Fee:</strong> Rp 2,400,000</li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('Dorm Fee', 1)" class="finance-card-link" style="color: #dd6b20;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 4: Payment Installments -->
           <div class="finance-card">
               <div class="finance-bg-shape" style="background: #805ad5;"></div>
               <div class="finance-icon" style="background: rgba(128, 90, 213, 0.1); color: #805ad5;">
                   <i class="fas fa-calendar-check"></i>
               </div>
               <h3>Payment Installments</h3>
               <div class="finance-price">
                   <span class="amount">Milestones</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #805ad5;"></i> <strong>25% Paid:</strong> Eligible for Enrollment</li>
                   <li><i class="fas fa-check-circle" style="color: #805ad5;"></i> <strong>50% Paid:</strong> Eligible for Midterms</li>
                   <li><i class="fas fa-check-circle" style="color: #805ad5;"></i> <strong>100% Paid:</strong> Eligible for Finals</li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('Note', 1)" class="finance-card-link" style="color: #805ad5;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 5: International Students -->
           <div class="finance-card">
               <div class="finance-bg-shape" style="background: #00b5d8;"></div>
               <div class="finance-icon" style="background: rgba(0, 181, 216, 0.1); color: #00b5d8;">
                   <i class="fas fa-globe-asia"></i>
               </div>
               <h3>International Std.</h3>
               <div class="finance-price">
                   <span class="currency">$</span> <span class="amount">2.2K - 3.5K</span>
               </div>
               <ul class="finance-list">
                   <li><i class="fas fa-check-circle" style="color: #00b5d8;"></i> <strong>In State:</strong> ~$2,256 USD (Sem 1)</li>
                   <li><i class="fas fa-check-circle" style="color: #00b5d8;"></i> <strong>Out of State:</strong> ~$3,500 USD (Sem 1)</li>
                   <li><i class="fas fa-info-circle" style="color: #00b5d8;"></i> + USD 650 for Visa App</li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('International Students', 2)" class="finance-card-link" style="color: #00b5d8;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>

           <!-- Card 6: How to Pay -->
           <div class="finance-card">
               <div class="finance-bg-shape" style="background: #27ae60;"></div>
               <div class="finance-icon" style="background: rgba(39, 174, 96, 0.1); color: #27ae60;">
                   <i class="fas fa-mobile-alt"></i>
               </div>
               <h3>How to Pay</h3>
               <div class="finance-price">
                   <span class="amount">Methods</span>
               </div>
               <ul class="finance-list" style="margin-bottom: 15px;">
                   <li><i class="fas fa-check-circle" style="color: #27ae60;"></i> Via <strong>SIAKAD</strong> Portal</li>
                   <li><i class="fas fa-check-circle" style="color: #27ae60;"></i> Via <strong>CIVITAS</strong> Mobile App</li>
                   <li><i class="fas fa-check-circle" style="color: #27ae60;"></i> Cash to JIU Finance Dept.</li>
               </ul>
               <a href="javascript:void(0)" onclick="openPdfSection('How to pay', 3)" class="finance-card-link" style="color: #27ae60;">Read Full Details <i class="fas fa-arrow-right"></i></a>
           </div>
       </div>

       <!-- Interactive PDF Viewer -->
       <div class="custom-pdf-container" id="finance-pdf-container" style="margin-top: 50px;">
           <div class="pdf-header">
               <div class="pdf-title">
                   <i class="fas fa-file-pdf"></i> Official Tuition & Fee Document
               </div>
               <div class="pdf-actions">
                   <a href="/assets/documents/Tuition and Fee Information.pdf" download class="pdf-btn pdf-btn-outline">
                       <i class="fas fa-download"></i> Download PDF
                   </a>
                   <button class="pdf-btn pdf-btn-primary" onclick="toggleFullscreen('finance-pdf-container')">
                       <i class="fas fa-expand"></i> Fullscreen
                   </button>
               </div>
           </div>
           
           <div class="pdf-body">
               <iframe 
                   id="finance-pdf"
                   src="/assets/documents/Tuition and Fee Information.pdf#toolbar=0&navpanes=0&view=FitH" 
                   type="application/pdf">
               </iframe>
           </div>
       </div>

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

        const iframe = document.getElementById('finance-pdf');
        if(iframe) {
            const baseUrl = '/assets/documents/Tuition and Fee Information.pdf';
            const timestamp = new Date().getTime();
            iframe.src = `${baseUrl}?t=${timestamp}#toolbar=0&navpanes=0&view=FitH&search=${encodeURIComponent(keyword)}&page=${estimatedPage}`;
        }
    }

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
