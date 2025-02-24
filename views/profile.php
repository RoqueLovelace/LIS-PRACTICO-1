<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$favorites = simplexml_load_file('../data/favorites.xml');

$userFavorites = [];
foreach ($favorites->favorite as $favorite) {
    if ((string) $favorite->username === (string) $username) {
        $userFavorites = $favorite->productId;
        break;
    }
}

if (empty($userFavorites)) {
    echo "<p>No tienes productos favoritos.</p>";
    exit();
}

$products = simplexml_load_file('../data/productos.xml');

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Productos Favoritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
        }

        .product-card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product-card h5 {
            margin-top: 10px;
        }

        .product-card p {
            color: #555;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container my-5">
        <h2 class="text-center mb-4">Mis Productos Favoritos</h2>
        <div class="row">
            <?php
            foreach ($userFavorites as $productId) {
                // Buscar el producto correspondiente en el XML de productos
                foreach ($products->product as $product) {
                    if ((string) $product->id === (string) $productId) {
                        // Mostrar el producto
                        ?>
                        <div class="col-md-4">
                            <div class="product-card">
                                <img src="<?= $product->image_url ?>" alt="<?= $product->name ?>">
                                <h5 class="text-center"><?= $product->name ?></h5>
                                <p class="text-center"><strong>Precio:</strong> $<?= $product->price ?></p>
                                <p class="text-center"><strong>Categoría:</strong> <?= $product->category ?></p>
                                <a href="#" class="btn btn-primary btn-block">Ver más</a>
                            </div>
                        </div>
                        <?php
                        break; // Salir del ciclo cuando se encuentra el producto
                    }
                }
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
