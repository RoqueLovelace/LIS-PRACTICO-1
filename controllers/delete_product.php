<?php

session_start();

if(isset($_POST['delete_product']) && isset($_POST['product_id'])){
    $productId = $_POST['product_id'];

    deleteProduct($productId);
}

function deleteProduct($productId)
{

    $products = simplexml_load_file('../data/productos.xml');
    $index = 0;
    foreach ($products->product as $product) {
        if($product->id==$productId){
            unset($products->product[$index]);
            file_put_contents('../data/productos.xml', $products->asXML());
            $_SESSION['message'] = "Producto eliminado.";
            header('location: ../');
        }
        $index++;
    }
}
