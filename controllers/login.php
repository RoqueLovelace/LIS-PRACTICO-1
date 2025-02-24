<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $filePath = '../data/usuarios.xml';
    $users = simplexml_load_file($filePath);

    $userFound = false;
    foreach ($users->user as $user) {
        if ((string)$user->username === $username) {
            $userFound = true;

            $storedPassword = (string)$user->password;

            if (password_verify($password, $storedPassword)) {
                $_SESSION['username'] = $username;
                $_SESSION['email'] = (string)$user->email;
                $_SESSION['role'] = (string)$user->role;
                $_SESSION['loggedin'] = true;

                header('Location: ../');
                exit();
            } else {
                $_SESSION['error'] = 'Credenciales incorrectos.';
                break;
            }
        }
    }

    if (!$userFound) {
        $_SESSION['error'] = 'Credenciales incorrectos';
    }

    header('Location: ./login.php');
    exit();
}
