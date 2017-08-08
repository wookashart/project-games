<!-- <h1>Strona główna</h1> -->
<section class="last-add-game">
    <h3>Ostatnio dodana gra</h3>
    <?php

        $allGames = $connection->query("SELECT id_games, tytul, platforma, gatunek, cover FROM games ORDER BY data_dodania DESC LIMIT 1");

        
        while ($row = $allGames->fetch_assoc()) {
            echo '<div class="last-add-game-cover"><a href="index.php?action=gamedetail&id='.$row['id_games'].'"><img src="db/covers/'.$row['cover'].'"></a></div><div class="last-add-game-info"><h4>'.$row['tytul'].'</h4><div class="last-add-game-platform">'.$row['platforma'].'</div><div class="last-add-game-type">'.$row['gatunek'].'</div></div>';
        }

    ?>

    
</section>