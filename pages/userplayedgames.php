<?php
$count = $connection->query("SELECT count(id_game) AS cnt FROM users_library WHERE id_user = {$_SESSION['id']} AND finish = 'yes'");
$cnt = $count->fetch_assoc();
$page = isset($_GET['page']) ? intval($_GET['page'] - 1) : 1;
$limit = 20;
$from = $page * $limit;
$allPage = ceil($cnt['cnt'] / $limit);
$allGames = $connection->query("SELECT * FROM games, users_library WHERE games.id_games = users_library.id_game AND users_library.id_user = {$_SESSION['id']} AND finish = 'yes' ORDER BY tytul ASC LIMIT $from , $limit");
?>
<div class="user-played-games">
    <h3>Ukończonych gier : <?= $cnt['cnt'] ?></h3>
    <ul>
    <?php
            while( $row = $allGames->fetch_assoc() ) {
    
                echo '<li class="played-game-item"><a href="index.php?action=gamedetail&id='.$row['id_games'].'"><img src="db/covers/'.$row['cover'].'"><div>'.$row['tytul'].'</div><div><span>Czas gry:</span><span>'.$row['finish_game_h'].'godz '.$row['finish_game_m'].' min</span></div><div><span>Moja ocena:</span><span>'.$row['rating'].'</span></div></a></li>';
                
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
            echo '<a href="index.php?action=playedgames&amp;page=1"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>';
            if($page == 0){
                echo '<a href="index.php?action=playedgames&amp;page=1"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            } else {
                echo '<a href=index.php?action=playedgames&amp;page='.$prevPage.'"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            }
            
            for($i = 1; $i <= $allPage; $i++) {
                $bold = ($i == ($page + 1)) ? 'class="active-page"' : '';            
                if(countPages($i, ($page - 2), ($page + 4))) {
                    echo '<a href="index.php?action=playedgames&amp;page='.$i.'"'.$bold.'>'.$i.'</a>';
                }
            }
            if($page == $allPage -1 ){
                echo '<a href="index.php?action=playedgames&amp;page='.$allPage.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';    
            } else {
                echo '<a href="index.php?action=playedgames&amp;page='.$nextPage.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
            }
            
            echo '<a href="index.php?action=playedgames&amp;page='.$allPage.'"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>';
        ?>
    </div>
</div>