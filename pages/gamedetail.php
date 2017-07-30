<div class="game-detail">
    <?php

    $gameDetail = $connection->query("SELECT * FROM games WHERE id_games = {$_GET['id']}");

    $detail = $gameDetail->fetch_assoc();

    ?>

    <!-- <a class="return-game-list" href="index.php?action=biblioteka">Powrót do listy gier</a> -->
    <h1>
        <?php
            echo $detail['tytul'];
        ?>
    </h1>
    <div class="game-detail-conteiner">
        <div class="game-cover">
            <?php
                echo '<img src="'.$detail['cover'].'">'
            ?>
        </div>
        <div class="game-information">
            <?php
                echo '<p><span class="game-info1">Dostępna na:</span><span class="game-info2">'.$detail['platforma'].'</span></p>';
                echo '<p><span class="game-info1">Data premiery na świecie:</span><span class="game-info2">'.$detail['data_premiery'].'</span></p>';
                echo '<p><span class="game-info1">Data premiery w Polsce:</span><span class="game-info2">'.$detail['data_premiery_pl'].'</span></p>';
                echo '<p><span class="game-info1">Gatunek:</span><span class="game-info2">'.$detail['gatunek'].'</span></p>';
                echo '<p><span class="game-info1">Producent:</span><span class="game-info2">'.$detail['producent'].'</span></p>';
                echo '<p><span class="game-info1">Wydawca:</span><span class="game-info2">'.$detail['wydawca'].'</span></p>';
                echo '<p><span class="game-info1">Dystrybutor:</span><span class="game-info2">'.$detail['dystrybutor'].'</span></p>';
            ?>
        </div>
    </div>
    <p class="game-description">
        <?php
            echo $detail['opis_gry'];
        ?>
    </p>
    <div class="game-requirements">
        <h3>Wymagania sprzętowe</h3>
        <ul>
            <?php
                echo '<li><span>Procesor:</span><span>'.$detail['procesor'].'</span></li>';
                echo '<li><span>Karta graficzna:</span><span>'.$detail['grafika'].'</span></li>';
                echo '<li><span>Pamięć RAM:</span><span>'.$detail['ram'].'</span></li>';
                echo '<li><span>System:</span><span>'.$detail['system'].'</span></li>';
                echo '<li><span>DirectX:</span><span>'.$detail['directx'].'</span></li>';
                echo '<li><span>Wymagane miejsce na dysku:</span><span>'.$detail['dysk'].'</span></li>';
            ?>
        </ul>
    </div>
</div>