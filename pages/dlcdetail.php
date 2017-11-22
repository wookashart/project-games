<div class="game-detail">
    <?php

    $gameDetail = $connection->query("SELECT * FROM dlc, games WHERE games.id_games = dlc.id_game");
    $detail = $gameDetail->fetch_assoc();
    
    if ($detail['dlc_date'] == '0000-00-00') {
        $dateWorld = 'Brak danych';
    } else {
        $dateWorld = $detail['dlc_date'];
    }

    if ($detail['dlc_date_pl'] == '0000-00-00') {
        $datePl = 'Brak danych';
    } else {
        $datePl = $detail['dlc_date_pl'];
    }

    ?>
    
    <h1><?= $detail['tytul'] ?> - <?= $detail['dlc_name'] ?></h1>
    <div class="game-detail-conteiner">
        <div class="game-cover">
            <?php 

                if($detail['dlc_cover'] != null){
                    echo '<img src="db/covers_dlc/'.$detail['dlc_cover'].'">';
                } else {
                    echo '<img src="img/no-cover.png">';
                }

            ?>
        </div>
        <div class="game-information">
            <p>
                <span class="game-info1">Dostępna na:</span>
                <span class="game-info2 game-platform"><?= $detail['dlc_platform'] ?></span>
            </p>
            <p>
                <span class="game-info1">Data premiery na świecie:</span>
                <span class="game-info2"><?= $dateWorld ?></span>
            </p>
            <p>
                <span class="game-info1">Data premiery w Polsce:</span>
                <span class="game-info2"><?= $datePl ?></span>
            </p>
        </div>
    </div>    
    <article class="game-description"><?= $detail['dlc_description'] ?></article>
    <?php

        $tutConnect = $connection->query("SELECT * FROM tutorials WHERE tut_game_id = {$_SESSION['gameId']}");
        $howManyTut = $tutConnect->num_rows;

        if($howManyTut > 0){
            echo '<div class="game-tutorials"><h3>Poradniki</h3><ul>';

            while($tut = $tutConnect->fetch_assoc()){
                echo '<li><a href="index.php?action=tutorial&amp;id='.$tut['tut_id'].'">'.$tut['tut_title'].'</a></li>';
            }

            echo '</ul></div>';
        }

    ?>
</div>

<?php
    $connection->close();
?>