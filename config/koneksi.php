<?php
// File koneksi disiapkan untuk pengembangan masa depan (Fitur Admin).
// Saat ini aplikasi berjalan dalam mode "Statik/Dummy" tanpa database.

// --- Konfigurasi Google OAuth 2.0 (SSO) ---
// TODO: Ganti dengan kredensial asli dari Google Cloud Console nantinya
define('GOOGLE_CLIENT_ID', 'YOUR_CLIENT_ID_HERE');
define('GOOGLE_CLIENT_SECRET', 'YOUR_CLIENT_SECRET_HERE');
define('GOOGLE_REDIRECT_URI', 'https://test.jiulibrary.ac/auth/sso_callback.php'); 
define('ALLOWED_DOMAIN', '@jiu.ac'); 

/* 
// [DATABASE CONNECTION DISABLED FOR NOW]
$host = 'localhost';
$dbname = 'db_portal';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
*/
?>
