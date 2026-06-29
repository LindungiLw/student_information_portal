<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Vary: User-Agent");
session_start();

// Jika sudah login, langsung arahkan ke dashboard sesuai role & perangkat
if (isset($_SESSION['user_id'])) {
    $useragent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $isMobile = preg_match('/(android|webos|iphone|ipad|ipod|blackberry|windows phone)/i', $useragent);
    
    if ($_SESSION['role'] === 'admin' && !$isMobile) {
        header('Location: /admin/dashboard.php');
    } else {
        header('Location: /dashboard.php');
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JIU Student Information Portal</title>
    
    <link rel="icon" type="image/png" href="/assets/images/jiu-logo-rounded.png?v=1">

    <!-- Link to your modular CSS files -->
    <link rel="stylesheet" href="/assets/css/global.css?v=30">
    <link rel="stylesheet" href="/assets/css/landing.css?v=30">
    <link rel="stylesheet" href="/assets/css/responsive.css?v=30">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>

    <main class="hero-section">
        <!-- Top Navigation Area -->
        <nav class="top-nav">
            <img src="/assets/images/jiu-logo-rounded.png" alt="Jakarta International University Logo" class="main-logo">
            <span class="nav-brand-text">Jakarta International University</span>
        </nav>

        <!-- Main Hero Content -->
        <div class="hero-container">
            <h1 class="headline">Your Academic Life, <span class="highlight">Simplified</span></h1>
            <p class="sub-headline">
                Access all academic information, student activities, and campus services
                within a single integrated platform.
            </p>

            <div class="cta-wrapper">
                <!-- Tombol SSO Tunggal -->
                <a href="/auth/login_google.php" class="btn btn-glass" style="display: inline-flex; align-items: center; justify-content: center; gap: 10px; background-color: rgba(255,255,255,0.9); color: #333; font-weight: 600;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google Logo" style="width: 20px;">
                    Sign in with JIU Account
                </a>
            </div>
        </div>

        <!-- Branding Footer Section -->
        <footer class="hero-footer">
            <div class="divider"></div>
            <div class="copyright">© 2023 Student Information Portal. All rights reserved.</div>
        </footer>
    </main>

    <!-- Project Logic Script -->
    <script src="/assets/js/main.js"></script>
</body>

</html>

