<?php
session_start();

if (isset($_POST['add_favorite']) && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $username = $_SESSION['username'];

    newFavorite($username, $productId);
}

if (isset($_POST['delete_favorite']) && isset($_POST['product_id']) && isset($_SESSION['username'])) {
    $productId = $_POST['product_id'];
    $username = $_SESSION['username'];

    $message = deleteFavorite($username, $productId);
    $_SESSION['message'] = $message;
    header('Location: ../views/profile.php'); 
    exit;
}

function newFavorite($username, $productId)
{
    $favorites = simplexml_load_file('../data/favoritos.xml');

    $userFound = false;

    foreach ($favorites->user as $user) {
        if ($user->username == $username) {
            $userFound = true;
            $products = $user->products;

            $productExists = false;
            foreach ($products->productId as $product) {
                if ((string)$product == $productId) {
                    $productExists = true;
                    break;
                }
            }

            if (!$productExists) {
                $products->addChild('productId', $productId);
                $favorites->asXML('../data/favoritos.xml');
                $_SESSION['message'] = "Producto agregado a favoritos.";
                header('location: ../');
            } else {
                $_SESSION['message'] = "Este producto ya está en tus favoritos.";
                header('location: ../');
            }
        }
    }

    if (!$userFound) {
        $newUser = $favorites->addChild('user');
        $newUser->addChild('username', $username);
        $products = $newUser->addChild('products');
        $products->addChild('productId', $productId);
        $favorites->asXML('../data/favoritos.xml');
        $_SESSION['message'] = "Producto agregado a favoritos.";
        header('location: ../');
    }
}

function getFavorites($username)
{
    $favorites = simplexml_load_file('../data/favoritos.xml');
    $favs = [];

    foreach ($favorites->user as $user) {
        if ($user->username == $username) {
            foreach ($user->products->productId as $productId) {
                $favs[] = (string)$productId;
            }
        }
    }
    return $favs;
}

function deleteFavorite($username, $productId)
{
    $favorites = simplexml_load_file('../data/favoritos.xml');
    $userFound = false;

    foreach ($favorites->user as $user) {
        if ((string)$user->username == $username) {
            $userFound = true;
            $products = $user->products;
            
            $index = 0;
            foreach ($products->productId as $product) {
                if ((string)$product == $productId) {
                    unset($products->productId[$index]);
                    file_put_contents('../data/favoritos.xml', $favorites->asXML());
                    $_SESSION['message'] = "Producto eliminado de favoritos."; 
                    header('Location: ../views/profile.php');
                    exit;
                }
                $index++;
            }
            return "El producto no está en la lista de favoritos.";
        }
    }

    if (!$userFound) {
        return "No se encontraron favoritos para este usuario.";
    }
}