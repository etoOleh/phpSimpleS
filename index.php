<?php
session_start();
require_once __DIR__ . '/app/requires.php';
?>


<!doctype html>
<html lang="ru">
<head>

    <?php require_once __DIR__ . '/components/head.php'?>

    <title>Главная</title>
</head>

<?php
    require_once __DIR__ . "/database/db.php";
?>

<body>

<?php require_once __DIR__ . '/components/header.php'?>

<section class="main">
    <div class="container">
        <div class="row">
            <h2 class="display-6 mb-3">Заявки</h2>
        </div>
        <div class="row">

            <?php

            $tickets = $db->query("SELECT * FROM `tickets`")->fetchAll(PDO::FETCH_ASSOC);
            $tags = $db->query("SELECT * FROM `tickets_tags`")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($tickets as $ticket) {
                $tagId = $ticket['tag_id'];
                $tag = array_filter($tags, function ($tag) use ($tagId) {
                    return (int)$tag['id'] === (int)$tagId;
                });
                $tag = array_shift($tag);

                ?>
            <div class="card mb-3">
                <img src="<?= $ticket['image'];?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $ticket['title'];?>
                        <span class="badge rounded-pill"
                              style="background: <?= $tag['background'];?>; color: <?= $tag['color'];?>;">
                                <?= $tag['label']?>
                            </span>
                    </h5>
                    <p class="card-text"><?= $ticket['description'];?></p>
                    <p class="card-text"><small class="text-muted">Добавлено: <?= $ticket['created_at'];?></small></p>
                </div>
            </div>

                <?php
            }

            ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/components/scripts.php'?>

</body>
</html>