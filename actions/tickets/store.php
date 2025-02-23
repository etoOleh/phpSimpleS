<?php
session_start();
require_once __DIR__ . '/../../app/requires.php';
$config = require_once __DIR__ . '/../../config/app.php';

if (!isset($_SESSION['user'])) {
    echo 'Error handle request ';
    die();
}

$title = $_POST['title'];
$description = $_POST['description'];
$image = $_FILES['image'];

//TODO: VALIDATION

$path = __DIR__ . '/../../uploads/';

if (!is_dir($path)) {
    mkdir($path);
}

$filename = uniqid() . '-' . $image['name'];

move_uploaded_file($image['tmp_name'], "$path/$filename");

$query = $db->prepare("INSERT INTO `tickets` (`title`, `description`, `image`,`tag_id`, `user_id`) VALUES (:title, :description, :image, :tag_id, :user_id)");
try {
    $query->execute([
        'title' => $title,
        'description' => $description,
        'image' => "uploads/$filename",
        'tag_id' => $config['default_tickets_tag'],
        'user_id' => $_SESSION['user'],
    ]);
    header('Location: /my-tickets.php');
} catch (\PDOException $exception) {
    //TODO: VALIDATION
    echo $exception->getMessage();
}
//dd($title,$description,$image);
//dd($filename);