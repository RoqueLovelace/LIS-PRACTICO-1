<?php
session_start();
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
  $username = $_SESSION['username'];
  $role = $_SESSION['role'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Textil Export</title>
  <link rel="stylesheet" href="./assets/css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
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
    <div class="my-3 d-flex <?php if($role=="admin") echo 'justify-content-between'; else{echo 'justify-content-end';}?> align-items-center mx-4">
      <?php if (isset($username) && $role =="admin"): ?>
        <a href="./views/new_product.php">
          <button type="button" class="btn btn-primary mx-5 shadow-sm">
            Agregar producto
          </button>
        </a>
      <?php endif; ?>
      <div>
        <div class="my-3 d-flex justify-content-between">
          <!-- Cuadro de búsqueda -->
          <form class="d-flex" role="search" method="GET" action="./controllers/search_results.php">
            <input class="form-control me-2" type="search" placeholder="Buscar producto..." aria-label="Search" name="query">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
          </form>
  
          <!-- Filtro de categoría -->
          <div class="d-flex">
            <select class="form-select me-2" aria-label="Categoría" name="category">
              <option value="">Selecciona categoría</option>
              <option value="Textil">Textil</option>
              <option value="Promocionales">Promocionales</option>
            </select>
            <button class="btn btn-outline-success" type="submit">Filtrar</button>
          </div>
        </div>
      </div>
    </div>

    <section id="Products" class="container my-5">
      <div class="row">
        <?php
        $products = simplexml_load_file('./data/productos.xml');

        foreach ($products->product as $product):
          $id = $product->id;
          $name = $product->name;
          $description = $product->description;
          $image_url = $product->image_url;
          $category = $product->category;
          $price = $product->price;
          $stock = $product->stock;
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
              <div class="card-footer bg-transparent d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-ver-mas" data-bs-toggle="modal" data-bs-target="#VerMas<?= $id ?>">
                  Ver más
                </button>
                <?php include './controllers/edit_product.php'; ?>
              </div>
            </div>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>