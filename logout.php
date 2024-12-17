<?php
session_start(); // Memulai sesi

// Menghapus semua variabel sesi
$_SESSION = [];

// Menghancurkan sesi
session_destroy();

// Menghapus cookie jika ada
if (isset($_COOKIE['username'])) {
    setcookie('username', '', time() - 3600, '/'); // Menghapus cookie dengan waktu kadaluarsa di masa lalu
}

// Alihkan pengguna kembali ke halaman utama
header('Location: index.php');
exit; // Menghentikan eksekusi script
?>