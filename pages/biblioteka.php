<div class="games-list">
    <h1>Biblioteka gier</h1>
    <?php
        
        $count = $connection->query("SELECT count(id_games) AS cnt FROM games");
        $cnt = $count->fetch_assoc();

        $page = isset($_GET['page']) ? intval($_GET['page'] - 1) : 1;
        $limit = 25;
        $from = $page * $limit;
        $allPage = ceil($cnt['cnt'] / $limit);

        $allGames = $connection->query("SELECT * FROM games ORDER BY tytul ASC LIMIT $from , $limit");
        
        // echo 'ilość wierszy: '.$cnt['cnt'].'<br>';
    ?>

    <ul>
        <?php

            while( $row = $allGames->fetch_assoc() ) {
                
                $playersScore = $connection->query("SELECT sum(ocena) AS sumScore, count(ocena) AS allPosition FROM finish_games WHERE id_gry = {$row['id_games']}");
                $allScore = $playersScore->fetch_assoc();
            
                if ($allScore['sumScore'] != 0 && $allScore['allPosition'] != 0){
                    $playersAverage = $allScore['sumScore'] / $allScore['allPosition'];
                } else {
                    $playersAverage = 'brak';
                }
    
                echo '<li class="games-list-item"><a href="index.php?action=gamedetail&id='.$row['id_games'].'">'.$row['tytul'].'</a><span>'.$row['platforma'].'</span><span>'.$playersAverage.'</span></li>';
                
            }

        ?>
    </ul>
    <?php

        function countPages($val, $min, $max){
            return ($val >= $min && $val <= $max);
        }

        $nextPage = $page +2;
        $prevPage = $page;

        echo '<a href="index.php?action=biblioteka&page=1">Pierwsza str</a>|';

        if($page == 0){
            echo '<a href="index.php?action=biblioteka&page=1">prev</a>|';
        } else {
            echo '<a href="index.php?action=biblioteka&page='.$prevPage.'">prev</a>|';
        }
        
        for($i = 1; $i <= $allPage; $i++) {

            $bold = ($i == ($page + 1)) ? 'style="font-size: 24px;"' : '';            

            if(countPages($i, ($page - 2), ($page + 4))) {
                echo '<a href="index.php?action=biblioteka&page='.$i.'"'.$bold.'>  '.$i.'  </a>|';
            }
        }

        if($page == $allPage -1 ){
            echo '<a href="index.php?action=biblioteka&page='.$allPage.'">next</a>|';    
        } else {
            echo '<a href="index.php?action=biblioteka&page='.$nextPage.'">next</a>|';
        }
        
        echo '<a href="index.php?action=biblioteka&page='.$allPage.'">Ostatnia str</a>|';

    ?>
</div>