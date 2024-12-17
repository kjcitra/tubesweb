<?php
session_start(); // Memulai sesi untuk mengakses variabel sesi
include 'db.php'; // Menghubungkan ke database

// Cek apakah pengguna telah login dan memiliki role 'admin'
$isAdmin = isset($_SESSION['username']) && $_SESSION['role'] === 'admin';

// Ambil data tentang dari database
$aboutContent = "Selamat datang di Hijab Store! Kami adalah toko yang didedikasikan untuk menyediakan berbagai jenis hijab dengan kualitas terbaik dan harga terjangkau. Kami percaya bahwa setiap wanita berhak untuk tampil anggun dan percaya diri.";

// Cek apakah form telah disubmit dan jika pengguna adalah admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isAdmin) {
    // Simpan perubahan konten
    $aboutContent = $_POST['about_content'];
    // Di sini, Anda dapat menambahkan kode untuk menyimpan konten ke database
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Ciciro Wardrobe</title>
    <link rel="stylesheet" href="css/index.css"> <!-- Link ke file CSS -->
    <style>
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

        nav ul {
            list-style-type: none; /* Menghilangkan bullet point */
            padding: 0; /* Menghilangkan padding */
            margin: 0; /* Menghilangkan margin */
        }

        nav ul li {
            display: inline; /* Menampilkan item dalam satu baris */
            margin-right: 15px; /* Jarak antar item */
        }

        nav a {
            text-decoration: none; /* Menghilangkan garis bawah */
            color: #b7b071; /* Warna tautan */
            transition: color 0.3s; /* Transisi warna saat hover */
        }

        nav a:hover {
            color: rgb(200, 161, 89); /* Warna saat hover */
        }

        .content {
            padding: 20px;
            max-width: 800px;
            margin: auto;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #a3993a;
        }

        p {
            line-height: 1.6;
            margin: 10px 0;
        }

        footer {
            text-align: center;
            padding: 20px 0;
            background-color: rgb(223, 200, 130);
            color: #000;
        }

        .map-container {
            width: 100%;
            height: 300px;
            margin-top: 20px;
        }

        .edit-form {
            margin-top: 20px;
            padding: 10px;
            background-color: rgb(221, 181, 99);
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .edit-form textarea {
            width: 100%;
            height: 150px;
            margin-bottom: 10px;
        }

        .edit-form button {
            background-color: #b7b071;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-form button:hover {
            background-color: #c4bb8b;
        }
    </style>
</head>

<body>
    <header>
        <h1>Ciciro Wardrobe</h1>
        <nav>
            <ul>
                <li><a href="indexadmin.php">Home</a></li>
                <li><a href="admin_dashboard.php">Detail</a></li>
            </ul>
        </nav>
    </header>

    <div class="content">
        <h2>Tentang Kami</h2> <!-- Judul bagian tentang kami -->
        <p>Selamat datang di Ciciro Store! Kami adalah toko yang didedikasikan untuk menyediakan berbagai jenis dress Korean style dengan kualitas terbaik dan harga terjangkau. Kami percaya bahwa setiap wanita berhak untuk tampil anggun dan percaya diri dengan sentuhan gaya Korea.</p>
        <p>Di Ciciro Store, kami berkomitmen untuk menghadirkan koleksi yang beragam, mulai dari dress kasual, elegan, hingga pesta yang dapat melengkapi penampilan Anda. 
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            Kami selalu memperhatikan tren terbaru dan kebutuhan pelanggan kami. <!-- Informasi tambahan yang hanya ditampilkan jika pengguna login -->
        <?php endif; ?>
        </p>
        <p>Visi kami adalah menjadi toko dress Korean style terkemuka yang menawarkan produk berkualitas dan layanan pelanggan yang luar biasa. Kami berusaha keras untuk memastikan bahwa setiap pengalaman berbelanja Anda bersama kami menyenangkan dan memuaskan.</p>
        <p>Terima kasih telah memilih Ciciro Store. Kami berharap Anda menemukan produk yang Anda sukai!</p>
    </div>
    
    <footer>
        <h3>Hubungi Kami</h3> <!-- Judul bagian kontak -->
        <p><strong>Email:</strong> contact@cicirostore.com</p> <!-- Informasi email -->
        <p><strong>Lokasi:</strong> jdl.sudirman</p> <!-- Alamat lokasi -->
        <p><strong>Jam Operasional :</strong> 10.00 - 20.00 </p> <!-- Jam buka toko -->
        <div class="map-container">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31725.11679827603!2d110.39940116467126!3d-7.318394393344393!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e70f77dcb2b6155%3A0x57c7edbd3c7c4a99!2sBtn%20Gowa%20Sarana%20Indah!5e0!3m2!1sid!2sid!4v1697093047080!5m2!1sid!2sid"
                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe> <!-- Peta lokasi menggunakan Google Maps -->
        </div>
        <p>&copy; 2024 Ciciro Store</p> <!-- Copyright -->
    </footer>
    </body>
    
    </html>
    