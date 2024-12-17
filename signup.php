<?php
session_start();
require 'db.php'; // Include the database connection file

$message = ''; // Inisialisasi variabel
$error = ''; // Inisialisasi variabel error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputUser = trim($_POST['username']);
    $inputPass = $_POST['password'];

    // Logika untuk menyimpan data pengguna ke database
    try {
        // Cek apakah username sudah ada
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $inputUser]);

        if ($stmt->rowCount() > 0) {
            $message = "Username sudah digunakan. Silakan pilih username lain.";
        } else {
            // Siapkan pernyataan SQL untuk menyimpan pengguna baru dengan role 'user'
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, 'user')");
            $stmt->execute(['username' => $inputUser, 'password' => $inputPass]); // Simpan password tanpa hashing

            // Simpan data dalam sesi
            $_SESSION['user'] = ['username' => $inputUser, 'role' => 'user'];

            $message = "Pendaftaran berhasil! Selamat datang, $inputUser.";

            // Redirect ke index.php setelah pendaftaran berhasil
            header("Location: index.php");
            exit; // Pastikan untuk keluar setelah redirect
        }
    } catch (PDOException $e) {
        $message = "Error: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Hijab Store</title>
    <link rel="stylesheet" href="css/signup.css"> <!-- Link to external CSS -->
</head>
<body>
<header>
    <h1>WELCOME T CICIRO WARDROBE</h1>
</header>
<div class="container">
    <h2>Daftar</h2>
    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form action="" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="btn">Daftar</button>
    </form>
    <div class="login-link">
        <p>Sudah punya akun? <a href="loginuser.php">Login di sini</a></p>
    </div>
</div>
</body>
</html>