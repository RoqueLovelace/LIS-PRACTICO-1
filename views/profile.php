<?php
include_once '../controllers/favorites.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}


$username = $_SESSION['username'];
$email = $_SESSION['email'];

$favorites = simplexml_load_file('../data/favoritos.xml');

$userFavorites = getFavorites($username);

$products = simplexml_load_file('../data/productos.xml');
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Productos Favoritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css" />
</head>

<body class="bg-light">
    <header>

        <div class="container">

        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <div class="container">
                <h1 id="CompanyName" class="text-center my-3">Textil Export</h1>
                <ul class="navbar-nav ml-auto align-items-center gap-4">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($username)): ?>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= $username ?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="userMenu">
                                    <li><a class="dropdown-item" href="./profile.php">Perfil</a></li>
                                    <li><a class="dropdown-item" href="../controllers/logout.php">Cerrar sesión</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <a class="btn btn-outline-light" href="./login.php">Iniciar sesión</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="container dashboard-container my-5">
        <p class="text-center">Bienvenido, <strong><?= $username ?></strong> (<?= $email ?>)</p>
        <h2 class="text-center mb-4">Mis Productos Favoritos</h2>
        <div class="row">
            <?php if (empty($userFavorites)) : ?>
                <div class="col-md-6 offset-md-3">
                    <div class="empty-card">
                        <h5>No tienes productos favoritos.</h5>
                        <p>Explora nuestra tienda y añade productos a tu lista de favoritos.</p>
                        <a href="../" class="btn btn-primary">Ir a la tienda</a>
                    </div>
                </div>
            <?php else : ?>
                <?php foreach ($userFavorites as $productId) : ?>
                    <?php foreach ($products->product as $product) : ?>
                        <?php if ((string) $product->id === (string) $productId) : ?>
                            <div class="col-md-4">
                                <div class="product-card">
                                    <img src="<?= $product->image_url ?>" alt="<?= $product->name ?>">
                                    <h5><?= $product->name ?></h5>
                                    <p><strong>Precio:</strong> $<?= $product->price ?></p>
                                    <p><strong>Categoría:</strong> <?= $product->category ?></p>
                                    <a class="btn btn-ver-mas" data-bs-toggle="modal" data-bs-target="#VerMas<?= $product->id ?>">
                                        Ver más
                                    </a>
                                    <!-- Botón para abrir el modal -->
                                    <a class="btn btn-danger h-100" data-bs-toggle="modal" data-bs-target="#eliminar<?= $product->id ?>">
                                        Eliminar
                                    </a>

                                    <!-- Modal de confirmación -->
                                    <div class="modal fade" id="eliminar<?= $product->id ?>" tabindex="-1" aria-labelledby="modalLabel<?= $product->id ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalLabel<?= $product->id ?>">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que deseas eliminar este producto de tus favoritos?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="../controllers/favorites.php" method="POST">
                                                        <input type="hidden" name="delete_favorite">
                                                        <input type="hidden" readonly name="product_id" value="<?= $product->id ?>">
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Modal de ver más -->
                            <div class="modal fade" id="VerMas<?= $product->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><?= $product->name ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><?= $product->description ?></p>
                                            <?php if ($product->stock > 0): ?>
                                                <h3><strong>Stock:</strong> <?= $product->stock ?></h3>
                                            <?php else: ?>
                                                <h3 class="alert alert-danger"><strong>Producto no disponible, pronto traeremos más de esto.</strong></h3>
                                            <?php endif; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php break;
                        endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php

    if (isset($_SESSION['message'])) {

        $message = $_SESSION['message'];
    ?>
        <script>
            alertify.success("<?= $message; ?>");
        </script>

    <?php
        unset($_SESSION['message']);
    } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>