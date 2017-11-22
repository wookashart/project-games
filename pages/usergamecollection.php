<?php
    $count = $connection->query("SELECT count(id_game) AS cnt FROM users_library WHERE id_user = {$_SESSION['id']} AND have = 'yes'");
    $cnt = $count->fetch_assoc();
    $page = isset($_GET['page']) ? intval($_GET['page'] - 1) : 1;
    $limit = 20;
    $from = $page * $limit;
    $allPage = ceil($cnt['cnt'] / $limit);
    $myGameCollection = $connection->query("SELECT games.id_games, games.tytul, games.cover, games.platforma, users_library.game_platform, users_library.game_pc_platform, users_library.finish FROM games, users_library WHERE games.id_games = users_library.id_game AND users_library.id_user = {$_SESSION['id']} AND have = 'yes' ORDER BY games.tytul ASC LIMIT $from , $limit");
  
    $myGameCollFinish = $connection->query("SELECT count(*) AS myFinish FROM users_library WHERE finish = 'yes' AND have = 'yes'");
    $allFinish = $myGameCollFinish->fetch_assoc();
  
    $finishProc = floor(($allFinish['myFinish'] * 100) / $cnt['cnt']);
?>

<div class="user-game-collection">
<h3>Gier w kolekcji: <?= $cnt['cnt'] ?></h3>
<p class="have-and-finish"><span>W tym ukończonych: <?= $allFinish['myFinish'] ?></span><span> (<?= $finishProc ?>%)</span></p>
<ul>
            <?php
                
                while($game = $myGameCollection->fetch_assoc()){
                    if($game['finish'] == 'yes'){
                        $played = 'played-game';
                    } else {
                        $played = 'not-played-game';
                    }
                    echo '<li class="collection-game '.$game['id_games'].' '.$played.'"><a href="index.php?action=gamedetail&id='.$game['id_games'].'"><img src="db/covers/'.$game['cover'].'"><div class="collect-game-title">'.$game['tytul'].'</div><div class="collection-platform"><span>'.$game['game_platform'].'</span><span>('.$game['game_pc_platform'].')</span></div></a><div class="collection-delete"><button title="Usuń grę" onclick="removeGameFromCollection('.$game['id_games'].')"></button></div><div class="collection-delete-modal"><div class="collection-delete-content"><h2>Czy na pewno chcesz usunąć &quot'.$game['tytul'].'&quot z kolekcji?</h2><button class="base-btn" onclick="acceptRemoveFromCollection('.$game['id_games'].')">Tak</button><button class="base-btn collection-delete-reject">Nie</button></div></div></li>';
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
            echo '<a href="index.php?action=mycollection&amp;page=1"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>';
            if($page == 0){
                echo '<a href="index.php?action=mycollection&amp;page=1"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            } else {
                echo '<a href=index.php?action=mycollection&amp;page='.$prevPage.'"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            }
            
            for($i = 1; $i <= $allPage; $i++) {
                $bold = ($i == ($page + 1)) ? 'class="active-page"' : '';            
                if(countPages($i, ($page - 2), ($page + 4))) {
                    echo '<a href="index.php?action=mycollection&amp;page='.$i.'"'.$bold.'>'.$i.'</a>';
                }
            }
            if($page == $allPage -1 ){
                echo '<a href="index.php?action=mycollection&amp;page='.$allPage.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';    
            } else {
                echo '<a href="index.php?action=mycollection&amp;page='.$nextPage.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
            }
            
            echo '<a href="index.php?action=mycollection&amp;page='.$allPage.'"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>';
        ?>
    </div>
</div>