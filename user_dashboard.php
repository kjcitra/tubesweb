<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Hijab Store</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(209, 162, 81);
        }
        
        header {
            background-color: #e7e2b1;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        
        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        
        nav ul li {
            display: inline;
            margin-right: 15px;
        }
        
        nav a {
            text-decoration: none;
            color: white;
            transition: color 0.3s;
        }
        
        nav a:hover {
            color: #f7f7f7;
        }
        
        .container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        
        .product {
            display: flex;
            margin-bottom: 20px;
            background: white;
            border-radius: 5px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .product img {
            width: 150px;
            height: auto;
            margin-right: 20px;
        }
        
        .product-info {
            max-width: 400px;
        }
        
        button {
            padding: 10px 15px;
            background-color:rgb(174, 174, 81);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #e7e193;
        }
        
        .action-buttons {
            margin-top: 10px;
        }
        
        .action-buttons button {
            margin-right: 10px;
        }
        
        footer {
            text-align: center;
            padding: 20px 0;
            color:rgb(13, 12, 8);
        }
    </style>
    <script>
        function addToCart(productName) {
            alert(productName + " telah ditambahkan ke keranjang!");
            // Tambahkan logika untuk menyimpan produk ke keranjang di backend
        }

        function likeProduct(productName) {
            alert("Anda menyukai " + productName + "!");
            // Tambahkan logika untuk menyimpan status like di backend
        }

        function reviewProduct(productName) {
            const review = prompt("Masukkan ulasan untuk " + productName + ":");
            if (review) {
                alert("Terima kasih atas ulasan Anda untuk " + productName + "!");
                // Tambahkan logika untuk menyimpan ulasan di backend
            }
        }
    </script>
</head>

<body>
    <header>
        <h1>CICIRO WARDROBE</h1>
        <nav>
            <ul>
                <li><a href="index_user.php">Home</a></li>
                <li><a href="about.html">About</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <h2>Ciciro Produk</h2>
        <?php
        // Contoh data produk, bisa diambil dari database
        $products = [
            [
                'name' => 'BLACK DRESS',
                'description' => 'Black dress with elegant look',
                'price' => 'Rp 780.000',
                'image' => 'images/black dress elegant.jpg',
            ],
            [
                'name' => 'PINK DRESS',
                'description' => 'Pinky dress with ribbon for cutie girl',
                'price' => 'Rp 870.000',
                'image' => 'images/pinky dress with ribbon.jpg',
            ],
            [
                'name' => 'ZEBRA DRESS',
                'description' => 'Zebra dress off shoulders',
                'price' => 'Rp 600.000',
                'image' => 'images/zebra dress.jpg',
            ],
            [
               'name' => 'WHITE DRESS',
        'description' => 'white dress for elegant look',
        'price' => 'Rp 450.000',
        'image' => 'images/white dress simple.jpg',
            ],
            [
                'name' => 'GREY RIBBON DRESS',
                'description' => 'Grey dress with ribbon makes u look perfect',
                'price' => 'Rp 990.000',
                'image' => 'images/grey ribbon dress.jpg',
            ],
            [
                'name' => 'GREEN DRESS',
        'description' => 'Cutie green dress makes u look cute!',
        'price' => 'Rp 820.000',
        'image' => 'images/cutie green dress.jpg',
            ],
            [
                'name' => 'BLUE DRESS',
        'description' => 'This blue dress just WOW',
        'price' => 'Rp 575.000',
        'image' => 'images/blue dress.jpg',
            ],
            [
                'name' => 'JEANS DRESS',
                'description' => 'Idol fav. chaewon, winter, ahyeon was wearing this dress',
                'price' => 'Rp 1.050.000',
                'image' => 'images/idol fav.jpg',
            ],
            [
                'name' => 'RED DRESS',
        'description' => 'Red dress makes u look hottie',
        'price' => 'Rp 940.000',
        'image' => 'images/red ribbon dress.jpg',
            ],
          
        ];

        foreach ($products as $product) {
            echo '<div class="product">';
            echo '<img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '">';
            echo '<div class="product-info">';
            echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
            echo '<p>' . htmlspecialchars($product['description']) . '</p>';
            echo '<p><strong>Harga:</strong> ' . htmlspecialchars($product['price']) . '</p>';
            echo '<button onclick="addToCart(\'' . htmlspecialchars($product['name']) . '\')">Tambah ke Keranjang</button>';
            echo '<div class="action-buttons">';
            echo '<button onclick="likeProduct(\'' . htmlspecialchars($product['name']) . '\')">Like</button>';
            echo '<button onclick="reviewProduct(\'' . htmlspecialchars($product['name']) . '\')">Review</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Ciciro Wardrobe</p>
    </footer>
</body>

</html>