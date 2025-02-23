<?php

session_start();
require_once __DIR__ . '/../../app/requires.php';

if (!isset($_SESSION['user'])) {
    echo 'Error handle request ';
    die();
}

$id = $_POST['id'];

$query = $db->prepare("SELECT `user_id` FROM `tickets` WHERE `id` = :id");
$query->execute(['id' => $id]);
$ticket = $query->fetch(PDO::FETCH_ASSOC);

if ($ticket['user_id'] !== $_SESSION['user']) {
    echo 'Error handle request ';
    die();
}

$query = $db->prepare("DELETE FROM `tickets` WHERE `id` = :id");
$query->execute(['id' => $id]);

header('Location: /my-tickets.php');