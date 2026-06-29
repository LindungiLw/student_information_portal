<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Akses Ditolak! Anda bukan admin.");
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

$message = '';
$message_type = '';

// Temporary helper to clear calendar_documents table
if (isset($_GET['clear_docs'])) {
    $pdo->query('TRUNCATE TABLE calendar_documents');
    $message = "Calendar documents table cleared successfully!";
    $message_type = "success";
}

// Ensure event_color column exists in academic_calendar table
try {
    $pdo->exec("ALTER TABLE academic_calendar ADD COLUMN event_color VARCHAR(20) DEFAULT '#5c5fa3'");
} catch (PDOException $e) {
    // Column already exists, ignore
}

// Ensure calendar_documents table exists
$pdo->exec("CREATE TABLE IF NOT EXISTS calendar_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM academic_calendar WHERE id=?");
    if ($stmt->execute([$id])) {
        $message = "Event deleted successfully.";
        $message_type = "success";
    } else {
        $message = "Failed to delete event.";
        $message_type = "error";
    }
}

// Handle Add/Edit/Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_type = $_POST['form_type'] ?? 'event';
    
    if ($form_type === 'event') {
        $action = $_POST['action'] ?? '';
        $event_title = $_POST['event_title'] ?? '';
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';
        $category = $_POST['category'] ?? '';
        $academic_year = $_POST['academic_year'] ?? '';
        $event_color = $_POST['event_color'] ?? '#5c5fa3';
    
        if ($action === 'add') {
            $stmt = $pdo->prepare("INSERT INTO academic_calendar (event_title, start_date, end_date, category, academic_year, event_color) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$event_title, $start_date, $end_date, $category, $academic_year, $event_color])) {
                $message = "Event added successfully.";
                $message_type = "success";
            } else {
                $message = "Database error.";
                $message_type = "error";
            }
        } elseif ($action === 'edit') {
            $id = $_POST['id'] ?? 0;
            $stmt = $pdo->prepare("UPDATE academic_calendar SET event_title=?, start_date=?, end_date=?, category=?, academic_year=?, event_color=? WHERE id=?");
            if ($stmt->execute([$event_title, $start_date, $end_date, $category, $academic_year, $event_color, $id])) {
                $message = "Event updated successfully.";
                $message_type = "success";
            } else {
                $message = "Database error.";
                $message_type = "error";
            }
        }
    }

    if ($form_type === 'calendar_doc') {
        $edit_id = $_POST['edit_id'] ?? '';
        $title = $_POST['title'] ?? '';

        if (!empty($_FILES['file_upload']['name'])) {
            // Check file type
            $file_info = pathinfo($_FILES['file_upload']['name']);
            if (strtolower($file_info['extension']) !== 'pdf') {
                $message = "Please upload a valid PDF file.";
                $message_type = "error";
            } else {
                $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/assets/documents/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                // Keep the original filename or sanitize it
                $filename = preg_replace("/[^a-zA-Z0-9.\-_ ]/", "", basename($_FILES['file_upload']['name']));
                $target_file = $upload_dir . $filename;
                
                if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $target_file)) {
                    $file_url = '/assets/documents/' . $filename;
                    
                    if (empty($edit_id)) {
                        $stmt = $pdo->prepare("INSERT INTO calendar_documents (title, file_path) VALUES (?, ?)");
                        $stmt->execute([$title, $file_url]);
                        $message = "Document uploaded successfully.";
                        $message_type = "success";
                    } else {
                        $stmt = $pdo->prepare("UPDATE calendar_documents SET title=?, file_path=? WHERE id=?");
                        $stmt->execute([$title, $file_url, $edit_id]);
                        $message = "Document updated successfully.";
                        $message_type = "success";
                    }
                } else {
                    $message = "Failed to upload file.";
                    $message_type = "error";
                }
            }
        } else if (!empty($edit_id)) {
            // Update title only
            $stmt = $pdo->prepare("UPDATE calendar_documents SET title=? WHERE id=?");
            $stmt->execute([$title, $edit_id]);
            $message = "Document title updated successfully.";
            $message_type = "success";
        }
    }
}

// Handle Delete DOC
if (isset($_GET['delete_doc'])) {
    $id = (int)$_GET['delete_doc'];
    $stmt = $pdo->prepare("SELECT file_path FROM calendar_documents WHERE id=?");
    $stmt->execute([$id]);
    $doc = $stmt->fetch();
    if ($doc) {
        $file_abs_path = $_SERVER['DOCUMENT_ROOT'] . $doc['file_path'];
        if (file_exists($file_abs_path)) {
            @unlink($file_abs_path);
        }
        $pdo->prepare("DELETE FROM calendar_documents WHERE id=?")->execute([$id]);
        $message = "Document deleted successfully!";
        $message_type = "success";
    }
}

// Fetch all events
$stmt = $pdo->query("SELECT * FROM academic_calendar ORDER BY start_date ASC");
$events = $stmt->fetchAll();

// Fetch calendar documents
$stmt_docs = $pdo->query("SELECT * FROM calendar_documents ORDER BY id DESC LIMIT 1");
$docs = $stmt_docs->fetchAll();
$total_docs = count($docs);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Calendar | Admin Portal</title>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/dashboard.css?v=11">
  <link rel="stylesheet" href="/assets/css/sidebar.css?v=3">
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/responsive.css?v=4">
  
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
      .btn-primary { background: var(--purple-accent); color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 700; font-size: 14px; transition: 0.2s; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; cursor: pointer; }
      .btn-primary:hover { background: var(--purple-accent-hover); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(107, 111, 160, 0.2); }
      .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
      .header-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
  </style>
</head>
<body class="admin-app-viewport">
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/svg_icons.php'; ?>
  <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/admin_sidebar.php'; ?>

  <main class="main">
    <div class="page-header">
       <h1><i class="fas fa-calendar-alt"></i> Manage Calendar</h1>
       <p>Manage the academic calendar events displayed on the student portal.</p>
    </div>
    
    <div class="bottom-dashboard-section" style="padding-top: 0;">
        <!-- SECTION 1: ACADEMIC CALENDAR PDF -->
        <div style="background: white; border: 1px solid var(--border-color); border-radius: 12px; padding: 24px; box-shadow: var(--shadow-sm); margin-bottom: 30px;">
            <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 16px; color: var(--text-main);"><i class="fas fa-file-pdf" style="color: #ef4444; margin-right: 8px;"></i> Academic Calendar PDF</h2>
            
            <div class="header-actions">
                <div>
                    <p style="color: var(--text-muted); font-size: 13px; margin: 0;">This PDF will be displayed on the Academic Calendar page as a preview. (Max 1 file)</p>
                </div>
                
                <?php if($total_docs < 1): ?>
                    <button onclick="openDocModal()" class="btn-primary">
                        <i class="fas fa-upload"></i> Upload PDF
                    </button>
                <?php else: ?>
                    <button class="btn-primary" style="background: #94a3b8; cursor: not-allowed;" title="Limit reached">
                        <i class="fas fa-lock"></i> Quota Full (Max 1)
                    </button>
                <?php endif; ?>
            </div>

            <table class="admin-data-table">
                <thead>
                    <tr>
                        <th>Document Title</th>
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
                                    <button onclick="openDocModal(<?php echo $d['id']; ?>, '<?php echo addslashes(htmlspecialchars($d['title'])); ?>')" class="action-btn edit">
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
                    <div class="empty-state-title" style="font-size: 16px; font-weight: 700; margin-bottom: 8px;">No PDF Uploaded</div>
                    <div class="empty-state-desc" style="font-size: 13px; color: var(--text-muted);">The calendar page is currently using the default fallback PDF. Please upload a new one.</div>
                </div>
            <?php endif; ?>
        </div>

        <hr class="section-divider">

        <!-- SECTION 2: CALENDAR EVENTS -->
        <h2 style="font-size: 18px; font-weight: 700; margin-bottom: 16px; color: var(--text-main);"><i class="fas fa-calendar-alt" style="color: var(--purple-accent); margin-right: 8px;"></i> Calendar Events</h2>
        
       <div class="header-actions">
           <h3 style="margin: 0; font-size: 15px; color: var(--text-muted);">Manage events displayed on the grid calendar</h3>
           <button onclick="openModal('add')" class="btn-primary">
               <i class="fas fa-plus"></i> Add Event
           </button>
       </div>

       <div class="table-responsive">
           <table class="admin-data-table cal-table">
               <thead>
                   <tr>
                       <th>Event Title</th>
                       <th>Date</th>
                       <th>Category</th>
                       <th>Year</th>
                       <th>Action</th>
                   </tr>
               </thead>
               <tbody>
                   <?php foreach ($events as $e): 
                       $bgColor = htmlspecialchars($e['event_color'] ?? '#5c5fa3');
                   ?>
                       <tr>
                           <td><strong style="color: var(--text-main); font-size: 15px;"><?php echo htmlspecialchars($e['event_title']); ?></strong></td>
                           <td style="color: var(--text-muted); font-size: 13px;">
                               <?php echo $e['start_date'] . ($e['start_date'] !== $e['end_date'] ? ' to ' . $e['end_date'] : ''); ?>
                           </td>
                           <td>
                               <span class="admin-badge" style="background: <?php echo $bgColor; ?>20; color: <?php echo $bgColor; ?>; border: 1px solid <?php echo $bgColor; ?>40;">
                                   <?php echo htmlspecialchars($e['category']); ?>
                               </span>
                           </td>
                           <td style="font-size: 13px; color: var(--text-muted);">
                               <?php echo htmlspecialchars($e['academic_year']); ?>
                           </td>
                           <td>
                               <div class="action-btn-group">
                                   <button onclick='editEvent(<?php echo $e['id']; ?>, <?php echo json_encode($e['event_title'], JSON_HEX_APOS | JSON_HEX_QUOT); ?>, "<?php echo $e['start_date']; ?>", "<?php echo $e['end_date']; ?>", "<?php echo htmlspecialchars($e['category']); ?>", "<?php echo htmlspecialchars($e['academic_year']); ?>", "<?php echo htmlspecialchars($e['event_color']); ?>")' class="action-btn edit">
                                       <i class="fas fa-edit"></i> Edit
                                   </button>
                                   <button onclick="confirmDelete('event', <?php echo $e['id']; ?>)" class="action-btn delete">
                                       <i class="fas fa-trash-alt"></i> Delete
                                   </button>
                               </div>
                           </td>
                       </tr>
                   <?php endforeach; ?>
               </tbody>
           </table>
           
           <?php if (count($events) === 0): ?>
               <div class="empty-state-container">
                   <div class="empty-state-icon"><i class="fas fa-calendar-alt"></i></div>
                   <div class="empty-state-title">No Events Found</div>
                   <div class="empty-state-desc">Start adding important dates to the academic calendar.</div>
                   <button onclick="openModal('add')" class="btn-primary">
                       <i class="fas fa-plus"></i> Add First Event
                   </button>
               </div>
           <?php endif; ?>
       </div>
    </div>
  </main>

  <!-- DOC MODAL -->
  <div id="docModal" class="admin-modal-overlay">
      <div class="admin-modal-content">
          <div class="admin-modal-header">
              <h2 id="doc_form_title" class="admin-modal-title">Upload Calendar PDF</h2>
              <button type="button" class="admin-modal-close" onclick="closeDocModal()"><i class="fas fa-times"></i></button>
          </div>
          <form method="POST" action="" enctype="multipart/form-data">
              <input type="hidden" name="form_type" value="calendar_doc">
              <input type="hidden" name="edit_id" id="doc_edit_id" value="">
              <div class="form-group">
                  <label>Document Title</label>
                  <input type="text" name="title" id="doc_title" required placeholder="e.g. Academic Calendar TA 2025/2026">
              </div>
              <div class="form-group">
                  <label>Select File (PDF)</label>
                  <input type="file" name="file_upload" id="doc_file_upload" required accept=".pdf">
                  <p id="doc_file_help" style="font-size: 11px; color: var(--text-muted); margin-top: 6px; display: none;">Leave empty if editing title only.</p>
              </div>
              <div style="display: flex; gap: 12px; margin-top: 30px;">
                  <button type="submit" class="btn-primary" style="flex: 1; justify-content: center;">Save Document</button>
                  <button type="button" onclick="closeDocModal()" class="btn-primary" style="background: #f1f5f9; color: #64748b; flex: 1; justify-content: center;">Cancel</button>
              </div>
          </form>
      </div>
  </div>

  <!-- EVENT MODAL -->
  <div id="documentModal" class="admin-modal-overlay">
      <div class="admin-modal-content" style="max-width: 500px;">
          <div class="admin-modal-header">
              <h2 id="form_title" class="admin-modal-title">Add Event</h2>
              <button type="button" class="admin-modal-close" onclick="closeModal()">
                  <i class="fas fa-times"></i>
              </button>
          </div>
          <form method="POST" action="">
              <input type="hidden" name="form_type" value="event">
              <input type="hidden" name="action" id="formAction" value="add">
              <input type="hidden" name="id" id="eventId" value="">
              
              <div class="form-group">
                  <label>Event Title</label>
                  <input type="text" name="event_title" id="eventTitle" required placeholder="e.g. Midterm Exams">
              </div>
              <div class="responsive-grid">
                  <div class="form-group">
                      <label>Start Date</label>
                      <input type="date" name="start_date" id="startDate" required>
                  </div>
                  <div class="form-group">
                      <label>End Date</label>
                      <input type="date" name="end_date" id="endDate" required>
                  </div>
              </div>
              <div class="responsive-grid">
                  <div class="form-group">
                      <label>Category</label>
                      <select name="category" id="eventCategory" required style="width: 100%; padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 8px; font-family: inherit; font-size: 14px; outline: none; transition: 0.2s; box-sizing: border-box; appearance: auto;">
                          <option value="Academics">Academics</option>
                          <option value="Exams">Exams</option>
                          <option value="Holidays">Holidays</option>
                          <option value="Events">Events</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label>Event Color</label>
                      <div style="display: flex; align-items: center; gap: 10px;">
                          <input type="color" name="event_color" id="eventColor" value="#5c5fa3" style="width: 40px; height: 40px; padding: 2px; border: 1px solid #e2e8f0; border-radius: 6px; cursor: pointer;">
                          <span style="font-size: 13px; color: var(--text-muted);">Pick a color</span>
                      </div>
                  </div>
              </div>
              
              <div class="form-group">
                  <label>Academic Year</label>
                  <input type="text" name="academic_year" id="academicYear" placeholder="e.g. 2025/2026" required>
              </div>

              <div style="display: flex; gap: 12px; margin-top: 30px;">
                  <button type="submit" id="event_submit_btn" class="btn-primary" style="flex: 1; justify-content: center;">Save Event</button>
                  <button type="button" onclick="closeModal()" class="btn-primary" style="background: #f1f5f9; color: #64748b; flex: 1; justify-content: center;">Cancel</button>
              </div>
          </form>
      </div>
  </div>
  
  <script>
      const modal = document.getElementById('documentModal');
      
      function openModal(mode, data = null) {
          const title = document.getElementById('form_title');
          const action = document.getElementById('formAction');
          const submitBtn = document.getElementById('event_submit_btn');
          
          if (mode === 'add') {
              title.innerText = 'Add New Event';
              action.value = 'add';
              document.getElementById('eventId').value = '';
              document.getElementById('eventTitle').value = '';
              document.getElementById('startDate').value = '';
              document.getElementById('endDate').value = '';
              document.getElementById('eventCategory').value = 'Academics';
              document.getElementById('eventColor').value = '#5c5fa3';
              document.getElementById('academicYear').value = '';
              submitBtn.innerText = 'Save Event';
          }
          modal.classList.add('active');
      }

      function editEvent(id, title, start, end, cat, yr, color) {
          const action = document.getElementById('formAction');
          const submitBtn = document.getElementById('event_submit_btn');
          const modalTitle = document.getElementById('form_title');
          
          modalTitle.innerText = 'Edit Event';
          action.value = 'edit';
          document.getElementById('eventId').value = id;
          document.getElementById('eventTitle').value = title;
          document.getElementById('startDate').value = start;
          document.getElementById('endDate').value = end;
          document.getElementById('eventCategory').value = cat;
          document.getElementById('academicYear').value = yr;
          document.getElementById('eventColor').value = color || '#5c5fa3';
          submitBtn.innerText = 'Update Event';
          document.getElementById('documentModal').classList.add('active');
      }

      function closeModal() {
          modal.classList.remove('active');
      }

      function openDocModal(id = null, title = '') {
          const modal = document.getElementById('docModal');
          document.getElementById('doc_edit_id').value = id || '';
          document.getElementById('doc_title').value = title;
          document.getElementById('doc_form_title').innerText = id ? 'Edit Calendar PDF' : 'Upload Calendar PDF';
          
          const fileInput = document.getElementById('doc_file_upload');
          const fileHelp = document.getElementById('doc_file_help');
          if (id) {
              fileInput.removeAttribute('required');
              fileHelp.style.display = 'block';
          } else {
              fileInput.setAttribute('required', 'required');
              fileHelp.style.display = 'none';
          }
          modal.classList.add('active');
      }

      function closeDocModal() {
          document.getElementById('docModal').classList.remove('active');
      }

      function confirmDelete(type, id) {
          Swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ef4444',
              cancelButtonColor: '#94a3b8',
              confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
              if (result.isConfirmed) {
                  if (type === 'event') {
                      window.location.href = `?delete=${id}`;
                  } else if (type === 'doc') {
                      window.location.href = `?delete_doc=${id}`;
                  }
              }
          })
      }

      modal.addEventListener('click', function(e) {
          if (e.target === this) {
              closeModal();
          }
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

  <script src="/assets/js/main.js"></script>
</body>
</html>
