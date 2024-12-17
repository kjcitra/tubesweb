<?php
// Konfigurasi koneksi database
$servername = "localhost";  // Nama server database
$username = "root";         // Username MySQL
$password = "";             // Password MySQL
$dbname = "ecommerce_db";   // Nama database

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error); // Jika koneksi gagal, tampilkan pesan error
}

// Menangani pengambilan data untuk diedit
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id']; // Ambil ID dress yang akan diedit
    $sql = "SELECT * FROM dress WHERE id_dress = ?"; // Query untuk mendapatkan data dress berdasarkan ID
    $stmt = $conn->prepare($sql); // Menyiapkan statement
    $stmt->bind_param("i", $edit_id); // Mengikat parameter
    $stmt->execute(); // Menjalankan statement
    $result_edit = $stmt->get_result(); // Mendapatkan hasil
    $edit_dress = $result_edit->fetch_assoc(); // Mengambil data sebagai array asosiatif
    $stmt->close(); // Menutup statement
}

// Menangani pembaruan data
if (isset($_POST['edit'])) {
    $id_dress = $_POST['id_dress']; // Ambil ID dress dari form
    $nama_dress = $_POST['nama_dress'] ?? null; // Ambil nama dress, jika tidak ada nilai, set null
    $deskripsi = $_POST['deskripsi'] ?? null; // Ambil deskripsi, jika tidak ada nilai, set null
    $harga = $_POST['harga'] ?? null; // Ambil harga, jika tidak ada nilai, set null

    // Mengelola upload file foto
    $uploadOk = true; // Status upload, awalnya diatur ke true
    $target_file = null; // Untuk menyimpan path file yang diupload

    // Cek apakah ada file yang diupload
    if (isset($_FILES['foto']) && $_FILES['foto']['name']) {
        $foto = $_FILES['foto']['name']; // Ambil nama file foto
        $target_dir = "uploads/"; // Folder tujuan untuk menyimpan foto
        $target_file = $target_dir . basename($foto); // Path lengkap untuk file yang diupload
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Mendapatkan tipe file

        // Cek apakah file gambar sebenarnya
        $check = getimagesize($_FILES['foto']['tmp_name']);
        if ($check === false) {
            echo "File bukan gambar."; // Jika bukan gambar, tampilkan pesan error
            $uploadOk = false; // Set status upload ke false (gagal)
        }

        // Cek ukuran file
        if ($_FILES['foto']['size'] > 500000) { // 500KB
            echo "Maaf, file terlalu besar."; // Jika ukuran file terlalu besar, tampilkan pesan error
            $uploadOk = false; // Set status upload ke false (gagal)
        }

        // Izinkan format file tertentu
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan."; // Validasi format file
            $uploadOk = false; // Set status upload ke false (gagal)
        }

        // Cek apakah $uploadOk diatur ke false oleh kesalahan
        if ($uploadOk) {
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) { // Mengupload file
                echo "File " . htmlspecialchars(basename($foto)) . " berhasil diupload."; // Tampilkan pesan sukses
            } else {
                echo "Maaf, terjadi kesalahan saat mengupload file."; // Tampilkan pesan error saat upload gagal
            }
        }
    }

    // Update data dalam database, hanya jika ada nilai yang diubah
    $sql = "UPDATE dress SET "; // Query untuk memperbarui data
    $params = []; // Array untuk menyimpan parameter
    $set_parts = []; // Array untuk menyimpan bagian dari query set

    // Menambahkan nama dress ke query jika ada
    if ($nama_dress !== null) {
        $set_parts[] = "nama_dress = ?"; // Menambahkan bagian untuk nama dress
        $params[] = $nama_dress; // Menambahkan nilai ke parameter
    }
    // Menambahkan deskripsi ke query jika ada
    if ($deskripsi !== null) {
        $set_parts[] = "deskripsi = ?"; // Menambahkan bagian untuk deskripsi
        $params[] = $deskripsi; // Menambahkan nilai ke parameter
    }
    // Menambahkan harga ke query jika ada
    if ($harga !== null) {
        $set_parts[] = "harga = ?"; // Menambahkan bagian untuk harga
        $params[] = $harga; // Menambahkan nilai ke parameter
    }
    // Menambahkan foto ke query jika ada
    if ($target_file) {
        $set_parts[] = "foto = ?"; // Menambahkan bagian untuk foto
        $params[] = $target_file; // Menambahkan nilai ke parameter
    }

    // Jika ada data yang diubah
    if (count($set_parts) > 0) {
        $sql .= implode(", ", $set_parts) . " WHERE id_dress = ?"; // Menyusun query akhir
        $params[] = $id_dress; // Menambahkan ID dress ke parameter

        $stmt = $conn->prepare($sql); // Menyiapkan statement
        // Bind parameters dynamically
        $types = str_repeat('s', count($params) - 1) . 'i'; // Tipe data untuk binding
        $stmt->bind_param($types, ...$params); // Mengikat parameter

        if ($stmt->execute()) { // Eksekusi statement
            echo "Data berhasil diupdate."; // Tampilkan pesan sukses
            // Redirect ke halaman daftar produk
            header("Location: admin_dashboard.php"); // Ganti dengan nama file daftar Anda
            exit(); // Menghentikan eksekusi skrip
        } else {
            echo "Error: " . $stmt->error; // Tampilkan error jika query gagal
        }
        $stmt->close(); // Menutup statement
    } else {
        echo "Tidak ada data yang diubah."; // Jika tidak ada perubahan, tampilkan pesan
    }
}

// Menampilkan halaman
echo "<link rel='stylesheet' type='text/css' href='css/edit.css'>"; // Menyertakan file CSS untuk styling

echo "<div class='container'>"; // Membuka kontainer untuk form
echo "<h1>FORM EDIT PRODUK</h1>"; // Judul halaman

// Jika ada data dress untuk diedit
if (isset($edit_dress)) {
    echo "<form action='' method='POST' enctype='multipart/form-data'> <!-- Form untuk edit produk -->
            <input type='hidden' name='id_dress' value='" . $edit_dress['id_dress'] . "'> <!-- Menyimpan ID dress -->
            <label for='nama_dress'>Nama Dress:</label>
            <input type='text' name='nama_dress' placeholder='Masukkan Nama Dress' value='" . htmlspecialchars($edit_dress['nama_dress']) . "'> <!-- Input untuk nama dress -->
        
            <label for='deskripsi'>Deskripsi:</label>
            <textarea name='deskripsi' placeholder='Masukkan Deskripsi Dress'>" . htmlspecialchars($edit_dress['deskripsi']) . "</textarea> <!-- Textarea untuk deskripsi dress -->
        
            <label for='harga'>Harga:</label>
            <input type='number' name='harga' placeholder='Masukkan Harga Dress' value='" . htmlspecialchars($edit_dress['harga']) . "'> <!-- Input untuk harga dress -->
        
            <label for='foto'>Foto:</label>
            <input type='file' name='foto'> <!-- Input untuk mengupload foto dress -->
        
            <button type='submit' name='edit'>Update Data</button> <!-- Tombol untuk submit form -->
          </form>";
}

echo "</div>"; // Tutup div container

$conn->close(); // Menutup koneksi database
?>
