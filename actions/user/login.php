<?php
session_start();
require_once __DIR__ . '/../../app/requires.php';



$email = $_POST['email'];
$password = $_POST['password'];


//$fields = [
//    'email' => [
//        'value' => $email,
//        'error' => false,
//    ],
//    'password' => [
//        'error' => false,
//    ],
//];
//
//
//if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
//    $errors['email']['error'] = true;
//    $error = true;
//}
//
//if ($password) {
//    $errors['password']['error'] = true;
//    $error = true;
//}
//
//if ($error) {
//    $_SESSION['fields'] = $fields;
//    header('Location: /register.php');
//}


$query = $db->prepare("SELECT * FROM `users` WHERE email = :email");
$query->execute(['email' => $email]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['auth_error'] = true;
    header('Location: /login.php');
    die();
}

if (!password_verify($password, $user['password'])) {
    $_SESSION['auth_error'] = true;
    header('Location: /login.php');
    die();
}

$_SESSION['user'] = $user['id'];
header('Location: /');
