<?php
function esCodigoValido($var)
{
  return preg_match('/^[A-Z]{4}[0-9]{5}$/', $var) === 1;
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


function validateFields($id, $name, $description, $category, $price, $stock)
{
  $errors = [];

  if (empty($id) || empty($name) || empty($description) || empty($category) || empty($price) || empty($stock)) {
    array_push($errors, "Todos los campos son obligatorios.");
  } else {
    if (!esCodigoValido($id)) {
      array_push($errors, "El código no es válido.");
    }
    if (!esPrecioValido($price)) {
      array_push($errors, "El precio no es válido.");
    }
    if (!esExistenciasValidas($stock)) {
      array_push($errors, "Las existencias no son válidas.");
    }
    if (!esCategoriaValida($category)) {
      array_push($errors, "La categoría no es válida.");
    }
  }

  return $errors;
}