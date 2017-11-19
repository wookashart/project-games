<div class="game-detail">
    <?php

    $gameDetail = $connection->query("SELECT * FROM games WHERE id_games = {$_GET['id']}");

    $detail = $gameDetail->fetch_assoc();
    
    $_SESSION['gameId'] = $_GET['id'];

    ?>
    
    <h1><?= $detail['tytul'] ?></h1>
    <div class="game-detail-conteiner">
        <div class="game-cover">
            <?php 

                if($detail['cover'] != null){
                    echo '<img src="db/covers/'.$detail['cover'].'">';
                } else {
                    echo '<img src="img/no-cover.png">';
                }

            ?>
        </div>
        <div class="game-information">
            <p>
                <span class="game-info1">Dostępna na:</span>
                <span class="game-info2 game-platform"><?= $detail['platforma'] ?></span>
            </p>
            <p>
                <span class="game-info1">Data premiery na świecie:</span>
                <span class="game-info2"><?= $detail['data_premiery'] ?></span>
            </p>
            <p>
                <span class="game-info1">Data premiery w Polsce:</span>
                <span class="game-info2"><?= $detail['data_premiery_pl'] ?></span>
            </p>
            <p>
                <span class="game-info1">Gatunek:</span>
                <span class="game-info2"><?= $detail['gatunek'] ?></span>
            </p>
            <p>
                <span class="game-info1">Producent:</span>
                <span class="game-info2"><?= $detail['producent'] ?></span>
            </p>
            <p>
                <span class="game-info1">Wydawca:</span>
                <span class="game-info2"><?= $detail['wydawca'] ?></span>
            </p>
            <p>
                <span class="game-info1">Dystrybutor:</span>
                <span class="game-info2"><?= $detail['dystrybutor'] ?></span>
            </p>
        </div>
        <div class="gameplay-detail">
            <div class="game-rating"><p class="game-rating-header">Ocena graczy:</p>
            <?php

                $playersScore = $connection->query("SELECT sum(rating) AS sumScore, count(rating) AS allPosition FROM users_library WHERE id_game = {$_SESSION['gameId']}");
                $allScore = $playersScore->fetch_assoc();

                if ($allScore['sumScore'] != 0 && $allScore['allPosition'] != 0){
                    $playersAverage = $allScore['sumScore'] / $allScore['allPosition'];
                    echo '<p class="rating">'.$playersAverage.'</p>';
                } else {
                    echo '<p class="rating">brak</p>';
                }

            ?>
            </div>
            <div class="game-rating">
                <?php
                    if((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true)){
                        $yourScore = $connection->query("SELECT * FROM users_library WHERE id_game = {$_SESSION['gameId']} AND id_user = {$_SESSION['id']}");
                        $displYourScore = $yourScore->fetch_assoc();
                        
                        if ($displYourScore['rating'] != 0){
                            echo '<p class="game-rating-header">Twoja ocena:</p><p class="rating">'.$displYourScore['rating'].'</p>';
                        } else {
                            echo '<p class="game-rating-header">Twoja ocena:</p><p class="rating">brak</p>';
                        }
                    }

                ?>
            </div>
            <div class="game-time">
                <p>Średni czas gry:</p>
                <div>
                    <?php

                        $timeConnect = $connection->query("SELECT sum(finish_game_min) AS sumMin, count(id_game) AS allGame FROM users_library WHERE id_game = {$_SESSION['gameId']} AND finish = 'yes'");
                        $time = $timeConnect->fetch_assoc();

                        if ($time['allGame'] == 0){
                            echo '<span class="play-time">brak</span>';
                        } else {
                                                      
                            $sumMin = $time['sumMin'];
                            $allHour = floor($sumMin / 60);
                            $allMin = $sumMin % 60;
                          
                            echo '<span class="play-time">'.$allHour.'</span><span>Godz</span><span class="play-time">'.$allMin.'</span><span>Min</span>';
                        }
                        

                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="add-games-collect">
     <?php

        if((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true)){

            $idGame = $_SESSION['gameId'];
            $idUser = $_SESSION['id'];

            if ($haveGame = $connection->query("SELECT * FROM users_library WHERE id_user = $idUser AND id_game = $idGame")){
            $game = $haveGame->fetch_assoc();

                if($game['have'] == 'yes'){
                    echo '<button class="base-btn alredy-in-library" disabled>Posiadasz już tą grę</button>';
                } else {
                    echo '<button class="base-btn add-to-library">Dodaj grę do kolekcji</button>';
                }
            }

            if ($game['finish'] == 'yes'){          
                echo '<button class="base-btn alredy-played-btn" disabled>Przeszedłem</button>';
            } else {
                echo '<button class="base-btn add-to-played-btn">Grałem w tą grę</button>';
            }    
        }

    ?>
    </div>
    <div class="modal-add-games-collection-conteiner modal-conteiner">
        <div class="modal-add-games-collection modal-add-game">
            <h3>Wybierz platformę</h3>
            <form action="./php/addtolibrary.php" method="POST" class="select-platform-form">
                <select class="select-platform" name="select-platform" onchange="onchangeOptions()">
                    <option value="brak">-</option>
                </select>
                <div class="select-distribution"></div>
                <input type="submit" class="submit-to-library">
                <button class="base-btn cancel-select-platform">Rozmyśliłem się</button>
            </form>
        </div>
    </div>
    <div class="modal-add-played-games-conteiner modal-conteiner">
         <div class="modal-add-played-games modal-add-game">
            <h3>Twoja ocena</h3>
            <form action="./php/playedgames.php" method="POST" class="played-games-form">
                <input id="ex8" data-slider-id='ex1Slider' type="text" data-slider-min="1" data-slider-max="10" data-slider-step="1" data-slider-value="1" name="played-slider">
                <div class="game-time">
                    <h3>Czas poświęcony grze</h3>
                    <input type="number" min="0" name="played-hour" placeholder="Godziny" value="0">
                    <input type="number" min="0" max="60" name="played-minut" placeholder="Minuty" value="0">
                </div>
                <input type="submit">
                <button class="base-btn cancel-played-game">Rozmyśliłem się</button>
            </form>
        </div>
    </div>
    <article class="game-description"><?= $detail['opis_gry'] ?></article>
    <div class="game-requirements">
        <h3>Wymagania sprzętowe</h3>
        <ul>
            <li>
                <span>Procesor:</span>
                <span><?= $detail['procesor'] ?></span>
            </li>
            <li>
                <span>Karta graficzna:</span>
                <span><?= $detail['grafika'] ?></span>
            </li>
            <li>
                <span>Pamięć RAM:</span>
                <span><?= $detail['ram'] ?></span>
            </li>
            <li>
                <span>System:</span>
                <span><?= $detail['system'] ?></span>
            </li>
            <li>
                <span>DirectX:</span>
                <span><?= $detail['directx'] ?></span>
            </li>
            <li>
                <span>Wymagane miejsce na dysku:</span>
                <span><?= $detail['dysk'] ?></span>
            </li>
        </ul>
    </div>
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