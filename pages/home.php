<div class="home-page">
    <div class="main-content">
        <section class="last-articles">
            <h3>Najnowsze wiadomości</h3>
            <div class="last-articles-container">
                <ul class="last-articles-slider">
                <?php

                    $articlesConnect = $connection->query("SELECT * FROM articles ORDER BY article_id LIMIT 5");
                    
                    while ( $article = $articlesConnect->fetch_assoc() ){
                        echo '<li class="articles-list-item"><div><h2>'.$article['article_title'].'</h2><div class="article-date">'.$article['article_date'].'</div><div class="article-header">'.$article['article_header'].'</div><div class="article-read-more"><a href="index.php?action=article&amp;id='.$article['article_id'].'" title="'.$article['article_title'].'">Czytaj więcej</a></div></div></li>';
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
    </div>
    <aside>
        <div class="top-list-container">
            <h3>Top 10 gier</h3>
            <ul class="players-top-game-list">
                <?php

                    $ratingGamesConnect = $connection->query("SELECT id_game, avg(rating) AS average FROM users_library GROUP BY id_game ORDER BY average DESC LIMIT 10");

                    $i = 0;

                    function cutTitle($title, $letters){ 
                        $titleLength = strlen($title); 

                        if ($titleLength >= $letters){ 

                            $cut = substr($title, 0, $letters); 
                            $txt = $cut."..."; 
                        } else { 
                            $txt = $title; 
                        } 
                        return $txt; 
                    } 

                    while( $rating = $ratingGamesConnect->fetch_assoc() ) {
                        $gameRate = round($rating['average'], 1);
                        $i = $i + 1;
                        
                        $gameConnect = $connection->query("SELECT * FROM games WHERE id_games = {$rating['id_game']}");
                        $game = $gameConnect->fetch_assoc();

                        echo '<li class="top-list-element"><a href="index.php?action=gamedetail&id='.$game['id_games'].'" title="'.$game['tytul'].'"><div class="list-number">'.$i.'</div><div class="game-cover"><img src="db/covers/'.$game['cover'].'"></div><div class="game-info"><div class="game-title">';
                        
                        $title = $game['tytul']; 
                        $letters = 32; 

                        echo cutTitle($title, $letters); 
                        
                        echo '</div><div class="players-average">'.$gameRate.'</div></div></a></li>';
                
                    }

                ?>
            </ul>
        </div>
    </aside>
</div>