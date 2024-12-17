<?php
session_start();

$servername = "localhost";  
$username = "root";         
$password = "";             
$dbname = "ecommerce_db";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangani form submit untuk menambahkan data dress
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_dress = $_POST['nama_dress'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $foto = $_FILES['foto'];

    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($foto['type'], $allowed_types)) {
        die("Format file tidak valid. Harap unggah file gambar (JPG, PNG, GIF).");
    }

    $upload_dir = 'images/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $foto_name = $upload_dir . basename($foto['name']);
    if (move_uploaded_file($foto['tmp_name'], $foto_name)) {
        $sql = "INSERT INTO dress (nama_dress, deskripsi, harga, foto) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $nama_dress, $deskripsi, $harga, $foto_name);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Data berhasil ditambahkan.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        die("Gagal mengunggah file. Pastikan folder 'images/' memiliki izin yang cukup.");
    }
}

if (isset($_GET['id_dress'])) {
    $id_dress = $_GET['id_dress'];

    $sql = "SELECT foto FROM dress WHERE id_dress = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_dress);
    $stmt->execute();
    $stmt->bind_result($foto);
    $stmt->fetch();
    $stmt->close();

    $sql = "DELETE FROM dress WHERE id_dress = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_dress);
    if ($stmt->execute()) {
        if ($foto && file_exists($foto)) {
            unlink($foto);
        }
        $_SESSION['message'] = "Data berhasil dihapus.";
        $stmt->close();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error menghapus data: " . $stmt->error;
    }
    $stmt->close();
}

$sql = "SELECT * FROM dress";
$result_dress = $conn->query($sql);

echo "<style>
        body {
            background-color: #f8f4e6;
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
            color: #4b2e2e;
        }
        form {
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form input, form textarea, form button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        form button {
            background-color: #5bc0de;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            opacity: 0.8;
        }
        .table-container {
            padding: 20px;
        }
        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background-color: #fff;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }
        th {
            background-color: #d1c4a9;
        }
      </style>";

if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']);
}

echo "<h1>Form Input/Edit Data Dress</h1>";
echo "<form action='' method='POST' enctype='multipart/form-data'>
        <input type='hidden' name='id_dress' value='" . ($_GET['edit_id'] ?? '') . "'>
        <label for='nama_dress'>Nama Dress</label>
        <input type='text' name='nama_dress' id='nama_dress' value='" . ($_GET['edit_nama'] ?? '') . "' required>
        <label for='deskripsi'>Deskripsi</label>
        <textarea name='deskripsi' id='deskripsi' rows='4' required>" . ($_GET['edit_deskripsi'] ?? '') . "</textarea>
        <label for='harga'>Harga</label>
        <input type='number' step='0.01' name='harga' id='harga' value='" . ($_GET['edit_harga'] ?? '') . "' required>
        <label for='foto'>Foto</label>
        <input type='file' name='foto' id='foto'>
        <button type='submit' name='" . (isset($_GET['edit_id']) ? "edit" : "add") . "'>" . (isset($_GET['edit_id']) ? "Edit Data" : "Tambah Data") . "</button>
      </form>";

echo "<h1>Daftar Dress</h1>";

echo "<div class='table-container'>";
if ($result_dress->num_rows > 0) {
    echo "<table>
            <tr>
                <th>ID Dress</th>
                <th>Nama Dress</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>";

    while ($row = $result_dress->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["id_dress"]) . "</td>
                <td>" . htmlspecialchars($row["nama_dress"]) . "</td>
                <td>" . htmlspecialchars($row["deskripsi"]) . "</td>
                <td>Rp " . number_format($row["harga"], 2, ',', '.') . "</td>
                <td><img src='" . htmlspecialchars($row["foto"]) . "' alt='Foto Dress' width='100'></td>
                <td>
                    <a href='?edit_id=" . $row["id_dress"] . "&edit_nama=" . $row["nama_dress"] . "&edit_deskripsi=" . $row["deskripsi"] . "&edit_harga=" . $row["harga"] . "'>
                        <button>Edit</button>
                    </a>
                    <a href='?delete_id=" . $row["id_dress"] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus?\");'>
                        <button>Hapus</button>
                    </a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align: center;'>Belum ada data dress.</p>";
}

echo "</div>";

$conn->close();
?>