<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        $_SESSION['error'] = 'Las contraseñas no coinciden.';
        header('Location: ./register.php'); 
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $filePath = '../data/usuarios.xml';
    $users = simplexml_load_file($filePath);

    foreach ($users->user as $user) {
        if ((string)$user->username === $username) {
            $_SESSION['error'] = 'El nombre de usuario ya está en uso.';
            header('Location: ./register.php');
            exit();
        }
    }

    $newUser = $users->addChild('user');
    $newUser->addChild('username', $username);
    $newUser->addChild('role', 'user');
    $newUser->addChild('email', $email);
    $newUser->addChild('password', $hashedPassword);

    $users->asXML($filePath);

    $_SESSION['success'] = 'Cuenta creada con éxito. Puedes iniciar sesión ahora.';
    header('Location: ./login.php');
    exit();
}
?>

