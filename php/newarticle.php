<?php

    session_start();

    if((!isset($_SESSION['useronline'])) || ((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true) && ($_SESSION['user_type'] == 'user'))){
        header('Location: ../index.php');
        exit();
    }

    require_once "../db/connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    $usersConnect = $connection->query("SELECT * FROM users WHERE id = {$_SESSION['id']}");
    $user = $usersConnect->fetch_assoc();

    $title = addslashes($_POST['article-title']);
    $header = addslashes($_POST['article-header']);
    $content = addslashes($_POST['article-content']);
    $date = date('Y-m-d');
    $author = $user['login'];

    if($connection->connect_errno != 0){
        $_SESSION['articlealert'] = '<div class="error">Nie udało się dodać artykułu. Spróbuj ponownie za chwilę</div>';
        header('Location: ../admins/admins.php?id=addarticle');
        exit();

    } else {
        $_SESSION['articlealert'] = '<div class="error">Artykuł dodany. Możesz dodać kolejny</div>';
        $articleConnect = $connection->query("INSERT INTO articles VALUES (NULL, '$title', '$header', '$content', '$date', '$author')");
        header('Location: ../admins/admins.php?id=addarticle');
        exit();
    }
?>