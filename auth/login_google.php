<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/koneksi.php';

// URL Endpoint Authorization Google
$authUrl = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
    'client_id' => GOOGLE_CLIENT_ID,
    'redirect_uri' => GOOGLE_REDIRECT_URI,
    'response_type' => 'code',
    'scope' => 'email profile', // Kita hanya minta izin membaca email dan profil dasar
    'access_type' => 'online',
    'prompt' => 'select_account' // Memaksa user memilih akun setiap kali login
]);

// Redirect pengguna ke Google
header("Location: $authUrl");
exit;
?>
