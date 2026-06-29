<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Akses Ditolak! Anda bukan admin.");
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

// Temporary helper to clear docs table
if (isset($_GET['clear_docs'])) {
    $pdo->query('TRUNCATE TABLE dashboard_documents');
    $message = "Dashboard documents table cleared successfully!";
    $message_type = "success";
}
// Temporary helper to clear announcements table
if (isset($_GET['clear_ann'])) {
    $pdo->query('TRUNCATE TABLE announcements');
    $message = "Announcements table cleared successfully!";
    $message_type = "success";
}

// Ensure tables exist
$pdo->exec("CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) DEFAULT 'Admin Panel',
    created_at DATE DEFAULT (CURDATE())
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS dashboard_documents (
  id int(11) NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  file_path varchar(255) DEFAULT NULL,
  uploaded_at timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

$message = '';
$message_type = '';

// Check announcements count
$stmt_count = $pdo->query("SELECT COUNT(*) FROM announcements");
$total_ann = $stmt_count ? $stmt_count->fetchColumn() : 0;

// DELETE Actions
if (isset($_GET['delete_ann'])) {
    $id = (int)$_GET['delete_ann'];
    $stmt = $pdo->prepare("DELETE FROM announcements WHERE id=?");
    if ($stmt->execute([$id])) {
        $message = "Announcement deleted successfully.";
        $message_type = "success";
        $total_ann--;
    } else {
        $message = "Failed to delete announcement.";
        $message_type = "error";
    }
}

if (isset($_GET['delete_doc'])) {
    $id = (int)$_GET['delete_doc'];
    $stmt = $pdo->prepare("SELECT file_path FROM dashboard_documents WHERE id = ?");
    $stmt->execute([$id]);
    $doc = $stmt->fetch();
    
    if ($doc) {
        if ($doc['file_path'] && file_exists($_SERVER['DOCUMENT_ROOT'] . $doc['file_path'])) {
            if ($doc['file_path'] !== '/assets/documents/JIU-Admission-Booklet-English-Version.pdf') {
                unlink($_SERVER['DOCUMENT_ROOT'] . $doc['file_path']);
            }
        }
        $pdo->prepare("DELETE FROM dashboard_documents WHERE id = ?")->execute([$id]);
        $message = "Dashboard booklet deleted successfully.";
        $message_type = "success";
    }
}

// POST Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'] ?? '';

    if ($form_type === 'announcement') {
        $action = $_POST['action'] ?? '';
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $author = $_POST['author'] ?? 'Admin Panel';
        $created_at = $_POST['created_at'] ?? date('Y-m-d');
        
        if ($action === 'add') {
            if ($total_ann >= 2) {
                $message = "Maximum quota is 2! Please delete or edit an existing announcement.";
                $message_type = "error";
            } else {
                $stmt = $pdo->prepare("INSERT INTO announcements (title, content, author, created_at) VALUES (?, ?, ?, ?)");
                if ($stmt->execute([$title, $content, $author, $created_at])) {
                    $message = "Announcement added successfully.";
                    $message_type = "success";
                    $total_ann++;
                } else {
                    $message = "Database error.";
                    $message_type = "error";
                }
            }
        } elseif ($action === 'edit') {
            $id = $_POST['id'] ?? 0;
            $stmt = $pdo->prepare("UPDATE announcements SET title=?, content=?, author=?, created_at=? WHERE id=?");
            if ($stmt->execute([$title, $content, $author, $created_at, $id])) {
                $message = "Announcement updated successfully.";
                $message_type = "success";
            } else {
                $message = "Database error.";
                $message_type = "error";
            }
        }
    } elseif ($form_type === 'dashboard_doc') {
        $title = $_POST['title'];
        if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
            $edit_id = (int)$_POST['edit_id'];
            if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === 0) {
                $upload_dir = '/assets/documents/';
                if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $upload_dir)) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . $upload_dir, 0777, true);
                }
                $file_name = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['file_upload']['name']);
                $target_path = $_SERVER['DOCUMENT_ROOT'] . $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $target_path)) {
                    $file_path = $upload_dir . $file_name;
                    $stmt = $pdo->prepare("SELECT file_path FROM dashboard_documents WHERE id = ?");
                    $stmt->execute([$edit_id]);
                    $old_doc = $stmt->fetch();
                    if ($old_doc && $old_doc['file_path'] && file_exists($_SERVER['DOCUMENT_ROOT'] . $old_doc['file_path'])) {
                        if ($old_doc['file_path'] !== '/assets/documents/JIU-Admission-Booklet-English-Version.pdf') {
                            unlink($_SERVER['DOCUMENT_ROOT'] . $old_doc['file_path']);
                        }
                    }
                    $stmt = $pdo->prepare("UPDATE dashboard_documents SET title = ?, file_path = ? WHERE id = ?");
                    if ($stmt->execute([$title, $file_path, $edit_id])) {
                        $message = "Booklet updated successfully.";
                        $message_type = "success";
                    }
                }
            } else {
                $stmt = $pdo->prepare("UPDATE dashboard_documents SET title = ? WHERE id = ?");
                if ($stmt->execute([$title, $edit_id])) {
                    $message = "Booklet title updated successfully.";
                    $message_type = "success";
                }
            }
        } else {
            if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === 0) {
                $upload_dir = '/assets/documents/';
                if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $upload_dir)) {
                    mkdir($_SERVER['DOCUMENT_ROOT'] . $upload_dir, 0777, true);
                }
                $file_name = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['file_upload']['name']);
                $target_path = $_SERVER['DOCUMENT_ROOT'] . $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $target_path)) {
                    $file_path = $upload_dir . $file_name;
                    $stmt = $pdo->prepare("INSERT INTO dashboard_documents (title, file_path) VALUES (?, ?)");
                    if ($stmt->execute([$title, $file_path])) {
                        $message = "Booklet uploaded successfully.";
                        $message_type = "success";
                    }
                }
            }
        }
    }
}

// Fetch Announcements
$stmt_ann = $pdo->query("SELECT * FROM announcements ORDER BY id DESC LIMIT 2");
$announcements = $stmt_ann ? $stmt_ann->fetchAll() : [];

// Fetch Booklet
$stmt_doc = $pdo->query("SELECT * FROM dashboard_documents ORDER BY id DESC");
$docs = $stmt_doc->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Manager | Admin Portal</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link rel="preload" href="/assets/css/responsive.css?v=35" as="style">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=35">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=35">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=35">
  <style>
      html, body { overflow-x: hidden; max-width: 100vw; width: 100%; }
      .btn-primary { background: var(--purple-accent); color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 700; font-size: 14px; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; cursor: pointer; }
      .btn-primary:hover { background: var(--purple-accent-hover); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(107, 111, 160, 0.2); }
      .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
      .section-divider { margin: 40px 0; border: 0; border-top: 1px solid var(--border-color); }
      
      /* --- Admin Modal Fixes --- */
      .admin-modal-overlay {
          display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4);
          backdrop-filter: blur(8px); z-index: 1000; align-items: center; justify-content: center;
          opacity: 0; transition: opacity 0.3s ease;
      }
      .admin-modal-overlay.active { display: flex; opacity: 1; }
      .admin-modal-content {
          background: white; border-radius: 20px; width: 100%; max-width: 500px; padding: 32px;
          box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15); position: relative;
          transform: translateY(20px); transition: transform 0.3s ease;
          max-height: 90vh; overflow-y: auto;
      }
      .admin-modal-overlay.active .admin-modal-content { transform: translateY(0); }
      .admin-modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
      .admin-modal-title { font-size: 20px; font-weight: 800; color: var(--text-main); margin: 0; }
      .admin-modal-close {
          background: rgba(15, 23, 42, 0.05); border: none; width: 32px; height: 32px;
          border-radius: 50%; display: flex; align-items: center; justify-content: center;
          cursor: pointer; color: var(--text-muted); transition: 0.2s;
      }
      .admin-modal-close:hover { background: #ef4444; color: white; }
      .admin-modal-content .form-group { margin-bottom: 20px; }
      .admin-modal-content label {
          display: block; font-size: 13px; font-weight: 700; color: var(--text-muted);
          margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;
      }
      .admin-modal-content input[type="text"],
      .admin-modal-content input[type="date"],
      .admin-modal-content select,
      .admin-modal-content textarea {
          width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 8px;
          font-family: inherit; font-size: 14px; outline: none; transition: 0.2s;
          box-sizing: border-box; background: #f8fafc; resize: vertical;
      }
      .admin-modal-content input:focus,
      .admin-modal-content select:focus,
      .admin-modal-content textarea:focus {
          border-color: var(--purple-accent); box-shadow: 0 0 0 3px rgba(107, 111, 160, 0.1); background: white;
      }
      .admin-modal-content input[type="file"] {
          width: 100%; padding: 10px; border: 2px dashed #cbd5e1; border-radius: 8px;
          background: #f8fafc; cursor: pointer;
      }
      .admin-modal-content input[type="file"]::file-selector-button {
          padding: 8px 16px; border: none; border-radius: 6px;
          background: #e2e8f0; color: #475569; font-weight: 600;
          cursor: pointer; transition: 0.2s; margin-right: 12px;
      }
      .admin-modal-content input[type="file"]::file-selector-button:hover {
          background: #cbd5e1;
      }
      .admin-modal-content input[type="file"]:hover {
          border-color: var(--purple-accent); background: #fff;
      }
      
      /* --- Admin Table Styles --- */
      .table-responsive { overflow-x: auto; }
      .admin-data-table { width: 100%; border-collapse: separate; border-spacing: 0; text-align: left; }
      .admin-data-table th { padding: 16px 20px; font-size: 13px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid var(--border-color); }
      .admin-data-table td { padding: 16px 20px; border-bottom: 1px solid var(--border-color); vertical-align: middle; }
      .admin-data-table tr:last-child td { border-bottom: none; }
      .admin-data-table tr:hover td { background-color: #f8fafc; }
      
      /* --- Action Buttons --- */
      .action-btn-group { display: flex; gap: 8px; }
      .action-btn { padding: 8px 12px; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: 0.2s; display: inline-flex; align-items: center; gap: 6px; outline: none; }
      .action-btn.edit { background: #eff6ff; color: #3b82f6; border: 1px solid #bfdbfe; }
      .action-btn.edit:hover { background: #dbeafe; color: #2563eb; }
      .action-btn.delete { background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; }
      .action-btn.delete:hover { background: #fee2e2; color: #dc2626; }

      /* --- Badges --- */
      .admin-badge { padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; display: inline-block; letter-spacing: 0.5px; text-transform: uppercase; }
      .admin-badge.pdf { background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; }
      .admin-badge.generic { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
  </style>
</head>
<body class="admin-app-viewport">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/admin_sidebar.php'; ?>

  <main class="main">
    <div class="page-header">
       <h1><i class="fas fa-tachometer-alt"></i>  Dashboard Manager</h1>
       <p>Manage the content displayed on the student dashboard directly from here.</p>
    </div>
    
    <div class="bottom-dashboard-section" style="padding-top: 0;">
       
       <!-- SECTION 1: DASHBOARD BOOKLET -->
       <div style="background: white; border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; box-shadow: var(--shadow-sm); margin-bottom: 30px;">
           <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 16px; color: var(--text-main);"><i class="fas fa-book-open" style="color: #3b82f6; margin-right: 8px;"></i> Dashboard Booklet</h2>
       
       <div class="header-actions">
           <p style="color: var(--text-muted); font-size: 13px; margin: 0;">Upload a PDF file to replace the default Admission Booklet on the student dashboard.</p>
           <button onclick="openDocModal()" class="btn-primary">
               <i class="fas fa-upload"></i> Upload New Booklet
           </button>
       </div>

       <div class="table-responsive">
           <table class="admin-data-table doc-table">
               <thead>
                   <tr>
                       <th>Title</th>
                       <th>File Info</th>
                       <th>Action</th>
                   </tr>
               </thead>
               <tbody>
                   <?php foreach ($docs as $d): ?>
                       <tr>
                           <td><strong style="color: var(--text-main); font-size: 15px;"><?php echo htmlspecialchars($d['title']); ?></strong></td>
                           <td>
                               <div style="display: flex; align-items: center; gap: 8px;">
                                   <span class="admin-badge pdf">PDF</span>
                                   <span style="font-size: 12px; color: var(--text-muted);"><?php echo basename(htmlspecialchars($d['file_path'])); ?></span>
                               </div>
                           </td>
                           <td>
                               <div class="action-btn-group">
                                   <button onclick="editDoc(<?php echo $d['id']; ?>, '<?php echo addslashes(htmlspecialchars($d['title'])); ?>')" class="action-btn edit">
                                       <i class="fas fa-edit"></i> Edit
                                   </button>
                                   <button onclick="confirmDelete('doc', <?php echo $d['id']; ?>)" class="action-btn delete">
                                       <i class="fas fa-trash-alt"></i> Delete
                                   </button>
                               </div>
                           </td>
                       </tr>
                   <?php endforeach; ?>
               </tbody>
           </table>
           
           <?php if (count($docs) === 0): ?>
               <div class="empty-state-container" style="background: white; padding: 20px; border-radius: 12px; text-align: center; border: 1px solid var(--border-color);">
                   <div class="empty-state-icon" style="font-size: 32px; color: #cbd5e1; margin-bottom: 12px;"><i class="fas fa-book"></i></div>
                   <div class="empty-state-title" style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">No Dashboard Booklet Uploaded</div>
                   <div class="empty-state-desc" style="font-size: 13px; color: var(--text-muted);">The student dashboard is currently displaying an empty state. Please upload a booklet.</div>
               </div>
           <?php endif; ?>
       </div>

       </div>
       
       <!-- SECTION 2: ANNOUNCEMENTS -->
       <div style="background: white; border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; box-shadow: var(--shadow-sm); margin-bottom: 30px;">
           <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 16px; color: var(--text-main);"><i class="fas fa-bullhorn" style="color: #ef4444; margin-right: 8px;"></i> Announcements</h2>
       
       <div class="header-actions">
           <div>
               <p style="color: var(--text-muted); font-size: 13px; margin: 0;">Only a maximum of 2 latest news items will be displayed.</p>
           </div>
           
           <?php if($total_ann < 2): ?>
               <button onclick="openAnnModal('add')" class="btn-primary">
                   <i class="fas fa-plus"></i> Add Announcement
               </button>
           <?php else: ?>
               <button class="btn-primary" style="background: #94a3b8; cursor: not-allowed;" title="Limit 2 reached">
                   <i class="fas fa-lock"></i> Quota Full (Max 2)
               </button>
           <?php endif; ?>
       </div>

       <div class="table-responsive">
           <table class="admin-data-table ann-table">
               <thead>
                   <tr>
                       <th>Title</th>
                       <th>Content Snippet</th>
                       <th>Author</th>
                       <th>Date</th>
                       <th>Action</th>
                   </tr>
               </thead>
               <tbody>
                   <?php foreach ($announcements as $a): ?>
                       <tr>
                           <td><strong style="color: var(--text-main); font-size: 15px;"><?php echo htmlspecialchars($a['title']); ?></strong></td>
                           <td style="color: var(--text-muted); font-size: 13px; max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                               <?php echo htmlspecialchars($a['content']); ?>
                           </td>
                           <td>
                               <span class="admin-badge generic">
                                   <?php echo htmlspecialchars($a['author']); ?>
                               </span>
                           </td>
                           <td style="font-size: 13px; color: var(--text-muted);">
                               <?php echo htmlspecialchars($a['created_at']); ?>
                           </td>
                           <td>
                               <div class="action-btn-group">
                                   <button onclick='openAnnModal("edit", <?php echo json_encode($a, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)' class="action-btn edit">
                                       <i class="fas fa-edit"></i> Edit
                                   </button>
                                   <button onclick="confirmDelete('ann', <?php echo $a['id']; ?>)" class="action-btn delete">
                                       <i class="fas fa-trash-alt"></i> Delete
                                   </button>
                               </div>
                           </td>
                       </tr>
                   <?php endforeach; ?>
               </tbody>
           </table>
           
           <?php if (count($announcements) === 0): ?>
               <div class="empty-state-container" style="background: white; padding: 20px; border-radius: 12px; text-align: center; border: 1px solid var(--border-color);">
                   <div class="empty-state-icon" style="font-size: 32px; color: #cbd5e1; margin-bottom: 12px;"><i class="fas fa-bullhorn"></i></div>
                   <div class="empty-state-title" style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">No Announcements</div>
                   <div class="empty-state-desc" style="font-size: 13px; color: var(--text-muted);">The student dashboard is currently using fallback default news.</div>
               </div>
           <?php endif; ?>
       </div>

       </div>

       <hr class="section-divider">

       <!-- SECTION 3: OTHER MODULES -->
       <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 16px; color: var(--text-main);">Other Modules</h2>
       <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px;">
           <a href="/admin/calendar_manage.php" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; text-decoration: none; color: var(--text-main); display: flex; align-items: center; gap: 16px; transition: transform 0.2s; box-shadow: var(--shadow-sm);">
               <div style="width: 50px; height: 50px; background: rgba(107, 33, 168, 0.1); color: var(--purple-accent); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                   <i class="fas fa-calendar-alt"></i>
               </div>
               <div>
                   <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 4px;">Academic Calendar</h3>
                   <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Update schedule</p>
               </div>
           </a>
           <a href="/admin/academics_docs_manage.php" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; text-decoration: none; color: var(--text-main); display: flex; align-items: center; gap: 16px; transition: transform 0.2s; box-shadow: var(--shadow-sm);">
               <div style="width: 50px; height: 50px; background: rgba(229, 62, 62, 0.1); color: #e53e3e; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                   <i class="fas fa-graduation-cap"></i>
               </div>
               <div>
                   <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 4px;">Academics Guidelines</h3>
                   <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Policy documents</p>
               </div>
           </a>
           <a href="/admin/department_docs_manage.php" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; text-decoration: none; color: var(--text-main); display: flex; align-items: center; gap: 16px; transition: transform 0.2s; box-shadow: var(--shadow-sm);">
               <div style="width: 50px; height: 50px; background: rgba(49, 130, 206, 0.1); color: #3182ce; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                   <i class="fas fa-building-columns"></i>
               </div>
               <div>
                   <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 4px;">Department Docs</h3>
                   <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Department files</p>
               </div>
           </a>
           <a href="/admin/exchange_docs_manage.php" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; text-decoration: none; color: var(--text-main); display: flex; align-items: center; gap: 16px; transition: transform 0.2s; box-shadow: var(--shadow-sm);">
               <div style="width: 50px; height: 50px; background: rgba(14, 165, 233, 0.1); color: #0ea5e9; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                   <i class="fas fa-plane-departure"></i>
               </div>
               <div>
                   <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 4px;">Student Exchange</h3>
                   <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Exchange info</p>
               </div>
           </a>
           <a href="/admin/internship_docs_manage.php" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; text-decoration: none; color: var(--text-main); display: flex; align-items: center; gap: 16px; transition: transform 0.2s; box-shadow: var(--shadow-sm);">
               <div style="width: 50px; height: 50px; background: rgba(245, 158, 11, 0.1); color: #f59e0b; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                   <i class="fas fa-briefcase"></i>
               </div>
               <div>
                   <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 4px;">Internship</h3>
                   <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Internship docs</p>
               </div>
           </a>
           <a href="/admin/scholarship_docs_manage.php" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; text-decoration: none; color: var(--text-main); display: flex; align-items: center; gap: 16px; transition: transform 0.2s; box-shadow: var(--shadow-sm);">
               <div style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.1); color: #10b981; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                   <i class="fas fa-hand-holding-heart"></i>
               </div>
               <div>
                   <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 4px;">Scholarship</h3>
                   <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Scholarship info</p>
               </div>
           </a>
           <a href="/admin/dormitory_docs_manage.php" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; text-decoration: none; color: var(--text-main); display: flex; align-items: center; gap: 16px; transition: transform 0.2s; box-shadow: var(--shadow-sm);">
               <div style="width: 50px; height: 50px; background: rgba(236, 72, 153, 0.1); color: #ec4899; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                   <i class="fas fa-building"></i>
               </div>
               <div>
                   <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 4px;">Dormitory</h3>
                   <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Housing files</p>
               </div>
           </a>
           <a href="/admin/library_docs_manage.php" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; text-decoration: none; color: var(--text-main); display: flex; align-items: center; gap: 16px; transition: transform 0.2s; box-shadow: var(--shadow-sm);">
               <div style="width: 50px; height: 50px; background: rgba(99, 102, 241, 0.1); color: #6366f1; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                   <i class="fas fa-book-open"></i>
               </div>
               <div>
                   <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 4px;">Library</h3>
                   <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Library resources</p>
               </div>
           </a>
           <a href="/admin/forms_docs_manage.php" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; text-decoration: none; color: var(--text-main); display: flex; align-items: center; gap: 16px; transition: transform 0.2s; box-shadow: var(--shadow-sm);">
               <div style="width: 50px; height: 50px; background: rgba(20, 184, 166, 0.1); color: #14b8a6; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                   <i class="fas fa-file-signature"></i>
               </div>
               <div>
                   <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 4px;">Forms & Services</h3>
                   <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Service forms</p>
               </div>
           </a>
       </div>
    </div>
  </main>

  <!-- DOC MODAL -->
  <div id="docModal" class="admin-modal-overlay">
      <div class="admin-modal-content">
          <div class="admin-modal-header">
              <h2 id="doc_form_title" class="admin-modal-title">Upload New Booklet</h2>
              <button class="admin-modal-close" onclick="closeDocModal()"><i class="fas fa-times"></i></button>
          </div>
          <form method="POST" action="" enctype="multipart/form-data">
              <input type="hidden" name="form_type" value="dashboard_doc">
              <input type="hidden" name="edit_id" id="doc_edit_id" value="">
              <div class="form-group">
                  <label>Document Title</label>
                  <input type="text" name="title" id="doc_title" required placeholder="e.g. JIU Admission Booklet">
              </div>
              <div class="form-group">
                  <label>Select File (PDF)</label>
                  <input type="file" name="file_upload" id="doc_file_upload" required accept=".pdf">
                  <p id="doc_file_help" style="font-size: 11px; color: var(--text-muted); margin-top: 6px; display: none;">Leave empty if editing title only.</p>
              </div>
              <div style="display: flex; gap: 12px; margin-top: 30px;">
                  <button type="submit" id="doc_submit_btn" class="btn-primary" style="flex: 1; justify-content: center;">Save Document</button>
                  <button type="button" onclick="closeDocModal()" class="btn-primary" style="background: #f1f5f9; color: #64748b; flex: 1; justify-content: center;">Cancel</button>
              </div>
          </form>
      </div>
  </div>

  <!-- ANN MODAL -->
  <div id="annModal" class="admin-modal-overlay">
      <div class="admin-modal-content" style="max-width: 600px;">
          <div class="admin-modal-header">
              <h2 id="ann_form_title" class="admin-modal-title">Add Announcement</h2>
              <button type="button" class="admin-modal-close" onclick="closeAnnModal()"><i class="fas fa-times"></i></button>
          </div>
          <form method="POST" action="">
              <input type="hidden" name="form_type" value="announcement">
              <input type="hidden" name="action" id="annAction" value="add">
              <input type="hidden" name="id" id="annId" value="">
              
              <div class="form-group">
                  <label>News Title</label>
                  <input type="text" name="title" id="annTitle" required placeholder="e.g. Midterm Exam Guidelines">
              </div>
              <div class="form-group">
                  <label>Content (Body)</label>
                  <textarea name="content" id="annContent" rows="5" required placeholder="Detailed information..."></textarea>
              </div>
              <div class="responsive-grid">
                  <div class="form-group" style="flex: 1;">
                      <label>Author / Office</label>
                      <input type="text" name="author" id="annAuthor" value="Admin Panel">
                  </div>
                  <div class="form-group" style="flex: 1;">
                      <label>Date</label>
                      <input type="date" name="created_at" id="annDate" value="<?php echo date('Y-m-d'); ?>" required>
                  </div>
              </div>
              <div style="display: flex; gap: 12px; margin-top: 30px;">
                  <button type="submit" id="ann_submit_btn" class="btn-primary" style="flex: 1; justify-content: center;">Save Announcement</button>
                  <button type="button" onclick="closeAnnModal()" class="btn-primary" style="background: #f1f5f9; color: #64748b; flex: 1; justify-content: center;">Cancel</button>
              </div>
          </form>
      </div>
  </div>
  
  <script>
      // DOC MODAL LOGIC
      const docModal = document.getElementById('docModal');
      function openDocModal() {
          document.getElementById('doc_edit_id').value = '';
          document.getElementById('doc_title').value = '';
          document.getElementById('doc_form_title').innerText = 'Upload New Booklet';
          document.getElementById('doc_submit_btn').innerText = 'Save Document';
          document.getElementById('doc_file_upload').required = true;
          document.getElementById('doc_file_help').style.display = 'none';
          docModal.classList.add('active');
      }
      function closeDocModal() { docModal.classList.remove('active'); }
      function editDoc(id, title) {
          document.getElementById('doc_edit_id').value = id;
          document.getElementById('doc_title').value = title;
          document.getElementById('doc_form_title').innerText = 'Edit Booklet';
          document.getElementById('doc_submit_btn').innerText = 'Update Booklet';
          document.getElementById('doc_file_upload').required = false;
          document.getElementById('doc_file_help').style.display = 'block';
          docModal.classList.add('active');
      }

      // ANN MODAL LOGIC
      const annModal = document.getElementById('annModal');
      function openAnnModal(action, data = null) {
          document.getElementById('annAction').value = action;
          if (action === 'add') {
              document.getElementById('ann_form_title').innerText = 'Add Announcement';
              document.getElementById('ann_submit_btn').innerText = 'Save Announcement';
              document.getElementById('annId').value = '';
              document.getElementById('annTitle').value = '';
              document.getElementById('annContent').value = '';
              document.getElementById('annAuthor').value = 'Admin Panel';
              document.getElementById('annDate').value = '<?php echo date('Y-m-d'); ?>';
          } else if (action === 'edit' && data) {
              document.getElementById('ann_form_title').innerText = 'Edit Announcement';
              document.getElementById('ann_submit_btn').innerText = 'Update Announcement';
              document.getElementById('annId').value = data.id;
              document.getElementById('annTitle').value = data.title;
              document.getElementById('annContent').value = data.content;
              document.getElementById('annAuthor').value = data.author;
              document.getElementById('annDate').value = data.created_at;
          }
          annModal.classList.add('active');
      }
      function closeAnnModal() { annModal.classList.remove('active'); }

      // DELETE CONFIRMATION
      function confirmDelete(type, id) {
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ef4444',
              cancelButtonColor: '#94a3b8',
              confirmButtonText: 'Yes, delete it!',
              borderRadius: '16px'
          }).then((result) => {
              if (result.isConfirmed) {
                  if(type === 'doc') {
                      window.location.href = '?delete_doc=' + id;
                  } else {
                      window.location.href = '?delete_ann=' + id;
                  }
              }
          })
      }

      // Close modals on outside click
      window.addEventListener('click', function(e) {
          if (e.target === docModal) closeDocModal();
          if (e.target === annModal) closeAnnModal();
      });
  </script>

  <?php if ($message): ?>
  <script>
      const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true
      });
      Toast.fire({
          icon: '<?php echo $message_type === "success" ? "success" : "error"; ?>',
          title: '<?php echo addslashes($message); ?>'
      });
  </script>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="/assets/js/main.js"></script>
</body>
</html>
