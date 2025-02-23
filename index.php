<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Textil Export</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css" />
</head>

<body>
  <header>
    <div class="container">
      <h1 id="CompanyName" class="text-center my-3">Textil Export</h1>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="./">Home</a>
            <?php
            if (isset($_COOKIE['session']) && $_COOKIE['session'] == '1') { // falta agregar logica de cerrar sesion
              ?>
              <button class="nav-link">Cerrar sesión</button>
              <?php
            } else {

              ?>
              <button class="nav-link" data-bs-toggle="modal" data-bs-target="#IniciarSesion">Iniciar sesión</button>

              <?php
            }
            ?>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <main>
    <?php include_once('Iniciar_Sesion_Modal.php');
    if (isset($_COOKIE['session']) && $_COOKIE['session'] == '1') {
      ?>
      <button type="button" class="btn btn-primary mx-5" data-bs-toggle="modal" data-bs-target="#Agregar_Producto">
        Agregar producto
      </button>
    <?php } ?>
    <section id="Products" class="container my-5">
      <div class="row">
        <?php
        $productos = simplexml_load_file('productos.xml');

        foreach ($productos->producto as $producto) {
          $codigo = $producto->codigo;
          $nombre = $producto->nombre;
          $descripcionCorta = $producto->descripcionCorta;
          $descripcion = $producto->descripcion;
          $imagen = $producto->imagen;
          $categoria = $producto->categoria;
          $precio = $producto->precio;
          $existencias = $producto->existencias;
          ?>
          <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm p-2">
              <img src="<?= $imagen ?>" alt="<?= $nombre ?>" class="card-img-top"
                style="height: 200px; object-fit: cover;">
              <div class="card-body">
                <h5 class="card-title"><?= $nombre ?></h5>
                <p class="card-text"><?= $descripcionCorta ?></p>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><strong>Categoría:</strong> <?= $categoria ?></li>
                  <li class="list-group-item"><strong>Precio:</strong> $<?= $precio ?></li>
                </ul>
              </div>
              <div class="card-footer bg-transparent">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                  data-bs-target="#VerMas<?= $codigo ?>">
                  Ver más
                </button>

                <?php include_once('Iniciar_Sesion_Modal.php');
                if (isset($_COOKIE['session']) && $_COOKIE['session'] == '1') {
                  ?>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#Editar<?= $codigo ?>">
                    Editar
                  </button>

                  <!-- MODAL PARA EDITAR PRODUCTO -->
                  <div class="modal fade" id="Editar<?= $codigo ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Editar producto</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form method="POST" action="Agregar_Producto.php">
                            <div data-mdb-input-init class="form-outline mb-4">
                              <input id="codigo" name="codigo" class="form-control" value="<?= $codigo ?>" disabled />
                              <label class="form-label" for="codigo">Código de producto</label>
                            </div>
                            <div data-mdb-input-init class="form-outline mb-4">
                              <input id="nombre" name="nombre" class="form-control" value="<?= $nombre ?>" />
                              <label class="form-label" for="nombre">Nombre del producto</label>
                            </div>
                            <div data-mdb-input-init class="form-outline mb-4">
                              <input id="descripcionCorta" name="descripcionCorta" class="form-control"
                                value="<?= $descripcionCorta ?>" />
                              <label class="form-label" for="descripcionCorta">Descripción corta del producto</label>
                            </div>
                            <div data-mdb-input-init class="form-outline mb-4">
                              <input id="descripcion" name="descripcion" class="form-control" value="<?= $descripcion ?>" />
                              <label class="form-label" for="descripcion">Descripción del producto</label>
                            </div>
                            <div data-mdb-input-init class="form-outline mb-4">
                              <input id="imagen" name="imagen" class="form-control" value="<?= $imagen ?>" />
                              <label class="form-label" for="imagen">Imagen del producto</label>
                            </div>
                            <div data-mdb-input-init class="form-outline mb-4">
                              <input id="categoria" name="categoria" class="form-control" value="<?= $categoria ?>" />
                              <label class="form-label" for="categoria">Categoría del producto</label>
                            </div>
                            <div data-mdb-input-init class="form-outline mb-4">
                              <input id="existencias" name="existencias" class="form-control" value="<?= $existencias ?>" />
                              <label class="form-label" for="existencias">Número de existencias del producto</label>
                            </div>
                            <div data-mdb-input-init class="form-outline mb-4">
                              <input id="precio" name="precio" class="form-control" value="<?= $precio ?>" />
                              <label class="form-label" for="precio">Precio del producto</label>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar cambios</button>

                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- FIN MODAL PARA EDITAR PRODUCTO -->


                <?php } ?>
              </div>
            </div>
          </div>

          <!-- Para ver mas de cada producto -->
          <div class="modal fade" id="VerMas<?= $codigo ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"><?= $nombre ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p><?= $descripcion ?></p>
                  <?php if ($existencias > 0): ?>
                    <h3><strong>Existencias:</strong> <?= $existencias ?></h3>
                  <?php else: ?>
                    <h3 class="alert alert-danger"><strong>Producto no disponible, pronto traeremos mas de esto</strong>
                    </h3>
                  <?php endif; ?>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </section>
  </main>

  <footer class="bg-light py-4">
    <div class="container text-center">
      <p class="mb-0">Textil Export &copy; 2023</p>
    </div>
  </footer>

  <?php
  session_start();
  include_once('Iniciar_Sesion_Modal.php');
  include_once('Agregar_Producto_Modal.php');
  include_once('Agregar_Producto_Modal.php');

  if (isset($_COOKIE['session']) && $_COOKIE['session'] == '1') {
    ?>
    <script>
      alertify.success("Inicio de sesión con éxito");
    </script>
    <?php
  } else {
    // parece que las cookies no se borran completamente por lo que la alerta siempre estara cada que refresque la pagina aaa
    if (isset($_COOKIE['session'])) {
      setcookie('session', '', time() - 3600, '/');
      ?>
      <script>
        alertify.error("Usuario inválido");
      </script>
      <?php
    }
  }
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>