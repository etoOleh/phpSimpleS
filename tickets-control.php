<?php

session_start();
require_once __DIR__ . '/app/requires.php';

?>

<!doctype html>
<html lang="ru">
<head>

    <?php require_once __DIR__ . '/components/head.php';

    if (isset($_SESSION["user"])) {
        $config = require __DIR__ . '/config/app.php';
        if ((int)$user['group_id'] !== $config['admin_user_group']) {
            header("Location: /login.php");
            die();
        }
    }


    ?>

    <title>Управление заявками</title>
</head>
<body>

<?php require_once __DIR__ . '/components/header.php'?>

<section class="main">
    <div class="container">
        <div class="row">
            <h2 class="display-6 mb-3">Управление заявками</h2>
        </div>
        <div class="row">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Изображение</th>
                    <th scope="col">Название</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php

                $tags = $db->query("SELECT * FROM `tickets_tags`")->fetchAll(PDO::FETCH_ASSOC);
                $tickets = $db->query("SELECT * FROM `tickets`")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($tickets as $ticket) {
                    $tagId = $ticket['tag_id'];
                    $tag = array_filter($tags, function ($tag) use ($tagId) {
                        return (int)$tag['id'] === (int)$tagId;
                    });
                    $tag = array_shift($tag);

                    ?>

                    <tr>
                        <td>
                            <img src="<?= $ticket['image'];?>" width="200" alt="">
                        </td>
                        <td><?= $ticket['title'];?></td>
                        <td><?= $ticket['description'];?></td>
                        <td>
                            <span class="badge rounded-pill"
                                  style="background: <?= $tag['background'];?>; color: <?= $tag['color'];?>;">
                                <?= $tag['label']?>
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    Действия
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <form action="/actions/tickets/change_tag.php" method="post">
                                            <input type="hidden" name="id" value="<?= $ticket['id'];?>">
                                            <input type="hidden" name="tag" value="<?= $config['success_tickets_tag'];?>">
                                            <button class="dropdown-item" type="submit">Выполнено</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="/actions/tickets/change_tag.php" method="post">
                                            <input type="hidden" name="id" value="<?= $ticket['id'];?>">
                                            <input type="hidden" name="tag" value="<?= $config['in_progress_tickets_tag'];?>">
                                            <button class="dropdown-item" type="submit">В процессе</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="/actions/tickets/change_tag.php" method="post">
                                            <input type="hidden" name="id" value="<?= $ticket['id'];?>">
                                            <input type="hidden" name="tag" value="<?= $config['reject_tickets_tag'];?>">
                                            <button class="dropdown-item" type="submit">Отклонить</button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="/actions/tickets/remove.php" method="post">
                                            <input type="hidden" name="id" value="<?= $ticket['id'];?>">
                                            <button class="dropdown-item" type="submit">Удалить</button>
                                        </form>
                                    </li>
                                </ul>

                            </div>
                        </td>
                    </tr>

                    <?php
                }

                ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/components/scripts.php'?>

</body>
</html>