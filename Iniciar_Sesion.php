<?php
if (isset($_POST)) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  if ($username == 'admin' && $password == '12345') {
    setcookie('session', '1', time() + 3600, '/');
    header('location:index.php');
  } else {
    setcookie('session', '0', time() + 3600, '/');
    header('location:index.php');
  }
}
?>