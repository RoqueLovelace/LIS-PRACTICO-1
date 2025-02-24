<?php
session_start();

if (isset($_SESSION['errors'])) {
    unset($_SESSION['errors']);
}

if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin-top: 50px;
        }

        .card {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <h2 class="text-center">Registro de Producto</h2>
            <form action="../controllers/new_product.php" method="POST" enctype="multipart/form-data">
                <!-- Código del Producto -->
                <div class="mb-3">
                    <label for="id" class="form-label">Código del Producto</label>
                    <input type="text" name="id" id="id" class="form-control" value="<?php echo setId(); ?>" readonly>
                </div>
                <!-- Nombre del Producto -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre del Producto *</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <!-- Descripción -->
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción *</label>
                    <textarea name="description" id="description" class="form-control" required></textarea>
                </div>
                <!-- Imagen -->
                <div class="mb-3">
                    <label for="image" class="form-label">Imagen del Producto (JPG, JPEG,PNG) *</label>
                    <input type="file" name="image" id="image" class="form-control" accept=".jpg, .png, .jpeg" required>
                </div>
                <!-- Categoría -->
                <div class="mb-3">
                    <label for="category" class="form-label">Categoría</label>
                    <select name="category" id="category" class="form-control">
                        <option value="Textil">Textil</option>
                        <option value="Promocional">Promocional</option>
                    </select>
                </div>
                <!-- Precio -->
                <div class="mb-3">
                    <label for="price" class="form-label">Precio *</label>
                    <input type="number" name="price" id="price" class="form-control" min="0.01" step="0.01" required>
                </div>
                <!-- Existencias -->
                <div class="mb-3">
                    <label for="stock" class="form-label">Existencias *</label>
                    <input type="number" name="stock" id="stock" class="form-control" min="0" required>
                </div>
                <!-- Botón de envío -->
                <button type="submit" class="btn btn-primary w-100">Registrar Producto</button>
            </form>
        </div>
    </div>
    <?php
    function setId()
    {
        return "PROD" . str_pad(rand(1, 99999), 5, "0", STR_PAD_LEFT);
    }
    ?>

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