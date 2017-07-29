<div class="games-list">
    <h1>Biblioteka gier</h1>
    <?php

        $allGames = $connection->query("SELECT id_games, tytul, platforma FROM games ORDER BY tytul ASC");

    ?>

    <ul>
        <?php

        while ($row = $allGames->fetch_assoc()) {
            echo '<li class="games-list-item"><a href="index.php?action=gamedetail&id='.$row['id_games'].'">'.$row['tytul'].'</a><span>'.$row['platforma'].'</span><span>Ocena: (w budowie)</span></li>';
        }

        ?>

    </ul>
</div>