<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
  $username = $_SESSION['username'];
  $role = $_SESSION['role'];
}

if (isset($_POST['query'])) {
  $search = $_POST['query'] ?? '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Textil Export</title>
  <link rel="stylesheet" href="./assets/css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- JavaScript -->
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
  <!-- CSS -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
  <!-- Bootstrap theme -->
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css" />
</head>

<body>
  <!-- Cabecera -->
  <header>

    <div class="container">

    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
      <div class="container">
        <h1 id="CompanyName" class="text-center my-3">Textil Export</h1>
        <ul class="navbar-nav ml-auto align-items-center gap-4">
          <li class="nav-item">
            <a class="nav-link text-white" href="./">Inicio</a>
          </li>
          <li class="nav-item">
            <?php if (isset($username)): ?>
              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                  <?= $username ?>
                </button>
                <ul class="dropdown-menu" aria-labelledby="userMenu">
                  <li><a class="dropdown-item" href="./views/profile.php">Perfil</a></li>
                  <li><a class="dropdown-item" href="./controllers/logout.php">Cerrar sesión</a></li>
                </ul>
              </div>
            <?php else: ?>
              <a class="btn btn-outline-light" href="./views/login.php">Iniciar sesión</a>
            <?php endif; ?>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- Contenido principal -->
  <main>
    <div class="my-3 d-flex <?php if ($role == "admin") echo 'justify-content-between';
                            else {
                              echo 'justify-content-end';
                            } ?> align-items-center mx-4">
      <?php if (isset($username) && $role == "admin"): ?>
        <a href="./views/new_product.php">
          <button type="button" class="btn btn-primary mx-5 shadow-sm">
            Agregar producto
          </button>
        </a>
      <?php endif; ?>
      <div>
        <div class="my-3 d-flex justify-content-between">
          <!-- Cuadro de búsqueda -->
          <form class="d-flex" role="search" method="POST">
            <input class="form-control me-2" type="search" placeholder="Buscar producto..." aria-label="Search" name="query">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
          </form>          
        </div>
      </div>
    </div>

    <section id="Products" class="container my-5">
      <div class="row">
        <?php
        $products = simplexml_load_file('./data/productos.xml');

        foreach ($products->product as $product):
          $name = (string) $product->name;
          $id = (string) $product->id;
          $description = (string) $product->description;
          $image_url = (string) $product->image_url;
          $category = (string) $product->category;
          $price = (float) $product->price;
          $stock = (int) $product->stock;

          // Aplicar búsqueda si hay un término ingresado
          if (!empty($search) && !str_contains(strtolower($name), strtolower($search))) {
            continue; // Saltar a la siguiente iteración si no hay coincidencia
          }
        ?>
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-lg rounded-3">
              <img src="<?= $image_url ?>" alt="<?= $name ?>" class="card-img-top img-fluid w-auto" style="height: 200px; object-fit: contain;">
              <div class="card-body">
                <h5 class="card-title text-center"><?= $name ?></h5>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><strong>Categoría:</strong> <?= $category ?></li>
                  <li class="list-group-item"><strong>Precio:</strong> $<?= $price ?></li>
                </ul>
              </div>
              <div class="card-footer bg-transparent d-flex flex-column gap-3">
                <div class="text-center">
                  <button type="button" class="btn btn-ver-mas" data-bs-toggle="modal" data-bs-target="#VerMas<?= $id ?>">
                    Ver más
                  </button>
                </div>

                <div class="d-flex justify-content-between">
                  <?php

                  if (isset($username) && isset($role) && $role == "admin") {
                  ?>
                    <button type="button" class="btn btn-warning text-white w-auto fw-bold" data-bs-toggle="modal"
                      data-bs-target="#Editar<?= $id ?>">
                      Editar
                    </button>
                  <?php } ?>
                  <?php if (isset($role)) {

                    if ($role === 'admin') {

                  ?>
                      <a href="" class="h-100">
                        <form method="POST" class="h-100" action="./controllers/delete_product.php">
                          <input type="hidden" name="product_id" value="<?= $product->id ?>">
                          <button type="submit" name="delete_product" class="btn btn-danger h-100">
                            Eliminar
                          </button>
                        </form>
                      </a>

                    <?php
                    }
                    ?>

                    <a href="" class="h-100">
                      <form method="POST" class="h-100" action="./controllers/favorites.php">
                        <input type="hidden" name="product_id" value="<?= $product->id ?>">
                        <button type="submit" name="add_favorite" class="btn btn-danger h-100">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                          </svg>
                        </button>
                      </form>
                    </a>
                  <?php } ?>
                </div>
              </div>
            </div>
            <?php include './controllers/edit_product.php'; ?>
          </div>

          <!-- Modal de ver más -->
          <div class="modal fade" id="VerMas<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"><?= $name ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p><?= $description ?></p>
                  <?php if ($stock > 0): ?>
                    <h3><strong>Stock:</strong> <?= $stock ?></h3>
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

        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-dark py-4">
    <div class="container text-center text-white">
      <p class="mb-0">Textil Export &copy; 2025</p>
    </div>
  </footer>

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

  <script src="assets/js/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>