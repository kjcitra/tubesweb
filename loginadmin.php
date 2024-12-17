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
            $host = 'localhost'; // Host database
            $dbuser = "root";  // Username database
            $dbpass = "";      // Password database
            $dbname = "ecommerce_db"; // Nama database
           // Ganti dengan nama database Anda
           try {
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (isset($_COOKIE['username'])) {
                $_SESSION['username'] = $_COOKIE['username'];
                header('location: indexadmin.php');
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = $_POST['username'];
                $password = $_POST['password'];
                $remember = isset($_POST['remember']);

                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
                $stmt->execute(['username' => $username]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    if ($password === $user['password']) {
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['role'] = $user['role'];

                        // Cek apakah user adalah admin
                        if ($_SESSION['role'] !== 'admin') {
                            echo "<p class='error-message'>Anda tidak memiliki akses sebagai admin!</p>";
                        } else {
                            if ($remember) {
                                setcookie('username', $username, time() + (86400 * 30), "/");
                            }
                            header('location: indexadmin.php');
                            exit;
                        }
                    } else {
                        echo "<p class='error-message'>Password salah!</p>";
                    }
                } else {
                    echo "<p class='error-message'>Username tidak terdaftar!</p>";
                }
            }
        } catch (PDOException $e) {
            echo "<p class='error-message'>Gagal terhubung ke database: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" placeholder="Masukkan username Anda" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Masukkan password Anda" required>
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
            <button type="submit">Login</button>
        </form>
    </div>
</main>
<footer>
    <p>2024 Trendy Wardrobe. All Rights Reserved.</p> 
</footer>
</body>
</html>
