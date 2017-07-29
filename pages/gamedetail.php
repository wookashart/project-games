<div class="game-detail">
    <?php

    $gameDetail = $connection->query("SELECT * FROM games WHERE id_games = {$_GET['id']}");

    $detail = $gameDetail->fetch_assoc();

    ?>

    <a href="index.php?action=biblioteka">Powrót do listy gier</a>
    <h1>
        <?php
            echo $detail['tytul'];
        ?>
    </h1>
    <div>
        <div class="game-cover">
            <?php
                echo '<img src="'.$detail['cover'].'">'
            ?>
        </div>
        <div class="game-information">
            <?php
                echo '<p><span>Dostępna na:</span><span>'.$detail['platforma'].'</span></p>';
                echo '<p><span>Data premiery na świecie:</span><span>'.$detail['data_premiery'].'</span></p>';
                echo '<p><span>Data premiery w Polsce:</span><span>'.$detail['data_premiery_pl'].'</span></p>';
                echo '<p><span>Gatunek:</span><span>'.$detail['gatunek'].'</span></p>';
                echo '<p><span>Producent:</span><span>'.$detail['producent'].'</span></p>';
                echo '<p><span>Wydawca:</span><span>'.$detail['wydawca'].'</span></p>';
                echo '<p><span>Dystrybutor:</span><span>'.$detail['dystrybutor'].'</span></p>';
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