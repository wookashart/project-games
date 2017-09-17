<?php
        
    $count = $connection->query("SELECT count(article_id) AS cnt FROM articles");
    $cnt = $count->fetch_assoc();

    $page = isset($_GET['page']) ? intval($_GET['page'] - 1) : 1;
    $limit = 10;
    $from = $page * $limit;
    $allPage = ceil($cnt['cnt'] / $limit);

    $articleConnect = $connection->query("SELECT * FROM articles ORDER BY article_id DESC LIMIT $from , $limit");

?>

<div class="articles-list">
    <h1>Wiadomości</h1>
    <ul>
        <?php

            while( $article = $articleConnect->fetch_assoc() ) {
    
                echo '<li><h3>'.$article['article_title'].'</h3><div class="article-date">'.$article['article_date'].'</div><div class="article-header">'.$article['article_header'].'</div><div class="read-more"><a href="index.php?action=article&amp;id='.$article['article_id'].'">Czytaj więcej</a></div></li>';
                
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

            echo '<a href="index.php?action=articles&page=1"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a>';

            if($page == 0){
                echo '<a href="index.php?action=articles&page=1"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            } else {
                echo '<a href="index.php?action=articles&page='.$prevPage.'"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            }
            
            for($i = 1; $i <= $allPage; $i++) {

                $bold = ($i == ($page + 1)) ? 'class="active-page"' : '';            

                if(countPages($i, ($page - 2), ($page + 4))) {
                    echo '<a href="index.php?action=articles&page='.$i.'"'.$bold.'>'.$i.'</a>';
                }
            }

            if($page == $allPage -1 ){
                echo '<a href="index.php?action=articles&page='.$allPage.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';    
            } else {
                echo '<a href="index.php?action=articles&page='.$nextPage.'"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
            }
            
            echo '<a href="index.php?action=articles&page='.$allPage.'"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>';

        ?>
    </div>
</div>