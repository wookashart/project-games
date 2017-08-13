<div class="game-detail">
    <?php

    $gameDetail = $connection->query("SELECT * FROM games WHERE id_games = {$_GET['id']}");

    $detail = $gameDetail->fetch_assoc();
    
    $_SESSION['gameId'] = $_GET['id'];

    ?>
    
    <h1>
        <?php
            echo $detail['tytul'];
        ?>
    </h1>
    <div class="game-detail-conteiner">
        <div class="game-cover">
            <?php
                echo '<img src="db/covers/'.$detail['cover'].'">'
            ?>
        </div>
        <div class="game-information">
            <?php
                echo '<p><span class="game-info1">Dostępna na:</span><span class="game-info2 game-platform">'.$detail['platforma'].'</span></p>';
                echo '<p><span class="game-info1">Data premiery na świecie:</span><span class="game-info2">'.$detail['data_premiery'].'</span></p>';
                echo '<p><span class="game-info1">Data premiery w Polsce:</span><span class="game-info2">'.$detail['data_premiery_pl'].'</span></p>';
                echo '<p><span class="game-info1">Gatunek:</span><span class="game-info2">'.$detail['gatunek'].'</span></p>';
                echo '<p><span class="game-info1">Producent:</span><span class="game-info2">'.$detail['producent'].'</span></p>';
                echo '<p><span class="game-info1">Wydawca:</span><span class="game-info2">'.$detail['wydawca'].'</span></p>';
                echo '<p><span class="game-info1">Dystrybutor:</span><span class="game-info2">'.$detail['dystrybutor'].'</span></p>';
            ?>
        </div>
        <div class="gameplay-detail">
            <div><span>Ocena graczy:</span></div>
            <div><span>Średni czas przejścia:</span></div>
            <div><span>Najszybsze przejście gry:</span></div>
        </div>
    </div>
    <div class="add-games-collect">
     <?php

        if((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true)){

            $idGame = $_SESSION['gameId'];
            $idUser = $_SESSION['id'];

            if ($haveGame = $connection->query("SELECT * FROM users_library WHERE id_user = $idUser AND id_game = $idGame")){
            $alredyHave = $haveGame->num_rows;

            if($alredyHave > 0){
                echo '<button class="base-btn alredy-in-library" disabled>Posiadasz już tą grę</button>';
            } else {
                echo '<button class="base-btn add-to-library">Dodaj grę do kolekcji</button>';
            }
        }   
            echo '<button class="base-btn">Grałem w tą grę</button>';
        }

    ?>
    </div>
    <div class="modal-add-games-collection-conteiner">
        <div class="modal-add-games-collection">
            <h3>Wybierz platformę</h3>
            <form action="./db/addtolibrary.php" method="POST" class="select-platform-form">
                <select class="select-platform" name="select-platform" onchange="onchangeOptions()">
                    <option value="brak">-</option>
                </select>
                <div class="select-distribution"></div>
                <input type="submit" class="submit-to-library">
                <button class="base-btn cancel-select-platform">Rozmyśliłem się</button>
            </form>
        </div>
    </div>
    <article class="game-description">
        <?php
            echo $detail['opis_gry'];
        ?>
    </article>
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

<?php
    $connection->close();
?>