<?php
require_once __DIR__ . '/../../app/requires.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    unset($_SESSION['user']);
    session_destroy();
    header("location: /");
} else {
    echo 'Error handle request ';
    die();
}

//session_start();
//unset($_SESSION['user']);
//session_destroy();
//header("location: /");