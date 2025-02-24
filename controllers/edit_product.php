<?php

if (isset($username) && $role == "admin") {
?>
    <button type="button" class="btn btn-warning text-white fw-bold" data-bs-toggle="modal"
        data-bs-target="#Editar<?= $id ?>">
        Editar
    </button>
<?php } ?>
<?php if (isset($role) && $role == "user") { ?>
    <a href="" class="h-100">
        <form method="POST" class="h-100" action="./controllers/favorites.php">
            <input type="hidden" name="product_id" value="<?= $product->id ?>">
            <button type="submit" name="add_favorite" class="btn btn-warning h-100">Favs</button>
        </form>
    </a>
<?php } ?>

<!-- MODAL PARA EDITAR PRODUCTO -->
<div class="modal fade" id="Editar<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="./controllers/new_product.php" enctype="multipart/form-data">
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input id="id" name="id" class="form-control" value="<?= $id ?>" readonly />
                        <label class="form-label" for="id">Código de producto</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input id="name" name="name" class="form-control" value="<?= $name ?>" />
                        <label class="form-label" for="name">Nombre del producto</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input id="description" name="description" class="form-control" value="<?= $description ?>" />
                        <label class="form-label" for="description">Descripción del producto</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input value="<?= $image_url ?>" readonly name="oldImage" />
                        <input type="file" id="image" name="image" class="form-control" accept=".jpg, .png, .jpeg" />
                        <label class="form-label" for="image">Imagen del producto</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input id="category" name="category" class="form-control" value="<?= $category ?>" />
                        <label class="form-label" for="category">Categoría del producto</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input id="stock" name="stock" class="form-control" value="<?= $stock ?>" />
                        <label class="form-label" for="stock">Número de existencias del producto</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-4">
                        <input id="price" name="price" class="form-control" value="<?= $price ?>" />
                        <label class="form-label" for="price">Precio del producto</label>
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