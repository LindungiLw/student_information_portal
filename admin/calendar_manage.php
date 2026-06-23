<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Akses Ditolak! Anda bukan admin.");
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

// Handle Add/Edit/Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add' || $action === 'edit') {
        $event_title = $_POST['event_title'] ?? '';
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';
        $category = $_POST['category'] ?? '';
        $academic_year = $_POST['academic_year'] ?? '';
        
        if ($action === 'add') {
            $stmt = $pdo->prepare("INSERT INTO academic_calendar (event_title, start_date, end_date, category, academic_year) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$event_title, $start_date, $end_date, $category, $academic_year]);
        } else {
            $id = $_POST['id'] ?? 0;
            $stmt = $pdo->prepare("UPDATE academic_calendar SET event_title=?, start_date=?, end_date=?, category=?, academic_year=? WHERE id=?");
            $stmt->execute([$event_title, $start_date, $end_date, $category, $academic_year, $id]);
        }
        header("Location: /admin/calendar_manage.php");
        exit;
    } elseif ($action === 'delete') {
        $id = $_POST['id'] ?? 0;
        $stmt = $pdo->prepare("DELETE FROM academic_calendar WHERE id=?");
        $stmt->execute([$id]);
        header("Location: /admin/calendar_manage.php");
        exit;
    }
}

// Fetch all events
$stmt = $pdo->query("SELECT * FROM academic_calendar ORDER BY start_date ASC");
$events = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Calendar | JIU Admin</title>
  <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="/assets/css/variables.css">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/dashboard.css">
  <link rel="stylesheet" href="/assets/css/sidebar.css">
  <style>
      .admin-table {
          width: 100%;
          border-collapse: collapse;
          margin-top: 20px;
          background: var(--card-bg);
          border-radius: 12px;
          overflow: hidden;
          box-shadow: var(--shadow-sm);
      }
      .admin-table th, .admin-table td {
          padding: 16px;
          text-align: left;
          border-bottom: 1px solid var(--border-color);
      }
      .admin-table th {
          background: rgba(107, 33, 168, 0.05);
          color: var(--text-main);
          font-weight: 700;
          font-size: 14px;
          text-transform: uppercase;
      }
      .admin-table tr:last-child td {
          border-bottom: none;
      }
      .btn {
          padding: 8px 16px;
          border: none;
          border-radius: 6px;
          font-weight: 600;
          cursor: pointer;
          font-size: 13px;
          text-decoration: none;
          display: inline-block;
      }
      .btn-primary { background: var(--purple-accent); color: white; }
      .btn-danger { background: #e53e3e; color: white; }
      .form-group { margin-bottom: 16px; }
      .form-group label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 14px; }
      .form-group input, .form-group select {
          width: 100%;
          padding: 10px;
          border: 1px solid var(--border-color);
          border-radius: 8px;
          background: var(--bg-color);
          color: var(--text-main);
      }
      .modal {
          display: none;
          position: fixed; inset: 0; background: rgba(0,0,0,0.5);
          align-items: center; justify-content: center; z-index: 1000;
      }
      .modal.active { display: flex; }
      .modal-content {
          background: var(--card-bg);
          padding: 30px;
          border-radius: 16px;
          width: 100%;
          max-width: 500px;
      }
  </style>
</head>
<body>
  
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <div class="logo"><i class="fas fa-shield-alt"></i> JIU ADMIN</div>
    </div>
    <nav class="sidebar-nav">
      <ul class="nav-list">
        <li class="nav-item"><a href="/admin/dashboard.php" class="nav-link"><i class="fas fa-tachometer-alt"></i> <span>Overview</span></a></li>
        <li class="nav-item"><a href="/admin/calendar_manage.php" class="nav-link active"><i class="fas fa-calendar-alt"></i> <span>Academic Calendar</span></a></li>
      </ul>
    </nav>
    <div class="sidebar-footer">
      <a href="/auth/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> <span>Log Out</span></a>
    </div>
  </aside>

  <main class="main">
    <header class="header">
        <div class="user-profile">
            <div class="user-info">
                <span class="user-name"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
                <span class="user-role">Administrator</span>
            </div>
        </div>
    </header>

    <div class="bottom-dashboard-section" style="padding-top: 20px;">
       <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
           <div class="section-title" style="font-size: 28px; border:none;">
             <i class="fas fa-calendar-alt" style="color: var(--purple-accent); margin-right: 12px;"></i> Manage Calendar
           </div>
           <button class="btn btn-primary" onclick="openModal('add')"><i class="fas fa-plus"></i> Add Event</button>
       </div>

       <table class="admin-table">
           <thead>
               <tr>
                   <th>Event Title</th>
                   <th>Date</th>
                   <th>Category</th>
                   <th>Year</th>
                   <th>Actions</th>
               </tr>
           </thead>
           <tbody>
               <?php foreach ($events as $e): ?>
               <tr>
                   <td><strong><?php echo htmlspecialchars($e['event_title']); ?></strong></td>
                   <td><?php echo $e['start_date'] . ($e['start_date'] !== $e['end_date'] ? ' to ' . $e['end_date'] : ''); ?></td>
                   <td><span style="background: rgba(107,33,168,0.1); color: var(--purple-accent); padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 700;"><?php echo htmlspecialchars($e['category']); ?></span></td>
                   <td><?php echo htmlspecialchars($e['academic_year']); ?></td>
                   <td style="display: flex; gap: 8px;">
                       <button class="btn btn-primary" onclick="openModal('edit', <?php echo htmlspecialchars(json_encode($e)); ?>)">Edit</button>
                       <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this event?');">
                           <input type="hidden" name="action" value="delete">
                           <input type="hidden" name="id" value="<?php echo $e['id']; ?>">
                           <button type="submit" class="btn btn-danger">Delete</button>
                       </form>
                   </td>
               </tr>
               <?php endforeach; ?>
               <?php if(empty($events)): ?>
               <tr><td colspan="5" style="text-align:center;">No events found.</td></tr>
               <?php endif; ?>
           </tbody>
       </table>
    </div>
  </main>

  <!-- Modal Form -->
  <div class="modal" id="eventModal">
      <div class="modal-content">
          <h2 id="modalTitle" style="margin-bottom: 20px;">Add Event</h2>
          <form method="POST" id="eventForm">
              <input type="hidden" name="action" id="formAction" value="add">
              <input type="hidden" name="id" id="eventId" value="">
              
              <div class="form-group">
                  <label>Event Title</label>
                  <input type="text" name="event_title" id="eventTitle" required>
              </div>
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                  <div class="form-group">
                      <label>Start Date</label>
                      <input type="date" name="start_date" id="startDate" required>
                  </div>
                  <div class="form-group">
                      <label>End Date</label>
                      <input type="date" name="end_date" id="endDate" required>
                  </div>
              </div>
              <div class="form-group">
                  <label>Category</label>
                  <select name="category" id="eventCategory" required>
                      <option value="Academics">Academics</option>
                      <option value="Exams">Exams</option>
                      <option value="Holidays">Holidays</option>
                      <option value="Events">Events</option>
                  </select>
              </div>
              <div class="form-group">
                  <label>Academic Year</label>
                  <input type="text" name="academic_year" id="academicYear" placeholder="e.g. 2025/2026" required>
              </div>
              
              <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                  <button type="button" class="btn" style="background: var(--border-color); color: var(--text-main);" onclick="closeModal()">Cancel</button>
                  <button type="submit" class="btn btn-primary">Save Event</button>
              </div>
          </form>
      </div>
  </div>

  <script>
      function openModal(mode, data = null) {
          const modal = document.getElementById('eventModal');
          const title = document.getElementById('modalTitle');
          const action = document.getElementById('formAction');
          
          if (mode === 'add') {
              title.innerText = 'Add New Event';
              action.value = 'add';
              document.getElementById('eventForm').reset();
          } else {
              title.innerText = 'Edit Event';
              action.value = 'edit';
              document.getElementById('eventId').value = data.id;
              document.getElementById('eventTitle').value = data.event_title;
              document.getElementById('startDate').value = data.start_date;
              document.getElementById('endDate').value = data.end_date;
              document.getElementById('eventCategory').value = data.category;
              document.getElementById('academicYear').value = data.academic_year;
          }
          modal.classList.add('active');
      }

      function closeModal() {
          document.getElementById('eventModal').classList.remove('active');
      }
  </script>
</body>
</html>
