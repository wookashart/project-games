<?php
    $userDetail = $connection->query("SELECT * FROM users WHERE id = {$_SESSION['id']}");
    $detail = $userDetail->fetch_assoc();
?>

<div class="user-profile-page">
    <div class="user-info-conteiner">
        <div class="user-avatar">
            <?php
                if($detail['avatar'] == null){
                    
                    if ($detail['plec'] == 'Kobieta'){
                        echo '<img src="./img/no-avatar-female.png" class="no-avatar no-avatar-female">';
                    } else {
                        echo '<img src="./img/no-avatar-male.png" class="no-avatar no-avatar-male">';
                    }
                    
                } else {
                    echo '<img src="./db/useravatars/'.$detail['avatar'].'" class="user-avatar-img">';
                }
            ?>
        </div>
        <div class="user-info">
            <?php
                
                echo '<p><span class="user-info1">Nick:</span><span class="user-info2">'.$detail['login'].'</span></p>';
                echo '<p><span class="user-info1">Płeć:</span><span class="user-info2">'.$detail['plec'].'</span></p>';
                
                if($detail['miejscowosc'] != null){
                    echo '<p><span class="user-info1">Miejscowość:</span><span class="user-info2">'.$detail['miejscowosc'].'</span></p>';
                } else {
                    echo '<p><span class="user-info1">Miejscowość:</span><span class="user-info2">Brak informacji</span></p>';
                }
                function userAge($userAge){
                    $now = date('Y');
                    $userAge = $now - $userAge;
                    return $userAge;
                }
                echo '<p><span class="user-info1">Wiek:</span><span class="user-info2">'.userAge($detail['urodzony']).'</span></p>';
            ?>
        </div>
        <div class="user-games-info">
            <?php
                $howManyGames = $connection->query("SELECT count(*) AS allgames FROM users_library WHERE id_user = {$_SESSION['id']} AND have = 'yes'");
                $allGames = $howManyGames->fetch_assoc();
                echo '<p><span class="user-info1">Gier w kolekcji:</span><span class="user-info2">'.$allGames['allgames'].'</span></p>';
                $allFinishGames = $connection->query("SELECT count(*) AS allfinishgames, sum(finish_game_h) AS sumHour, sum(finish_game_m) AS sumMin FROM users_library WHERE id_user = {$_SESSION['id']} AND finish = 'yes'");
                $endGames = $allFinishGames->fetch_assoc();
                echo '<p><span class="user-info1">Ukończonych gier:</span><span class="user-info2">'.$endGames['allfinishgames'].'</span></p>';
                $sumGodz = $endGames['sumHour'];
                $sumMin = $endGames['sumMin'];
                
                $allSec = ($sumGodz * 3600) + ($sumMin * 60);
                
                $allDay = $allSec / 86400;
                $allDay2 = floor($allDay);
                
                $allGodz = ($allSec % 86400) / 3600;
                $allGodz2 = floor($allGodz);
                
                $allMin = ($allSec % 3600) / 60;
                echo '<div><div class="user-info1">Łączny czas w grach:</div><div class="user-info2"><span class="play-time">'.$allDay2.'</span><span>Dni</span><span class="play-time">'.$allGodz2.'</span><span>Godz</span><span class="play-time">'.$allMin.'</span><span>Min</span></div></div>';
            ?>
        </div>
        <a href="index.php?action=editprofile" class="edit-profile-btn">Edytuj profil</a>
    </div>
</div>
<article class="user-description-text">
    <?php
        echo '<p>'.$detail['opis'].'</p>';
    ?>
</article>
<div class="my-games-conteiner">
    <div class="last-add-games">
        <h3>Ostatnio dodane do kolekcji</h3>
        <?php
            echo '<a href="index.php?action=mycollection&amp;page=1" class="see-all">(Zobacz wszystkie)</a>';
            $myGameCollection = $connection->query("SELECT games.id_games, games.tytul, games.cover, users_library.game_platform, users_library.game_pc_platform FROM games, users_library WHERE games.id_games = users_library.id_game AND users_library.id_user = {$_SESSION['id']} AND have = 'yes' ORDER BY users_library.id_library DESC LIMIT 3");
            
        ?>
        <ul>
            <?php
                while($lastAddCollection = $myGameCollection->fetch_assoc()){
                    echo '<li><a href="index.php?action=gamedetail&id='.$lastAddCollection['id_games'].'"><img src="db/covers/'.$lastAddCollection['cover'].'"><span>'.$lastAddCollection['tytul'].'</span><span>'.$lastAddCollection['game_platform'].'</span><span>'.$lastAddCollection['game_pc_platform'].'</span></a></li>';
                }
                
            ?>
        </ul>
    </div>
    <div class="last-add-games">
        <?php
            if ($detail['plec'] == 'Kobieta'){
                echo '<h3>Gry, w które grałaś najdłużej</h3>';
            } else {
                echo '<h3>Gry, w które grałeś najdłużej</h3>';
            }
        
            echo '<a href="index.php?action=playedgames&amp;page=1" class="see-all">(Zobacz wszystkie)</a>';
            $myPlayedGames = $connection->query("SELECT games.id_games, games.tytul, games.cover, users_library.rating, users_library.finish_game_h, users_library.finish_game_m FROM games, users_library WHERE games.id_games = users_library.id_game AND users_library.id_user = {$_SESSION['id']} AND finish = 'yes' ORDER BY users_library.finish_game_h DESC LIMIT 3");
        ?>

        <ul>
            <?php
                while($lastPlayed = $myPlayedGames->fetch_assoc()){
                    echo '<li><a href="index.php?action=gamedetail&id='.$lastPlayed['id_games'].'"><img src="db/covers/'.$lastPlayed['cover'].'"><span>'.$lastPlayed['tytul'].'</span><span>Ocena: '.$lastPlayed['rating'].'</span><span>Czas gry: '.$lastPlayed['finish_game_h'].':'.$lastPlayed['finish_game_m'].'</span></a></li>';
                }
                
            ?>
        </ul>
    </div>
</div>