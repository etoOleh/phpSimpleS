<?php

session_start();
require_once __DIR__ . '/../../app/requires.php';
$config = require_once __DIR__ . '/../../config/app.php';

if (!isset($_SESSION['user'])) {
    echo 'Error handle request ';
    die();
}

$id = $_POST['id'];
$tag = $_POST['tag'];

$q = $db->prepare("SELECT * FROM `tickets_tags` WHERE `id` = :id");
$q->execute(['id' => $tag]);
$tagExists = $q->fetch();

if (!$tagExists) {
    echo 'Error handle request ';
    die();
}


// получим тут пользователя текущего
$query = $db->prepare("SELECT * FROM `users` WHERE id = :id");
$query->execute(['id' => $_SESSION['user']]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if ((int)$user['group_id'] === $config['admin_user_group']) {
    $q = $db->prepare("UPDATE `tickets` SET `tag_id` = :tag WHERE `id` = :id");
//    $q->execute(['tag' => $tag, 'id' => $id]);
    try {
        $q->execute(['tag' => $tag, 'id' => $id]);
    } catch (\PDOException $exception) {
        echo 'Error handle request ' . $exception->getMessage();
    }
}

header('Location: /tickets-control.php');