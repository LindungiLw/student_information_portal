<?php
session_start();

// Periksa apakah pengguna sudah login
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
  <title>Calendar | JIU Student Portal</title>
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

  <!-- ── SIDEBAR ── -->
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/sidebar.php'; ?>

  <!-- ── MAIN CONTENT ── -->
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

// Ambil data event dari database
$stmt = $pdo->query("SELECT * FROM academic_calendar ORDER BY start_date ASC");
$events = $stmt->fetchAll();
?>
  <main class="main">
    <div class="bottom-dashboard-section" style="padding-top: 20px;">
       <div class="section-header">
          <div class="section-title"><svg class="custom-icon"><use href="#icon-calendar"></use></svg> Academic Calendar TA 2025-2026</div>
       </div>
       
       <div class="custom-pdf-container">
           <div class="pdf-header">
               <div class="pdf-title">
                   <svg class="custom-icon" style="color: #e53e3e;"><use href="#icon-calendar"></use></svg> 
                   Official Academic Schedule
               </div>
               <div class="pdf-actions">
                   <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                       <a href="/admin/calendar_manage.php" class="btn-download" style="background: var(--purple-accent); color: white;">
                           <i class="fas fa-edit"></i> Manage
                       </a>
                   <?php endif; ?>
                   <a href="/assets/documents/Academic%20Calendar%20TA%202025-2026.pdf" download class="btn-download">
                       <i class="fas fa-file-pdf"></i> Download Full PDF
                   </a>
               </div>
           </div>
           
           <div class="pdf-body" style="padding: 24px; background: var(--card-bg);">
               <?php if(empty($events)): ?>
                   <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                       <i class="fas fa-calendar-times" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;"></i>
                       <p>No academic events found. Admin needs to add events.</p>
                   </div>
               <?php else: ?>
                   <table style="width: 100%; border-collapse: collapse;">
                       <thead>
                           <tr>
                               <th style="text-align: left; padding: 16px; border-bottom: 2px solid var(--border-color); color: var(--text-muted);">Event</th>
                               <th style="text-align: left; padding: 16px; border-bottom: 2px solid var(--border-color); color: var(--text-muted);">Date</th>
                               <th style="text-align: left; padding: 16px; border-bottom: 2px solid var(--border-color); color: var(--text-muted);">Category</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php foreach($events as $e): ?>
                           <tr>
                               <td style="padding: 16px; border-bottom: 1px solid var(--border-color); color: var(--text-main); font-weight: 600;">
                                   <?php echo htmlspecialchars($e['event_title']); ?>
                               </td>
                               <td style="padding: 16px; border-bottom: 1px solid var(--border-color); color: var(--text-main);">
                                   <?php 
                                        $start = date("M d, Y", strtotime($e['start_date']));
                                        $end = date("M d, Y", strtotime($e['end_date']));
                                        echo ($start === $end) ? $start : "$start - $end";
                                   ?>
                               </td>
                               <td style="padding: 16px; border-bottom: 1px solid var(--border-color);">
                                   <span style="background: rgba(107,33,168,0.1); color: var(--purple-accent); padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: 700;">
                                       <?php echo htmlspecialchars($e['category']); ?>
                                   </span>
                               </td>
                           </tr>
                           <?php endforeach; ?>
                       </tbody>
                   </table>
               <?php endif; ?>
           </div>
       </div>
    </div>
  </main>

  <script src="/assets/js/main.js"></script>
</body>
</html>
