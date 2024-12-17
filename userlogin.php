<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url('images/background.jpg'); /* Pastikan gambar berada di folder images */
            background-size: cover; /* Gambar akan memenuhi seluruh layar */
            background-repeat: no-repeat; /* Gambar tidak akan diulang */
            background-position: center; /* Posisi gambar di tengah layar */
}

        }
        header, footer {
            background-color: sienna;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        main {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background-color: tan;
            padding: 20px;
            border-radius: 15px;
            width: 300px;
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
            padding: 10px;
            cursor: pointer;
            border-radius: 8px;
        }
        form button:hover {
            background-color: rgb(106, 88, 59);
        }
        .error-message {
            color: red;
            font-weight: bold;
        }
        .register-link {
            font-size: 0.8em;
            text-decoration: underline;
            color: blue;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Ciciro Wardrobe</h1>
    </header>
    <main>
        <div class="login-container">
            <h2>Login</h2>
            <?php
            session_start();

            // Konfigurasi database
            $host = "localhost";
            $dbuser = "root"; // Username database
            $dbpass = ""; // Password database
            $dbname = "ecommerce_db"; // Nama database yang benar

                try {
                    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    echo "<p class='error-message'>Gagal terhubung ke database: " . htmlspecialchars($e->getMessage()) . "</p>";
                    exit();
                }
                // Cek cookie untuk login otomatis
                if (isset($_COOKIE['username'])) {
                    $_SESSION['username'] = $_COOKIE['username'];
                    header('location: index_user.php');
                    exit;
                }

               // Proses login
                if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Memeriksa apakah form telah disubmit
                    $username = $_POST['username']; // Mengambil username dari input
                    $password = $_POST['password']; // Mengambil password dari input
                    $remember = isset($_POST['remember']); // Memeriksa apakah checkbox 'Remember Me' dicentang

                    // Query database
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username"); // Menyiapkan query untuk mengambil data pengguna
                    $stmt->execute(['username' => $username]); // Menjalankan query dengan parameter
                    $user = $stmt->fetch(PDO::FETCH_ASSOC); // Mengambil hasil sebagai associative array

                    if ($user) { // Jika pengguna ditemukan
                        // Bandingkan password
                        if ($password === $user['password']) { // Memeriksa apakah password cocok
                            // Simpan informasi ke session
                            $_SESSION['username'] = $user['username']; // Menyimpan username ke sesi

                            // Jika "Remember Me" dipilih, simpan cookie
                            if ($remember) {
                                setcookie('username', $username, time() + (86400 * 30), "/"); // Mengatur cookie untuk 30 hari
                            }

                            // Redirect ke halaman index_user.php
                            header('location: index_user.php'); // Mengarahkan ke dashboard
                            exit; // Menghentikan eksekusi script
                        } else {
                            echo "<p class='error-message'>Password salah!</p>"; // Menampilkan pesan error jika password salah
                        }
                    } else {
                        echo "<p class='error-message'>Username tidak terdaftar!</p>"; // Menampilkan pesan error jika username tidak ditemukan
                    }
                }

            ?>
            <form method="POST" action=""> <!-- Form untuk login -->
                <label for="username">Username</label> <!-- Label untuk input username -->
                <input type="text" name="username" id="username" placeholder="Masukkan username Anda" required> <!-- Input untuk username -->
                <label for="password">Password</label> <!-- Label untuk input password -->
                <input type="password" name="password" id="password" placeholder="Masukkan password Anda" required> <!-- Input untuk password -->
                <label>
                    <input type="checkbox" name="remember"> Remember Me <!-- Checkbox untuk opsi 'Remember Me' -->
                </label>
                <button type="submit">Login</button> <!-- Tombol untuk submit form -->
            </form>
            <p>Tidak Punya Akun? <a href="SignUp.php" class="register-link">Daftar Disini</a></p> <!-- Teks untuk pendaftaran -->
        </div>
    </main>
    <footer>
        <p>Copyright@2024</p> <!-- Teks hak cipta di footer -->
    </footer>
</body>
</html>
