<?php

session_start();
include_once(__DIR__ . '/../services/cloudinarySDK.php');
include_once(__DIR__ . '/validate_fields.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
  $id = $_POST['id'];
  $name = $_POST['name'];
  $description = $_POST['description'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $stock = $_POST['stock'];

  $errors = validateFields($id, $name, $description, $category, $price, $stock);

    $oldImage_url = $_POST['oldImage'] ?? null;

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../views/register_product.php");
        exit();
    }

    $image_url = $oldImage_url;

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        try {
            $image_url = uploadImage($_FILES['image'], $oldImage_url);
        } catch (Exception $e) {
            $_SESSION['errors'] = ["Error al subir la imagen: " . $e->getMessage()];
            header("Location: ../views/register_product.php");
            exit();
        }
    } elseif (!$oldImage_url) {
        $_SESSION['errors'] = ["Debe proporcionar una imagen."];
        header("Location: ../views/register_product.php");
        exit();
    }

    $products = simplexml_load_file('../data/productos.xml');

    $editProduct = null;
    foreach ($products->product as $product) {
        if ((string)$product->id === $id) {
            $editProduct = $product;
            break;
        }
    }

    if ($editProduct) {
        $editProduct->name = $name;
        $editProduct->description = $description;
        $editProduct->category = $category;
        $editProduct->price = $price;
        $editProduct->stock = $stock;
        $editProduct->image_url = $image_url;
    } else {
        $product = $products->addChild('product');
        $product->addChild('id', $id);
        $product->addChild('name', $name);
        $product->addChild('description', $description);
        $product->addChild('category', $category);
        $product->addChild('price', $price);
        $product->addChild('stock', $stock);
        $product->addChild('image_url', $image_url);
    }

    file_put_contents('../data/productos.xml', $products->asXML());

    $_SESSION['message'] = $editProduct ? "Producto editado exitosamente" : "Producto agregado correctamente.";
    header("Location: ../");
    exit();
}