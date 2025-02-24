// favorites.php
<?php
session_start();

if (isset($_POST['add_favorite']) && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $username = $_SESSION['username'];

    $message = newFavorite($username, $productId);
    echo $message;
}

function newFavorite($username, $productId) {
    $favorites = simplexml_load_file('../data/favoritos.xml');  
    
    $userFound = false;
    
    foreach ($favorites->user as $user) {
        if ($user->username == $username) {  
            $userFound = true;
            $products = $user->products;
            
            $productExists = false;
            foreach ($products->productId as $product) {
                if ((int)$product == $productId) {
                    $productExists = true;
                    break;
                }
            }
            
            if (!$productExists) {
                $products->addChild('productId', $productId);
                $favorites->asXML('../data/favoritos.xml'); 
                return "Producto agregado a favoritos.";
            } else {
                return "Este producto ya está en tus favoritos.";
            }
        }
    }

    if (!$userFound) {
        $newUser = $favorites->addChild('user');
        $newUser->addChild('username', $username);
        $products = $newUser->addChild('products');
        $products->addChild('productId', $productId);
        $favorites->asXML('../data/favoritos.xml'); 
        return "Producto agregado a favoritos.";
    }
}

function getFavorites($username) {
    $favorites = simplexml_load_file('../data/favoritos.xml');  
    $favs = [];

    foreach ($favorites->user as $user) {
        if ($user->username == $username) {
            foreach ($user->products->productId as $productId) {
                $favs[] = (int)$productId;
            }
        }
    }
    return $favs;
}

?>
