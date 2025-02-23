<div class="modal fade" id="IniciarSesion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Iniciar sesion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="Iniciar_Sesion.php">
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="username" name="username" class="form-control" />
            <label class="form-label" for="username">Username</label>
          </div>

          <div data-mdb-input-init class="form-outline mb-4">
            <input type="password" id="password" name="password" class="form-control" />
            <label class="form-label" for="password">Password</label>
          </div>

          <button type="submit" class="btn btn-primary">Iniciar sesion</button>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>