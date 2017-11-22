<div class="home-page">
    <div class="main-content">
        <section class="last-articles">
            <h3>Najnowsze wiadomości</h3>
            <div class="last-articles-container">
                <ul class="last-articles-slider">
                <?php

                    $articlesConnect = $connection->query("SELECT * FROM articles ORDER BY article_id DESC LIMIT 5");
                    
                    while ( $article = $articlesConnect->fetch_assoc() ){
                        echo '<li class="articles-list-item"><div><h2>'.$article['article_title'].'</h2><div class="article-date">'.$article['article_date'].'</div><div class="article-header">'.$article['article_header'].'</div><div class="article-read-more"><a href="index.php?action=article&amp;id='.$article['article_id'].'" title="'.$article['article_title'].'">Czytaj więcej</a></div></div></li>';
                    }

                ?>
                </ul>
            </div>
        </section>
        <section class="last-tutorials">
            <h3>Najnowsze poradniki</h3>
            <div class="last-tut-container">
                <ul>
            <?php

                $tutConnect = $connection->query("SELECT games.*, tutorials.* FROM games, tutorials WHERE tutorials.tut_game_id = games.id_games ORDER BY tutorials.tut_id DESC LIMIT 3");

                while($tut = $tutConnect->fetch_assoc()){
                    echo '<li><div><h2>'.$tut['tytul'].' - '.$tut['tut_title'].'</h2><div class="tut-date">'.$tut['tut_date'].'</div><div class="tut-info"><div><img src="db/covers/'.$tut['cover'].'"></div><div class="tut-header">'.$tut['tut_header'].'</div></div><div class="tut-read-game"><a href="index.php?action=gamedetail&amp;id='.$tut['id_games'].'">Poczytaj o grze</a></div><div class="tut-read-more"><a href="index.php?action=tutorial&amp;id='.$tut['tut_id'].'">Przeczytaj poradnik</a></div></div></li>';
                }

            ?>
                </ul>
            </div>
        </section>
        <section class="last-add-game">
            <h3>Ostatnio dodane gry</h3>
            <div class="last-add-game-container">
            <?php

                $allGames = $connection->query("SELECT id_games, tytul, platforma, gatunek, cover FROM games ORDER BY data_dodania DESC LIMIT 3");

                
                while ($row = $allGames->fetch_assoc()) {
                    echo '<div class="last-add-game-item"><div class="last-add-game-cover"><a href="index.php?action=gamedetail&id='.$row['id_games'].'">';
                    
                    if($row['cover'] != null){
                        echo '<img src="db/covers/'.$row['cover'].'">';
                    } else {
                        echo '<img src="img/no-cover.png">';
                    }
                    
                    echo '</a></div><div class="last-add-game-info"><h4>'.$row['tytul'].'</h4><div class="last-add-game-platform">'.$row['platforma'].'</div><div class="last-add-game-type">'.$row['gatunek'].'</div></div></div>';
                }

            ?>
            </div>
        </section>
        <section class="last-add-game">
            <h3>Ostatnio dodane DLC</h3>
            <div class="last-add-game-container">
            <?php

                $allGames = $connection->query("SELECT * FROM dlc, games WHERE games.id_games = dlc.id_game ORDER BY dlc.id_dlc DESC LIMIT 3");

                
                while ($row = $allGames->fetch_assoc()) {
                    echo '<div class="last-add-game-item"><div class="last-add-game-cover"><a href="index.php?action=dlc&id='.$row['id_dlc'].'">';
                    
                    if($row['dlc_cover'] != null){
                        echo '<img src="db/covers_dlc/'.$row['dlc_cover'].'">';
                    } else {
                        echo '<img src="img/no-cover.png">';
                    }
                    
                    echo '</a></div><div class="last-add-game-info"><h4>'.$row['tytul'].' - '.$row['dlc_name'].'</h4><div class="last-add-game-platform">'.$row['dlc_platform'].'</div></div></div>';
                }

            ?>
            </div>
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