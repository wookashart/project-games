<?php

    $count = $connection->query("SELECT count(tut_id) AS cnt FROM tutorials");
    $cnt = $count->fetch_assoc();

    $page = isset($_GET['page']) ? intval($_GET['page'] - 1) : 1;
    $limit = 20;
    $from = $page * $limit;
    $allPage = ceil($cnt['cnt'] / $limit);

    $tutConnect = $connection->query("SELECT tutorials.tut_id, tutorials.tut_header, tutorials.tut_title, tutorials.tut_date, tutorials.tut_author, games.tytul FROM tutorials, games WHERE tutorials.tut_game_id = games.id_games ORDER BY games.tytul ASC LIMIT $from , $limit");


?>
<div class="tutorials-list">
<h1>Poradniki</h1>
<ul>
        <?php

            while( $tut = $tutConnect->fetch_assoc() ) {
                
                echo '<li><a href="index.php?action=tutorial&amp;id='.$tut['tut_id'].'"><span>'.$tut['tytul'].' - '.$tut['tut_title'].'</span></a></li>';
                
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

            echo '<a href="index.php?action=tutorials&page=1"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>';

            if($page == 0){
                echo '<a href="index.php?action=tutorials&page=1"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            } else {
                echo '<a href="index.php?action=tutorials&page='.$prevPage.'"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            }
            
            for($i = 1; $i <= $allPage; $i++) {

                $bold = ($i == ($page + 1)) ? 'class="active-page"' : '';            

                if(countPages($i, ($page - 2), ($page + 4))) {
                    echo '<a href="index.php?action=tutorials&page='.$i.'"'.$bold.'>'.$i.'</a>';
                }
            }

            if($page == $allPage -1 ){
                echo '<a href="index.php?action=tutorials&page='.$allPage.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';    
            } else {
                echo '<a href="index.php?action=tutorials&page='.$nextPage.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
            }
            
            echo '<a href="index.php?action=tutorials&page='.$allPage.'"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>';

        ?>
    </div>
</div>