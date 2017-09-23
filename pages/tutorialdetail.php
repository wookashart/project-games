<?php

    $tutConnect = $connection->query("SELECT games.*, tutorials.* FROM games, tutorials WHERE tutorials.tut_id = {$_GET['id']} AND tutorials.tut_game_id = games.id_games ORDER BY games.tytul ASC");
    $tut = $tutConnect->fetch_assoc();


?>
<div class="tutorial-detail">
    <h1><?= $tut['tytul'].' - '.$tut['tut_title'] ?></h1>
    <p class="tut-game-info">Sprawdź informacjie o grze <?= $tut['tytul'] ?> <a href="index.php?action=gamedetail&amp;id=<?= $tut['id_games'] ?>">tutaj</a></p>
    <div class="tut-detail-date"><?= $tut['tut_date'] ?></div>
    <div class="tut-detail-author"><?= $tut['tut_author'] ?></div>
    <div class="tut-detail-content">
        <div><?= $tut['tut_header'] ?></div>
        <div><?= $tut['tut_content'] ?></div>
    </div>
</div>