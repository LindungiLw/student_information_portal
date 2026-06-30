<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

// Get current month and year from URL, default to current
$month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');

// Calculate previous and next month/year
$prevMonth = $month - 1;
$prevYear = $year;
if ($prevMonth == 0) {
    $prevMonth = 12;
    $prevYear--;
}

$nextMonth = $month + 1;
$nextYear = $year;
if ($nextMonth == 13) {
    $nextMonth = 1;
    $nextYear++;
}

// Fetch all events for the current month
// We will fetch all events and filter them in PHP for simplicity
$stmt = $pdo->query("SELECT * FROM academic_calendar ORDER BY start_date ASC");
$all_events = $stmt->fetchAll();

// Fetch the active calendar from the database
$calendar_pdf_path = '';
$calendar_pdf_title = '';
$has_calendar = false;

try {
    $stmt = $pdo->query("SELECT title, file_path FROM calendar_documents ORDER BY id DESC LIMIT 1");
    $doc = $stmt->fetch();
    if ($doc && !empty($doc['file_path']) && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
        $cal_doc_path = $doc['file_path'];
        $calendar_pdf_title = $doc['title'];
        $has_calendar = true;
    }
} catch (PDOException $e) {
    // If table doesn't exist yet, fallback to false
}

// Month metadata
$firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
$daysInMonth = date('t', $firstDayOfMonth);
$monthName = date('F', $firstDayOfMonth);
// Day of week for the 1st day (0 = Sunday, 1 = Monday... 6 = Saturday)
$dayOfWeek = date('w', $firstDayOfMonth);
// Adjust to make Monday = 0, Sunday = 6
$offset = ($dayOfWeek + 6) % 7; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Calendar | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css?v=50">
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=50">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=50">
  <link rel="stylesheet" href="/assets/css/interactive_calendar.css?v=50">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=50">
</head>
<body>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>

  <main class="main">
      <div class="page-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="margin:0;"><svg class="custom-icon" style="color: white;"><use href="#icon-calendar"></use></svg> Academic Calendar</h1>
            <p style="margin-top: 8px;">Official schedule for the current academic year.</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="/admin/calendar_manage.php" class="btn" style="background: white; color: var(--purple-accent); text-decoration: none; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-edit"></i> Manage
                </a>
            <?php endif; ?>
        </div>
      </div>
      <div class="bottom-dashboard-section" style="padding-top: 0;">
       
       <div class="calendar-layout" style="margin-top: 30px;">
           <!-- Sidebar Filters -->
           <aside class="calendar-filters">
               <h3>Filter Categories</h3>
               <ul class="filter-list">
                   <label class="filter-item">
                       <input type="checkbox" value="Exams" checked>
                       <div class="filter-checkbox cat-exams"><i class="fas fa-check"></i></div>
                       Exams
                   </label>
                   <label class="filter-item">
                       <input type="checkbox" value="Holidays" checked>
                       <div class="filter-checkbox cat-holidays"><i class="fas fa-check"></i></div>
                       Holidays
                   </label>
                   <label class="filter-item">
                       <input type="checkbox" value="Academics" checked>
                       <div class="filter-checkbox cat-academics"><i class="fas fa-check"></i></div>
                       Lectures / Academics
                   </label>
                   <label class="filter-item">
                       <input type="checkbox" value="Events" checked>
                        <div class="filter-checkbox cat-events"><i class="fas fa-check"></i></div>
                        Events & Deadlines
                    </label>
                </ul>

                <style>
                .mobile-only { display: none !important; }
                @media (max-width: 767px) {
                    .desktop-only { display: none !important; }
                    .mobile-only { display: flex !important; }
                }
                </style>

                <!-- BOOKLET PDF PREVIEW CARD -->
                <?php if (!empty($cal_doc_path)): ?>
                <div class="booklet-pure-card desktop-only" onclick="expandPdf()" title="Click to open Booklet Popup" style="margin-top: 24px; width: 100%; max-width: 210px; margin-left: auto; margin-right: auto;">
                    <div class="pdf-clip-wrapper" style="display: flex; align-items: center; justify-content: center; background: #f8fafc; min-height: 250px;">
                        <div class="pdf-thumbnail-loader" style="position: absolute; display: flex; flex-direction: column; align-items: center; color: #64748b; font-size: 13px; font-weight: 600;">
                            <i class="fas fa-circle-notch fa-spin" style="font-size: 24px; color: #3b82f6; margin-bottom: 8px;"></i>
                            <span class="pdf-load-percent">Loading...</span>
                        </div>
                        <canvas id="pdf-thumbnail-canvas-desktop" style="width: 100%; height: auto; opacity: 0; transition: opacity 0.3s;"></canvas>
                    </div>

                    <div class="pure-card-interactive-shield">
                        <div class="hover-hand-indicator">
                            <div class="hand-icon-ring">
                                <i class="fas fa-hand-pointer"></i>
                            </div>
                            <span class="hover-action-text">Click to Open</span>
                            <span class="hover-sub-text">Full Calendar PDF</span>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div style="margin-top: 24px; width: 100%; max-width: 210px; margin-left: auto; margin-right: auto; background: var(--card-bg); border: 2px dashed var(--border-color); border-radius: 16px; padding: 30px 20px; text-align: center; color: #94a3b8; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <i class="fas fa-file-pdf" style="font-size: 32px; margin-bottom: 12px; color: #cbd5e1;"></i>
                    <div style="font-size: 14px; font-weight: 700; color: var(--text-main); margin-bottom: 4px;">PDF Not Available</div>
                    <div style="font-size: 12px;">The calendar document hasn't been uploaded yet.</div>
                </div>
                <?php endif; ?>
            </aside>

           <!-- Main Calendar Area -->
           <div class="calendar-main">
               <div class="calendar-header-top" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                   <div style="flex: 1; min-width: 80px; display: none;" class="desktop-spacer"></div> <!-- Spacer for perfect centering on desktop -->
                   <div class="month-nav" style="display: flex; align-items: center; gap: 12px; flex: 2; justify-content: center;">
                       <a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>" class="nav-btn"><i class="fas fa-chevron-left"></i></a>
                       <div class="month-title" style="min-width: 160px; text-align: center; font-size: 22px; font-weight: 800; color: #1e293b;"><?php echo $monthName . ' ' . $year; ?></div>
                       <a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>" class="nav-btn"><i class="fas fa-chevron-right"></i></a>
                   </div>
                   <div style="flex: 1; text-align: right; min-width: 80px;">
                       <a href="?month=<?php echo date('m'); ?>&year=<?php echo date('Y'); ?>" style="text-decoration: none;">
                           <button class="today-btn">Today</button>
                       </a>
                   </div>
               </div>
               
               <style>
               @media (min-width: 768px) {
                   .desktop-spacer { display: block !important; }
               }
               @media (max-width: 767px) {
                   .calendar-header-top { justify-content: center; }
                   .month-nav { flex: unset; width: 100%; margin-bottom: 12px; }
                   .calendar-header-top > div:last-child { flex: unset; width: 100%; text-align: center; }
               }
               </style>

               <div class="calendar-grid-wrapper" style="overflow-x: auto; padding-bottom: 16px;">
                   <!-- Grid Header -->
                   <div class="calendar-grid">
                       <div class="day-name">Mon</div>
                       <div class="day-name">Tue</div>
                       <div class="day-name">Wed</div>
                       <div class="day-name">Thu</div>
                       <div class="day-name">Fri</div>
                       <div class="day-name">Sat</div>
                       <div class="day-name">Sun</div>
                   </div>

                   <!-- Grid Cells -->
                   <div class="calendar-grid" id="calendarGrid">
                   <?php
                   // Calculate previous month padding
                   $prevMonthDays = date('t', mktime(0, 0, 0, $prevMonth, 1, $prevYear));
                   for ($i = 0; $i < $offset; $i++) {
                       $dayNum = $prevMonthDays - $offset + $i + 1;
                       echo "<div class='calendar-cell other-month'><div class='date-number'>$dayNum</div></div>";
                   }

                   // Current month days
                   for ($day = 1; $day <= $daysInMonth; $day++) {
                       $currentDateStr = sprintf("%04d-%02d-%02d", $year, $month, $day);
                       $isToday = ($currentDateStr === date('Y-m-d'));
                       $todayCellClass = $isToday ? 'today-cell' : '';
                       
                       echo "<div class='calendar-cell {$todayCellClass}'>";
                       if ($isToday) {
                           echo "<div class='date-number' style='background: var(--purple-accent); color: white; display: inline-flex; width: 24px; height: 24px; align-items: center; justify-content: center; border-radius: 50%; font-size: 13px; margin-bottom: 6px;'>$day</div>";
                       } else {
                           echo "<div class='date-number'>$day</div>";
                       }
                       echo "<div class='events-container'>";
                       
                       // Find events for this day
                       foreach ($all_events as $event) {
                           $start = $event['start_date'];
                           $end = $event['end_date'];
                           if ($currentDateStr >= $start && $currentDateStr <= $end) {
                               $isStart = ($currentDateStr === $start);
                               $isEnd = ($currentDateStr === $end);
                               
                               $radius = '0px';
                               if ($isStart && $isEnd) { $radius = '6px'; }
                               elseif ($isStart) { $radius = '6px 0 0 6px'; }
                               elseif ($isEnd) { $radius = '0 6px 6px 0'; }
                               
                               $bgColor = htmlspecialchars($event['event_color'] ?? '#5c5fa3');
                               
                               // Build event pill
                               $safeTitle = htmlspecialchars($event['event_title'], ENT_QUOTES);
                               $safeCat = htmlspecialchars($event['category'], ENT_QUOTES);
                               $safeStart = date("M d, Y", strtotime($start));
                               $safeEnd = date("M d, Y", strtotime($end));
                               $dateRange = ($safeStart === $safeEnd) ? $safeStart : "$safeStart - $safeEnd";
                               
                               echo "<div class='event-pill' style='background-color: {$bgColor}; color: white; display: flex; justify-content: space-between; align-items: center; border-radius: {$radius}; margin: 2px 0; padding: 4px 6px; cursor: pointer;' data-category='{$event['category']}' data-color='{$bgColor}' data-title='$safeTitle' data-date='$dateRange' onclick='showEventPopup(this)'>";
                               if ($isStart || $day == 1) { 
                                   echo "<span style='overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 11px;'>" . htmlspecialchars($event['event_title']) . "</span>";
                               } else {
                                   echo "<span style='opacity: 0; font-size: 11px;'>&nbsp;</span>"; // keep height for continuity
                               }
                               echo "</div>";
                           }
                       }
                       
                       echo "</div>";
                       echo "</div>";
                   }

                   // Calculate next month padding
                   $totalCells = $offset + $daysInMonth;
                   $remainingCells = 42 - $totalCells; // Always show 6 rows for consistency (6*7 = 42)
                   if ($remainingCells >= 7 && $totalCells <= 35) {
                       $remainingCells = 35 - $totalCells; // Or 5 rows if it fits
                   }
                   for ($i = 1; $i <= $remainingCells; $i++) {
                       echo "<div class='calendar-cell other-month'><div class='date-number'>$i</div></div>";
                   }
                   ?>
                   </div>
               </div>
               
               <!-- MOBILE PDF PREVIEW CARD (BELOW CALENDAR) -->
               <div class="mobile-only" style="width: 100%; justify-content: center; align-items: center; margin-top: 20px;">
                   <?php if (!empty($cal_doc_path)): ?>
                   <div class="booklet-pure-card" onclick="expandPdf()" title="Click to open Booklet Popup" style="width: 100%; max-width: 280px; height: 380px; margin-left: auto; margin-right: auto; touch-action: pan-y;">
                       <div class="pdf-clip-wrapper" style="display: flex; align-items: center; justify-content: center; background: #f8fafc; height: 100%;">
                           <div class="pdf-thumbnail-loader" style="position: absolute; display: flex; flex-direction: column; align-items: center; color: #64748b; font-size: 13px; font-weight: 600;">
                               <i class="fas fa-circle-notch fa-spin" style="font-size: 24px; color: #3b82f6; margin-bottom: 8px;"></i>
                               <span class="pdf-load-percent">Loading...</span>
                           </div>
                           <canvas id="pdf-thumbnail-canvas-mobile" style="width: 100%; height: auto; opacity: 0; transition: opacity 0.3s;"></canvas>
                       </div>
                       <div class="pure-card-interactive-shield">
                           <div class="hover-hand-indicator">
                               <div class="hand-icon-ring">
                                   <i class="fas fa-hand-pointer"></i>
                               </div>
                               <span class="hover-action-text">Click to Open</span>
                           </div>
                       </div>
                   </div>
                   <?php endif; ?>
               </div>

           </div>
       </div>
    </div>
  </main>

  <!-- Beautiful Sleek Event Details Popup -->
  <div class="event-popup" id="eventPopup">
      <div class="tooltip-header">
          <div class="tooltip-dot" id="popupCatDot"></div>
          <div class="tooltip-title" id="popupTitle">Event Title</div>
      </div>
      <div class="tooltip-date" id="popupDate">Event Date</div>
  </div>

  <!-- Pure 100% Clean PDF Lightbox Popup (No Header Bar) -->
  <div id="booklet-popup-modal" class="booklet-modal-backdrop" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.88); backdrop-filter: blur(12px); z-index: 999999; align-items: center; justify-content: center; padding: 20px;" onclick="closeBookletModal()">
      <!-- Minimalist Elegant Floating Glass Close Button -->
      <button type="button" onclick="closeBookletModal()" title="Close Popup (Esc)" style="position: absolute; top: 24px; right: 24px; width: 48px; height: 48px; border-radius: 50%; background: rgba(255, 255, 255, 0.18); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.35); backdrop-filter: blur(10px); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 20px; z-index: 1000000; box-shadow: 0 10px 25px rgba(0,0,0,0.4); transition: transform 0.25s, background 0.25s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.9)'; this.style.transform='scale(1.1) rotate(90deg)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.18)'; this.style.transform='scale(1) rotate(0deg)';">
          <i class="fas fa-times"></i>
      </button>

      <!-- Pure PDF Frame Container Only -->
      <div class="pure-pdf-popup-box" onclick="event.stopPropagation()" style="width: min(920px, 94vw); height: min(90vh, 1200px); background: #e2e8f0; border-radius: 20px; overflow-y: auto; overflow-x: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.75); position: relative; border: 1px solid rgba(255, 255, 255, 0.22); animation: scaleUpModal 0.32s cubic-bezier(0.16, 1, 0.3, 1);">
          <div id="pdf-render-container" style="width: 100%; display: flex; flex-direction: column; align-items: center; padding: 20px; gap: 20px;"></div>
      </div>
  </div>

  <script src="/assets/js/main.js?v=35"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
  <script>
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
  const pdfUrl = "<?php echo empty($cal_doc_path) ? '' : addslashes($cal_doc_path); ?>";
  let pdfDoc = null;
  let pdfRendered = false;

  if (pdfUrl) {
      const cachedThumb = localStorage.getItem('pdf_thumb_' + pdfUrl);
      
      const applyThumb = (srcData) => {
          const img = new Image();
          img.onload = function() {
              const canvasDesktop = document.getElementById('pdf-thumbnail-canvas-desktop');
              const canvasMobile = document.getElementById('pdf-thumbnail-canvas-mobile');
              
              if(canvasDesktop) {
                  const ctx = canvasDesktop.getContext('2d');
                  canvasDesktop.width = img.width; canvasDesktop.height = img.height;
                  ctx.drawImage(img, 0, 0); canvasDesktop.style.opacity = '1';
              }
              if(canvasMobile) {
                  const ctx = canvasMobile.getContext('2d');
                  canvasMobile.width = img.width; canvasMobile.height = img.height;
                  ctx.drawImage(img, 0, 0); canvasMobile.style.opacity = '1';
              }
              document.querySelectorAll('.pdf-thumbnail-loader').forEach(l => l.style.display = 'none');
          };
          img.src = srcData;
      };

      const loadingTask = pdfjsLib.getDocument(pdfUrl);
      
      loadingTask.onProgress = function(progress) {
          const percentEls = document.querySelectorAll('.pdf-load-percent');
          if (percentEls.length > 0 && progress.total > 0 && !cachedThumb) {
              const percent = Math.round((progress.loaded / progress.total) * 100);
              percentEls.forEach(el => el.textContent = percent + '%');
          }
      };

      if (cachedThumb) {
          // Instant load from cache
          applyThumb(cachedThumb);
          // Load document in background for modal
          loadingTask.promise.then(pdf => { pdfDoc = pdf; }).catch(e => console.error(e));
      } else {
          // Render and cache
          loadingTask.promise.then(pdf => {
              pdfDoc = pdf;
              return pdf.getPage(1);
          }).then(page => {
              const offscreenCanvas = document.createElement('canvas');
              const context = offscreenCanvas.getContext('2d');
              const viewport = page.getViewport({ scale: 1.5 });
              offscreenCanvas.width = viewport.width;
              offscreenCanvas.height = viewport.height;
              
              const renderContext = { canvasContext: context, viewport: viewport };
              return page.render(renderContext).promise.then(() => {
                  try {
                      const dataUrl = offscreenCanvas.toDataURL('image/jpeg', 0.8);
                      localStorage.setItem('pdf_thumb_' + pdfUrl, dataUrl);
                      applyThumb(dataUrl);
                  } catch(e) { 
                      console.warn('Could not cache PDF thumb', e);
                      // Fallback if cache fails
                      applyThumb(offscreenCanvas.toDataURL());
                  }
              });
          }).catch(err => {
              console.error("Error loading PDF: ", err);
              document.querySelectorAll('.pdf-thumbnail-loader').forEach(loader => {
                  loader.innerHTML = '<i class="fas fa-exclamation-circle" style="color: #ef4444; font-size: 32px; margin-bottom: 12px;"></i><span style="font-weight: 600; font-size: 14px; color: #64748b;">Failed to load PDF</span>';
              });
          });
      }
  }

  function expandPdf() {
      if (!pdfUrl) return;
      if (!pdfDoc) {
          alert('Mohon tunggu, dokumen sedang diunduh...');
          return;
      }
      
      const modal = document.getElementById('booklet-popup-modal');
      const container = document.getElementById('pdf-render-container');
      if (!modal || !container) return;
      
      modal.style.display = 'flex';

      if (!pdfRendered) {
          pdfRendered = true;
          container.innerHTML = '<div style="color: #64748b; font-weight: 600; padding: 40px; text-align: center; font-family: \'Manrope\', sans-serif;"><i class="fas fa-circle-notch fa-spin" style="font-size: 24px; margin-bottom: 12px; color: #3b82f6;"></i><br>Loading document...</div>';
          
          const screenWidth = window.innerWidth;
          let scale = 1.5;
          if (screenWidth < 600) scale = 1.0;

          const renderPage = (num) => {
              return pdfDoc.getPage(num).then(page => {
                  const viewport = page.getViewport({ scale: scale });
                  const canvas = document.createElement('canvas');
                  const context = canvas.getContext('2d');
                  canvas.width = viewport.width;
                  canvas.height = viewport.height;
                  canvas.style.maxWidth = '100%';
                  canvas.style.height = 'auto';
                  canvas.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
                  canvas.style.borderRadius = '8px';
                  canvas.style.background = '#fff';

                  const renderContext = { canvasContext: context, viewport: viewport };
                  return page.render(renderContext).promise.then(() => canvas);
              });
          };

          const renderAllPages = async () => {
              const canvases = [];
              for (let i = 1; i <= pdfDoc.numPages; i++) {
                  const canvas = await renderPage(i);
                  canvases.push(canvas);
              }
              container.innerHTML = '';
              canvases.forEach(c => container.appendChild(c));
          };

          renderAllPages().catch(err => {
              console.error("Error rendering pages: ", err);
              container.innerHTML = '<div style="color: #ef4444; font-weight: 600; padding: 40px; text-align: center;">Failed to load PDF pages.</div>';
          });
      }
  }

  function closeBookletModal() {
      const modal = document.getElementById('booklet-popup-modal');
      if (modal) modal.style.display = 'none';
  }
  document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeBookletModal();
  });
  </script>

  <script>
      // Calendar Interactions Logic
      document.addEventListener('DOMContentLoaded', () => {
          const pills = document.querySelectorAll('.event-pill');
          const popup = document.getElementById('eventPopup');
          const checkboxes = document.querySelectorAll('.filter-item input[type="checkbox"]');

          // Popup Elements
          const popupTitle = document.getElementById('popupTitle');
          const popupCatDot = document.getElementById('popupCatDot');
          const popupDate = document.getElementById('popupDate');

          // Open popup on click
          pills.forEach(pill => {
              pill.addEventListener('click', (e) => {
                  e.stopPropagation();
                  
                  // Populate data
                  popupTitle.textContent = pill.getAttribute('data-title');
                  popupDate.textContent = pill.getAttribute('data-date');
                  
                  const bgColor = pill.getAttribute('data-color');
                  
                  // Set popup category color dot
                  popupCatDot.style.backgroundColor = bgColor;

                  // Make it display:block temporarily but invisible to measure its true width
                  popup.style.visibility = 'hidden';
                  popup.classList.add('active');
                  
                  const rect = pill.getBoundingClientRect();
                  const popupWidth = popup.offsetWidth;
                  
                  // Calculate position (centered below the pill)
                  let top = rect.bottom + window.scrollY + 8;
                  let left = rect.left + window.scrollX + (rect.width / 2) - (popupWidth / 2);

                  // Prevent going off-screen
                  if (left < 10) left = 10;
                  if (left + popupWidth > window.innerWidth - 10) left = window.innerWidth - popupWidth - 10;

                  popup.style.top = top + 'px';
                  popup.style.left = left + 'px';
                  
                  // Force reflow for animation and make visible
                  void popup.offsetWidth;
                  popup.style.visibility = ''; // remove inline visibility to let CSS handle it
              });
          });

          // Close popup when clicking anywhere else
          document.addEventListener('click', (e) => {
              if (!popup.contains(e.target)) {
                  popup.classList.remove('active');
              }
          });

          // Filtering logic
          checkboxes.forEach(box => {
              box.addEventListener('change', () => {
                  const val = box.value;
                  const isChecked = box.checked;
                  
                  // If "Academics" checked, we map it to "Academics", "Events" to "Events", etc.
                  // Since our data-category is exactly "Exams", "Holidays", "Academics", "Events"
                  pills.forEach(pill => {
                      if (pill.getAttribute('data-category') === val) {
                          pill.style.display = isChecked ? 'block' : 'none';
                      }
                  });
              });
          });
      });
  </script>
</body>
</html>






