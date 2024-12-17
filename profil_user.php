<?php
session_start();
include 'db.php';

// Ambil data pengguna dari database
$username = $_SESSION['username'];
$user = null;

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Gagal mengambil data pengguna: " . htmlspecialchars($e->getMessage());
}

// Proses update data pengguna
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET username = :username, password = :password WHERE username = :old_username");
        $stmt->execute(['username' => $new_username, 'password' => $new_password, 'old_username' => $username]);

        // Update sesi username jika diubah
        $_SESSION['username'] = $new_username;
        header('Location: profil_user.php'); // Refresh halaman profil
        exit();
    } catch (PDOException $e) {
        echo "Gagal memperbarui data: " . htmlspecialchars($e->getMessage());
    }
}

// Proses hapus akun
if (isset($_POST['delete'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);

        session_destroy(); // Hapus sesi
        header('Location: userlogin.php'); // Arahkan ke halaman login
        exit();
    } catch (PDOException $e) {
        echo "Gagal menghapus akun: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url('background.jpg'); /* Gambar latar belakang */
            background-size: cover; /* Pastikan gambar memenuhi seluruh layar */
            background-repeat: no-repeat; /* Hindari pengulangan gambar */
            background-position: center; /* Memusatkan gambar latar */
        }
        header, footer {
            background-color: rgba(139, 69, 19, 0.8); /* Warna latar dengan transparansi */
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        main {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .profile-container {
            background-color: rgba(254, 211, 160, 0.9); /* Warna latar belakang kontainer dengan transparansi */
            padding: 20px;
            border-radius: 15px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        form label, form input, form button {
            margin-bottom: 15px;
            border-radius: 4px;
            padding: 6px;
        }
        form input {
            border: 1px solid #ccc;
            outline: none;
        }
        form button {
            background-color: rgb(155, 114, 60);
            color: #fff;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: rgb(106, 88, 59);
        }
    </style>
</head>
<body>
    <header>
        <h1>Profil Pengguna</h1>
    </header>
    <main>
        <div class="profile-container">
            <h2>Informasi Anda</h2>
            <form method="POST">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password baru" required>
                <button type="submit" name="update">Perbarui</button>
            </form>
            <form method="POST">
                <button type="submit" name="delete" style="background-color: red;">Hapus Akun</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Hijab Store</p>
    </footer>
</body>
</html>