<?php

require __DIR__ . '/../vendor/autoload.php';
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Configuration\Configuration;

$cloud_name = "dp7iiqv6v"; 
$api_key = "976342883939675"; 
$api_secret = "Yn1UJHLIn-kd0bJ0F-NKPIy02Vc";

Configuration::instance([
    'cloud' => [
        'cloud_name' => $cloud_name,
        'api_key' => $api_key,
        'api_secret' => $api_secret,
    ],
    'url' => [
        'secure' => true,
    ]
]);


/**
 * upload image on Cloudinary
 *
 * @param array $image Archivo de imagen subido ($_FILES['image'])
 * @param string|null $oldImageUrl URL de la imagen anterior (para eliminar si es necesario)
 * @return string URL de la nueva imagen o mensaje de error
 */
function uploadImage($image, $oldImageUrl = null) {
  
    $file = $image['tmp_name'];
    if (!file_exists($file)) {
        return "El archivo no existe.";
    }

    if (getimagesize($file) === false) {
        return "El archivo no es una imagen válida.";
    }


    $upload = new UploadApi();

    try {
        if ($oldImageUrl) {
            $publicId = getPublicIdFromUrl($oldImageUrl);
        }

        $response = $upload->upload($file, [
            'public_id' => $publicId,
            'use_filename' => true,
            'overwrite' => true
        ]);

        return $response['secure_url']; 

    } catch (\Exception $e) {
        return "Error al subir la imagen: " . $e->getMessage();
    }
}


/**
 * delete an image on cloudinary
 *
 * @param string $imageUrl URL de la imagen a eliminar
 * @return bool True si se elimina correctamente, False si hay error
 */
function deleteImage($imageUrl) {
    $publicId = getPublicIdFromUrl($imageUrl);
    if (!$publicId) return false;

    try {
        $adminApi = new AdminApi();
        $response = $adminApi->deleteAssets([$publicId]);

        return isset($response['deleted'][$publicId]) && $response['deleted'][$publicId] === 'deleted';
    } catch (\Exception $e) {
        error_log("Error al eliminar la imagen de Cloudinary: " . $e->getMessage());
        return false;
    }
}

/**
 * get public_id from cloudinary URL
 *
 * @param string $url URL completa de la imagen en Cloudinary
 * @return string|null Public ID de la imagen o null si no se encuentra
 */
function getPublicIdFromUrl($url) {
    $parsed_url = parse_url($url);
    $path = trim($parsed_url['path'], '/');
    $segments = explode('/', $path);

    if (count($segments) > 1) {
        return pathinfo(end($segments), PATHINFO_FILENAME);
    }
    
    return null;
}

?>
