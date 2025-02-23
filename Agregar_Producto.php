<?php
session_start();

include 'Validacion_de_Campos.php';

if (isset($_POST)) {
  $codigo = $_POST['codigo'];
  $nombre = $_POST['nombre'];
  $descripcionCorta = $_POST['descripcionCorta'];
  $descripcion = $_POST['descripcion'];
  $imagen = $_POST['imagen'];
  $categoria = $_POST['categoria'];
  $precio = $_POST['precio'];
  $existencias = $_POST['existencias'];

  $errores = validarCampos($codigo, $nombre, $descripcionCorta, $descripcion, $imagen, $categoria, $precio, $existencias);

  if (!empty($errores)) {
    $_SESSION['errores'] = $errores;
    header('Location: index.php');
  } else {
    $_SESSION['success'] = "Producto agregado correctamente.";
    header('Location: index.php');
    exit;
  }
}