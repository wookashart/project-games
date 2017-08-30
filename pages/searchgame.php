<?php

    $search = $_GET['search'];
    

    $count = $connection->query("SELECT count(id_games) AS cnt FROM games WHERE tytul LIKE '%$search%'");
    
    
    $cnt = $count->fetch_assoc();

    $page = isset($_GET['page']) ? intval($_GET['page'] - 1) : 1;
    $limit = 20;
    $from = $page * $limit;
    $allPage = ceil($cnt['cnt'] / $limit);

    if($cnt['cnt'] > 20){
        $allGames = $connection->query("SELECT * FROM games WHERE tytul LIKE '%$search%' ORDER BY tytul ASC LIMIT $from , $limit");
    } else {
        $allGames = $connection->query("SELECT * FROM games WHERE tytul LIKE '%$search%' ORDER BY tytul ASC");
    }
    
    

?>
<div class="search-game-list">
    <h3 class="search-result-text">Wyniki wyszukiwania dla: <?= $_GET['search'] ?>, wyszukanych wyników: <?= $cnt['cnt'] ?></h3>
    <div>
        <ul>
            <?php

                if ($cnt['cnt'] > 0) { 
                    while( $row = $allGames->fetch_assoc() ) {
                        
                        $playersScore = $connection->query("SELECT sum(ocena) AS sumScore, count(ocena) AS allPosition FROM finish_games WHERE id_gry = {$row['id_games']}");
                        $allScore = $playersScore->fetch_assoc();

                        if ($allScore['sumScore'] != 0 && $allScore['allPosition'] != 0){
                            $playersAverage = $allScore['sumScore'] / $allScore['allPosition'];
                        } else {
                            $playersAverage = 'brak';
                        }

                        echo '<li class="games-list-item"><a href="index.php?action=gamedetail&id='.$row['id_games'].'"><span>'.$row['tytul'].'</span><div class="library-list-information"><span>'.$row['platforma'].'</span><span>'.$playersAverage.'</span></div></a><div class="hover-cover"><img src="db/covers/'.$row['cover'].'"</div></li>';
                        
                    }
                } else {
                    echo '<p class="search-no-result">Przykro nam, ale nie znaleźliśmy szukanego tytułu</p>';
                }

            ?>
        </ul>
        <div class="pagination-nav-bar">
        <?php
            if ($cnt['cnt'] > 20){

                function countPages($val, $min, $max){
                    return ($val >= $min && $val <= $max);
                }

                $nextPage = $page +2;
                $prevPage = $page;

                echo '<a href="index.php?action=searchgame&search='.$search.'&page=1"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>';

                if($page == 0){
                    echo '<a href="index.php?action=searchgame&search='.$search.'&page=1"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
                } else {
                    echo '<a href="index.php?action=searchgame&search='.$search.'&page='.$prevPage.'"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
                }
                
                for($i = 1; $i <= $allPage; $i++) {

                    $bold = ($i == ($page + 1)) ? 'class="active-page"' : '';            

                    if(countPages($i, ($page - 2), ($page + 4))) {
                        echo '<a href="index.php?action=searchgame&search='.$search.'&page='.$i.'"'.$bold.'>'.$i.'</a>';
                    }
                }

                if($page == $allPage -1 ){
                    echo '<a href="index.php?action=searchgame&search='.$search.'&page='.$allPage.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';    
                } else {
                    echo '<a href="index.php?action=searchgame&search='.$search.'&page='.$nextPage.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
                }
                
                echo '<a href="index.php?action=searchgame&search='.$search.'&page='.$allPage.'"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>';

            }  
        ?>
        </div>
    </div>
</div>