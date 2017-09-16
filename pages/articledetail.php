<?php

    $articlesConnect = $connection->query("SELECT * FROM articles WHERE article_id = {$_GET['id']}");
    $article = $articlesConnect->fetch_assoc();

?>
<div class="article-detail">
    <h1><?= $article['article_title'] ?></h1>
    <div class="article-detail-date"><?= $article['article_date'] ?></div>
    <div class="article-detail-author"><?= $article['article_author'] ?></div>
    <div class="article-detail-content">
        <div><?= $article['article_header'] ?></div>
        <div><?= $article['article_content'] ?></div>
    </div>
</div>
