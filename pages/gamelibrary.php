<?php
        
    $count = $connection->query("SELECT count(id_games) AS cnt FROM games");
    $cnt = $count->fetch_assoc();

    $page = isset($_GET['page']) ? intval($_GET['page'] - 1) : 1;
    $limit = 20;
    $from = $page * $limit;
    $allPage = ceil($cnt['cnt'] / $limit);

    $allGames = $connection->query("SELECT * FROM games ORDER BY tytul ASC LIMIT $from , $limit");

?>

<div class="games-list">
    <h1>Biblioteka gier</h1>
    <div class="all-rows-sum">
        <span>(Łączna ilość gier:</span>
        <span><?= $cnt['cnt'] ?>)</span>
    </div>
    <ul>
        <?php

            while( $row = $allGames->fetch_assoc() ) {
                
                $playersScore = $connection->query("SELECT sum(rating) AS sumScore, count(rating) AS allPosition FROM users_library WHERE id_game = {$row['id_games']}");
                $allScore = $playersScore->fetch_assoc();
            
                if ($allScore['sumScore'] != 0 && $allScore['allPosition'] != 0){
                    $playersAverage = $allScore['sumScore'] / $allScore['allPosition'];
                } else {
                    $playersAverage = 'brak';
                }
    
                echo '<li class="games-list-item"><div class="hover-cover"><img src="db/covers/'.$row['cover'].'" /></div><a href="index.php?action=gamedetail&id='.$row['id_games'].'"><span class="game-title">'.$row['tytul'].'</span><div class="library-list-information"><span>'.$row['platforma'].'</span><span>'.$playersAverage.'</span></div></a></li>';
                
            }

        ?>
    </ul>
    <div class="pagination-nav-bar">
        <?php

            function countPages($val, $min, $max){
                return ($val >= $min && $val <= $max);
            }

            $nextPage = $page +2;
            $prevPage = $page;

            echo '<a href="index.php?action=gamelibrary&page=1"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>';

            if($page == 0){
                echo '<a href="index.php?action=gamelibrary&page=1"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            } else {
                echo '<a href="index.php?action=gamelibrary&page='.$prevPage.'"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            }
            
            for($i = 1; $i <= $allPage; $i++) {

                $bold = ($i == ($page + 1)) ? 'class="active-page"' : '';            

                if(countPages($i, ($page - 2), ($page + 4))) {
                    echo '<a href="index.php?action=gamelibrary&page='.$i.'"'.$bold.'>'.$i.'</a>';
                }
            }

            if($page == $allPage -1 ){
                echo '<a href="index.php?action=gamelibrary&page='.$allPage.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';    
            } else {
                echo '<a href="index.php?action=gamelibrary&page='.$nextPage.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
            }
            
            echo '<a href="index.php?action=gamelibrary&page='.$allPage.'"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>';

        ?>
    </div>
</div>