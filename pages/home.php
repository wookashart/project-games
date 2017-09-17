<!-- <h1>Strona główna</h1> -->
<section class="last-articles">
    <h3>Najnowsze wiadomości</h3>
    <div class="last-articles-container">
        <ul class="last-articles-slider">
        <?php

            $articlesConnect = $connection->query("SELECT * FROM articles ORDER BY article_id LIMIT 5");
            
            while ( $article = $articlesConnect->fetch_assoc() ){
                echo '<li class="articles-list-item"><div><h2>'.$article['article_title'].'</h2><div class="article-date">'.$article['article_date'].'</div><div class="article-header">'.$article['article_header'].'</div><div class="article-read-more"><a href="index.php?action=article&amp;id='.$article['article_id'].'">Czytaj więcej</a></div></div></li>';
            }

        ?>
        </ul>
    </div>
</section>
<section class="last-add-game">
    <h3>Ostatnio dodana gra</h3>
    <?php

        $allGames = $connection->query("SELECT id_games, tytul, platforma, gatunek, cover FROM games ORDER BY data_dodania DESC LIMIT 1");

        
        while ($row = $allGames->fetch_assoc()) {
            echo '<div class="last-add-game-cover"><a href="index.php?action=gamedetail&id='.$row['id_games'].'">';
            
            if($row['cover'] != null){
                echo '<img src="db/covers/'.$row['cover'].'">';
            } else {
                echo '<img src="img/no-cover.png">';
            }
            
            echo '</a></div><div class="last-add-game-info"><h4>'.$row['tytul'].'</h4><div class="last-add-game-platform">'.$row['platforma'].'</div><div class="last-add-game-type">'.$row['gatunek'].'</div></div>';
        }

    ?>
</section>