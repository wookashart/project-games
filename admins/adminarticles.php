<?php

    if((!isset($_SESSION['useronline'])) || ((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true) && ($_SESSION['user_type'] == 'user'))){
        header('Location: ../index.php');
        exit();
    }

?>
<div class="new-articles-administrator">
    <h2>Dodaj nowy artykuł</h2>
    <?= $_SESSION['articlealert'] ?>
    <form method="POST" action="../php/newarticle.php">
        <label class="article-title">
            <span>Tytuł</span>
            <input type="text" name="article-title">
        </label>
        <label class="article-header">
            <span>Nagłówek</span>
            <textarea name="article-header"></textarea>
        </label>
        <label class="article-content">
            <span>Treść</span>
            <textarea name="article-content"></textarea>
        </label>
        <input type="submit">
    </form>
</div>

<?php $_SESSION['articlealert'] = ''; ?>