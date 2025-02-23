<div class="modal fade" id="Agregar_Producto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agrega un producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="Agregar_Producto.php">
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="codigo" name="codigo" class="form-control" placeholder="Formato: PROD00000" />
            <label class="form-label" for="codigo">Código de producto</label>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="nombre" name="nombre" class="form-control" />
            <label class="form-label" for="nombre">Nombre del producto</label>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="descripcionCorta" name="descripcionCorta" class="form-control" />
            <label class="form-label" for="descripcionCorta">Descripción corta del producto</label>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="descripcion" name="descripcion" class="form-control" />
            <label class="form-label" for="descripcion">Descripción del producto</label>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="imagen" name="imagen" class="form-control" />
            <label class="form-label" for="imagen">Imagen del producto</label>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="categoria" name="categoria" class="form-control" placeholder="Textil o Promocional" />
            <label class="form-label" for="categoria">Categoría del producto</label>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="existencias" name="existencias" class="form-control" />
            <label class="form-label" for="existencias">Número de existencias del producto</label>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="precio" name="precio" class="form-control" />
            <label class="form-label" for="precio">Precio del producto</label>
          </div>

          <button type="submit" class="btn btn-primary">Agregar</button>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>