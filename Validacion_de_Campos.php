<?php
function esCodigoValido($var)
{
  return preg_match('/^[A-Z]{2}[0-9]{5}$/', $var) === 1;
}
function esPrecioValido($var)
{
  return is_numeric($var);
}
function esExistenciasValidas($var)
{
  return is_numeric($var) && intval($var) == $var && $var >= 0;
}
function esCategoriaValida($var)
{
  return ($var == 'Textil' || $var == 'Promocional');
}
function esImagenValida($var)
{
  return preg_match('/\.(jpg|png)$/i', $var) === 1;
}


function validarCampos($codigo, $nombre, $descripcionCorta, $descripcion, $imagen, $categoria, $precio, $existencias)
{
  $errores = [];

  if (empty($codigo) || empty($nombre) || empty($descripcionCorta) || empty($descripcion) || empty($imagen) || empty($categoria) || empty($precio) || empty($existencias)) {
    array_push($errores, "Todos los campos son obligatorios.");
  } else {
    if (!esCodigoValido($codigo)) {
      array_push($errores, "El código no es válido.");
    }
    if (!esPrecioValido($precio)) {
      array_push($errores, "El precio no es válido.");
    }
    if (!esExistenciasValidas($existencias)) {
      array_push($errores, "Las existencias no son válidas.");
    }
    if (!esCategoriaValida($categoria)) {
      array_push($errores, "La categoría no es válida.");
    }
    if (!esImagenValida($imagen)) {
      array_push($errores, "La imagen no es válida.");
    }
  }

  return $errores;
}