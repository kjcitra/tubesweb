<?php
session_start();
include 'db.php';

// Pembatasan akses: jika pengguna belum login, arahkan ke index.php
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit(); // Pastikan untuk keluar setelah redirect
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIZ STORE</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
    <style>
              /* Styling untuk halaman secara umum */
              body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Warna latar belakang untuk seluruh halaman */
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #dad1b6; /* Warna latar belakang untuk header */
            padding: 20px; /* Padding untuk header */
            text-align: center; /* Mengatur teks di tengah */
        }

/* Styling untuk login/signup di header */
.login-signup {
    position: absolute;
    right: 20px;
    top: 20px;
}

.login-signup a {
    margin-left: 10px;
    text-decoration: none;
    color: #000;
    padding: 10px 15px;
    border: 1px solid #b7b071;
    border-radius: 5px;
}

.login-signup a:hover {
    background-color: #c4bb8b;
}

/* Styling untuk navigasi */
nav ul {
    list-style-type: none; /* Menghilangkan bullet point dari daftar */
    padding: 0; /* Menghilangkan padding */
    margin: 0; /* Menghilangkan margin */
}

nav ul li {
    display: inline; /* Menampilkan item dalam satu baris */
    margin-right: 15px; /* Jarak antar item */
}

nav a {
    text-decoration: none; /* Menghilangkan garis bawah pada tautan */
    color: rgb(196, 163, 79); /* Warna tautan */
    transition: color 0.3s; /* Transisi warna saat hover */
}

nav a:hover {
    color: #c4bb8b; /* Warna saat hover */
}

/* Styling untuk konten utama */
.content {
    padding: 20px; /* Padding untuk konten */
    max-width: 800px; /* Lebar maksimum konten */
    margin: auto; /* Mengatur margin otomatis untuk tengah */
    background-color: white; /* Warna latar belakang untuk konten */
    border-radius: 5px; /* Sudut membulat */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Bayangan untuk efek kedalaman */
}

h2 {
    text-align: center; /* Mengatur judul di tengah */
    color: #a3993a; /* Warna judul */
}

p {
    line-height: 1.6; /* Jarak antar baris teks */
    margin: 10px 0; /* Margin atas dan bawah untuk paragraf */
}

/* Styling untuk footer */
footer {
    text-align: center; /* Mengatur teks footer di tengah */
    padding: 20px 0; /* Padding untuk footer */
    background-color: rgb(247, 227, 183); /* Warna latar belakang footer */
    color: #000; /* Warna teks footer */
    position: relative; /* Agar elemen footer bisa diposisikan relatif */
}

/* Styling untuk scroll container produk */
.scroll-container {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    gap: 10px;
    padding: 10px;
}

/* Styling untuk setiap produk dalam scroll container */
.product {
    flex: 0 0 auto;
    transition: transform 0.3s;
    text-align: center;
    background-color: #f9f9f9;
    padding: 10px;
    border-radius: 5px;
    scroll-snap-align: start;
    min-width: 250px;
}

.product img {
    width: 50%; /* Gambar akan mengisi seluruh lebar kontainer produk */
    height: auto; /* Menjaga rasio aspek gambar */
    object-fit: cover; /* Memastikan gambar memenuhi ruang tanpa mengubah rasio */
    border-radius: 8px; /* Membuat sudut gambar menjadi melengkung */
}

.product:hover {
    transform: scale(1.05); /* Efek pembesaran saat hover */
}

/* Styling untuk map container */
.map-container {
    width: 100%; /* Lebar peta 100% dari kontainer */
    height: 300px; /* Tinggi peta */
    margin-top: 20px; /* Jarak atas untuk peta */
}
</style>

<body>
    <header>
        <h1>REVEAL YOUR INNER BEAUTY WITH KOREAN FASHION</h1>
        <nav>
            <ul>
                <li><a href="index_user.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="user_dashboard.php">Produk</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="profil_user.php">Profil</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="login-signup">
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="pilihrole.html">Login</a>
                <a href="signup.php">Signup</a>
            <?php else: ?>
                <span>Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="logout.php">Logout</a>
            <?php endif; ?>
        </div>
    </header>

    <section class="product-container">
        <h3 style="background-color:rgb(222, 148, 87); padding: 15px; text-align: center; border-radius: 5px;">CICIRO WARDROBE</h3>
        <div class="scroll-container">
        <div class="product">
                <img src="images/DRESS8.jpg" alt="Dress 1">
            </div>
            <div class="product">
                <img src="images/DRESS9.jpg" alt="Dress 2">
            </div>
            <div class="product">
                <img src="images/DRESS10.jpg" alt="Dress 3">
            </div>
        </div>
    </section>

    <section class="product-container">
        <h3 style="background-color:rgb(222, 148, 87); padding: 15px; text-align: center; border-radius: 5px;">OUR DRESS</h3>
        <div class="scroll-container">
            <div class="product">
                <img src="images/DRESS6.JPG" alt="Dresss 2">
                <h3>offshulder dres</h3>
                <p>Harga: Rp. 520.000</p>
            </div>
            <div class="product">
                <img src="images/DRESS7.JPG" alt="Dress 3">
                <h3>white dress</h3>
                <p>Harga: Rp. 685.000</p>
            </div>
            <div class="product">
                <img src="images/DRESS2.JPG" alt="Dress 4">
                <h3>greem dress with transparan shoulders</h3>
                <p>Harga: Rp. 660.000</p>
            </div>
            <div class="product">
                <img src="images/DRESS3.JPG" alt="Dress 5">
                <h3>tie dye dress</h3>
                <p>Harga: Rp. 790.000</p>
            </div>
            <div class="product">
                <img src="images/DRESS5.JPG" alt="Dress 6">
                <h3>flower dress</h3>
                <p>Harga: Rp. 750.000</p>
            </div>
        </div>
    </section>


    <footer>
        <p>&copy; 2024 Ciciro Wardrobe</p>
    </footer>
</body>

</html>