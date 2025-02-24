<?php
session_start();
$query = isset($_GET['query']) ? $_GET['query'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$products = simplexml_load_file('../data/productos.xml');
$filtered_products = [];

foreach ($products->product as $product) {

    if ((empty($query) || stripos($product->name, $query) !== false) && 
      (empty($category) || $product->category == $category)) {
    $filtered_products[] = $product;
  }
}

foreach ($filtered_products as $product) {
    $_SESSION['search']=$product;
    header('location: ../');
    exit();
}
?>
