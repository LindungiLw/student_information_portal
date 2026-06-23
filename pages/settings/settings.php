<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

// ── Penanganan Ubah Nama (POST Request) ──
$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_name'])) {
    $new_name = trim($_POST['new_name']);
    
    if (!empty($new_name)) {
        // [DATABASE DISABLED FOR NOW]
        // require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php'; 
        
        // Hanya perbarui data sesi untuk demonstrasi
        $_SESSION['name'] = htmlspecialchars($new_name);
        $success_msg = "Name updated successfully (Demo Mode)!";
    } else {
        $error_msg = "Name cannot be empty.";
    }
}

$current_page = basename($_SERVER['PHP_SELF']);

// Ambil data user dari session (mungkin baru diupdate)
$user_name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest User';
$user_nim = isset($_SESSION['nim']) ? $_SESSION['nim'] : 'Unknown';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Settings | JIU Student Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/sidebar.css">
  <link rel="stylesheet" href="/assets/css/dashboard.css">
  <style>
      .page-intro {
          margin-bottom: 30px;
      }
      .page-intro h1 {
          font-size: 36px;
          font-weight: 800;
          color: var(--text-primary);
          margin: 0 0 10px 0;
          letter-spacing: -1px;
      }
      .page-intro p {
          font-size: 16px;
          color: var(--text-secondary);
          margin: 0;
      }

      /* Alert Messages */
      .alert {
          padding: 12px 20px;
          border-radius: 12px;
          margin-bottom: 24px;
          font-weight: 600;
          font-size: 14px;
      }
      .alert-success {
          background: rgba(16, 185, 129, 0.1);
          color: #10b981;
          border: 1px solid rgba(16, 185, 129, 0.2);
      }
      .alert-error {
          background: rgba(239, 68, 68, 0.1);
          color: #ef4444;
          border: 1px solid rgba(239, 68, 68, 0.2);
      }

      /* Apple-style Settings Layout */
      .settings-container {
          max-width: 850px;
      }
      .settings-section {
          background: var(--card-bg);
          border-radius: 20px;
          border: 1px solid var(--border-color);
          box-shadow: 0 4px 15px rgba(0,0,0,0.02);
          margin-bottom: 30px;
          overflow: hidden;
      }
      .settings-header {
          font-size: 13px;
          font-weight: 800;
          color: var(--text-muted);
          text-transform: uppercase;
          letter-spacing: 1.5px;
          padding: 24px 24px 12px 24px;
      }
      .settings-row {
          display: flex;
          align-items: center;
          justify-content: space-between;
          padding: 16px 24px;
          border-top: 1px solid var(--border-color);
          transition: background-color 0.2s;
      }
      .settings-row:first-of-type {
          border-top: none;
      }
      .sr-left {
          display: flex;
          align-items: center;
          gap: 16px;
      }
      .sr-icon {
          width: 36px;
          height: 36px;
          border-radius: 10px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 16px;
      }
      .icon-blue { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
      .icon-green { background: rgba(16, 185, 129, 0.1); color: #10b981; }
      .icon-purple { background: rgba(139, 92, 246, 0.1); color: #8b5cf6; }
      .icon-orange { background: rgba(249, 115, 22, 0.1); color: #f97316; }

      .sr-text h4 {
          margin: 0 0 4px 0;
          font-size: 15px;
          color: var(--text-primary);
          font-weight: 700;
      }
      .sr-text p {
          margin: 0;
          font-size: 13px;
          color: var(--text-secondary);
      }
      .sr-right {
          font-size: 14px;
          color: var(--text-muted);
          font-weight: 600;
          display: flex;
          align-items: center;
          gap: 10px;
      }
      
      /* Input for editing */
      .edit-input {
          padding: 8px 12px;
          border-radius: 8px;
          border: 1px solid var(--border-color);
          background: var(--body-bg);
          color: var(--text-primary);
          font-family: inherit;
          font-size: 14px;
          font-weight: 600;
          outline: none;
          width: 250px;
      }
      .edit-input:focus {
          border-color: var(--accent);
      }
      .btn-icon {
          background: none;
          border: none;
          color: var(--accent);
          cursor: pointer;
          font-size: 14px;
          padding: 6px;
          border-radius: 6px;
          transition: background 0.2s;
      }
      .btn-icon:hover {
          background: rgba(59, 130, 246, 0.1);
      }
      .btn-save {
          background: var(--accent);
          color: #fff;
          border: none;
          padding: 8px 16px;
          border-radius: 8px;
          font-weight: 700;
          font-size: 13px;
          cursor: pointer;
      }
      .btn-cancel {
          background: none;
          color: var(--text-secondary);
          border: 1px solid var(--border-color);
          padding: 8px 16px;
          border-radius: 8px;
          font-weight: 700;
          font-size: 13px;
          cursor: pointer;
      }

      /* Switch Toggle */
      .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
      }
      .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
      }
      .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: var(--border-color);
        transition: .4s;
        border-radius: 24px;
      }
      .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
      }
      input:checked + .slider {
        background-color: #10b981; /* Green Apple Style */
      }
      input:checked + .slider:before {
        transform: translateX(20px);
      }

      /* Responsive Settings Layout for Mobile */
      @media screen and (max-width: 768px) {
          .settings-row {
              flex-direction: column;
              align-items: flex-start;
              gap: 12px;
              padding: 16px 20px;
          }
          .sr-right {
              width: 100%;
              padding-left: 52px; /* Sejajarkan value dengan teks di bawah ikon */
              justify-content: space-between;
          }
          /* Khusus untuk edit mode nama */
          #nameEditRow {
              flex-direction: column;
          }
          #nameEditRow .sr-left {
              width: 100%;
          }
          #nameEditRow .sr-text {
              width: 100%;
          }
          .edit-input {
              width: 100%;
              margin-top: 8px;
          }
          #nameEditRow .sr-right {
              padding-left: 52px;
              justify-content: flex-start;
              gap: 10px;
          }
          .btn-save, .btn-cancel {
              flex: 1;
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
       <div class="page-intro">
           <h1>Settings</h1>
           <p>Manage your account settings and interface preferences.</p>
       </div>

       <?php if($success_msg): ?>
           <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?php echo $success_msg; ?></div>
       <?php endif; ?>
       
       <?php if($error_msg): ?>
           <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?php echo $error_msg; ?></div>
       <?php endif; ?>

       <div class="settings-container">
           
           <!-- Account Information -->
           <div class="settings-section">
               <div class="settings-header">Account Information</div>
               
               <!-- Mode Tampilan (Read-only) -->
               <div class="settings-row" id="nameDisplayRow">
                   <div class="sr-left">
                       <div class="sr-icon icon-blue"><i class="fas fa-user"></i></div>
                       <div class="sr-text">
                           <h4>Full Name</h4>
                           <p>Your official registered name</p>
                       </div>
                   </div>
                   <div class="sr-right">
                       <span style="color: var(--text-primary);"><?php echo htmlspecialchars($user_name); ?></span>
                       <button class="btn-icon" onclick="toggleEditMode()" title="Edit Name"><i class="fas fa-pen"></i></button>
                   </div>
               </div>

               <!-- Mode Edit (Form) -->
               <form method="POST" class="settings-row" id="nameEditRow" style="display: none; background: rgba(59, 130, 246, 0.05);">
                   <div class="sr-left">
                       <div class="sr-icon icon-blue"><i class="fas fa-user"></i></div>
                       <div class="sr-text">
                           <h4>Full Name</h4>
                           <input type="text" name="new_name" class="edit-input" value="<?php echo htmlspecialchars($user_name); ?>" required>
                       </div>
                   </div>
                   <div class="sr-right">
                       <button type="button" class="btn-cancel" onclick="toggleEditMode()">Cancel</button>
                       <button type="submit" class="btn-save">Save</button>
                   </div>
               </form>

               <div class="settings-row">
                   <div class="sr-left">
                       <div class="sr-icon icon-purple"><i class="fas fa-id-card"></i></div>
                       <div class="sr-text">
                           <h4>Student ID (NIM)</h4>
                           <p>Your unique identification number</p>
                       </div>
                   </div>
                   <div class="sr-right"><?php echo htmlspecialchars($user_nim); ?></div>
               </div>

               <div class="settings-row">
                   <div class="sr-left">
                       <div class="sr-icon icon-orange"><i class="fas fa-envelope"></i></div>
                       <div class="sr-text">
                           <h4>Email Address</h4>
                           <p>University contact email</p>
                       </div>
                   </div>
                   <div class="sr-right">student@jiu.ac.id</div>
               </div>
           </div>

           <!-- Preferences -->
           <div class="settings-section">
               <div class="settings-header">Preferences</div>
               
               <div class="settings-row">
                   <div class="sr-left">
                       <div class="sr-icon icon-green"><i class="fas fa-bell"></i></div>
                       <div class="sr-text">
                           <h4>Push Notifications</h4>
                           <p>Receive alerts for announcements and updates</p>
                       </div>
                   </div>
                   <div class="sr-right">
                       <label class="switch">
                         <input type="checkbox" checked>
                         <span class="slider"></span>
                       </label>
                   </div>
               </div>

               <div class="settings-row">
                   <div class="sr-left">
                       <div class="sr-icon icon-purple"><i class="fas fa-moon"></i></div>
                       <div class="sr-text">
                           <h4>Dark Mode</h4>
                           <p>Switch between light and dark theme</p>
                       </div>
                   </div>
                   <div class="sr-right">
                       <label class="switch">
                         <input type="checkbox" id="darkModeToggle">
                         <span class="slider"></span>
                       </label>
                   </div>
               </div>
           </div>

       </div>

    </div>
  </main>
  
  <script src="/assets/js/main.js"></script>
  <script>
      // Name Edit Toggle
      function toggleEditMode() {
          const displayRow = document.getElementById('nameDisplayRow');
          const editRow = document.getElementById('nameEditRow');
          
          if (displayRow.style.display === 'none') {
              displayRow.style.display = 'flex';
              editRow.style.display = 'none';
          } else {
              displayRow.style.display = 'none';
              editRow.style.display = 'flex';
          }
      }

      // Dark Mode Logic Specific to Settings Page
      const darkModeToggle = document.getElementById('darkModeToggle');
      
      // Sinkronkan toggle switch dengan status global
      if (localStorage.getItem('darkMode') === 'enabled') {
          darkModeToggle.checked = true;
      }

      darkModeToggle.addEventListener('change', () => {
          if (darkModeToggle.checked) {
              document.body.classList.add('dark-mode');
              localStorage.setItem('darkMode', 'enabled');
          } else {
              document.body.classList.remove('dark-mode');
              localStorage.setItem('darkMode', 'disabled');
          }
      });
  </script>
</body>
</html>
