<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

// Jika tidak ada kode balasan dari Google, tolak akses
if (!isset($_GET['code'])) {
    die("Error: Tidak ada kode autentikasi dari Google.");
}

$code = $_GET['code'];

// 1. Tukar Code dengan Access Token
$tokenUrl = 'https://oauth2.googleapis.com/token';
$postData = [
    'code' => $code,
    'client_id' => GOOGLE_CLIENT_ID,
    'client_secret' => GOOGLE_CLIENT_SECRET,
    'redirect_uri' => GOOGLE_REDIRECT_URI,
    'grant_type' => 'authorization_code'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tokenUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Matikan verifikasi SSL untuk localhost, NYALAKAN jika di server asli
$response = curl_exec($ch);
$tokenData = json_decode($response, true);
curl_close($ch);

if (isset($tokenData['error'])) {
    die("Error mendapatkan token: " . (isset($tokenData['error_description']) ? $tokenData['error_description'] : 'Unknown error'));
}

$accessToken = $tokenData['access_token'];

// 2. Ambil Data Profil User dari Google
$userInfoUrl = 'https://www.googleapis.com/oauth2/v2/userinfo';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $userInfoUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $accessToken"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$userResponse = curl_exec($ch);
$googleUser = json_decode($userResponse, true);
curl_close($ch);

if (!isset($googleUser['email'])) {
    die("Error: Tidak bisa mengambil data email dari Google.");
}

$email = $googleUser['email'];
$name = $googleUser['name'];
$google_id = $googleUser['id'];

// 3. Validasi Domain Kampus
if (strpos($email, ALLOWED_DOMAIN) === false) {
    die("Akses Ditolak! Anda harus menggunakan email institusi (" . ALLOWED_DOMAIN . ") untuk masuk ke portal ini.");
}

// 4. Masukkan Data Profil Google Langsung ke Sesi (TANPA DATABASE)
// Sebagai awalan, NIM bisa diambil dari bagian depan email (sebelum @)
$nim_temp = explode('@', $email)[0]; 

// Buat Sesi Login PHP
$_SESSION['user_id'] = $google_id;
$_SESSION['email'] = $email;
$_SESSION['name'] = $name;
$_SESSION['nim'] = $nim_temp;

// Alihkan ke Dashboard
header("Location: /dashboard.php");
exit;
?>
