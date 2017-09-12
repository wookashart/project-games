<?php

    session_start();

    require_once "../db/connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    $search = addslashes($_GET['search']);

    $count = $connection->query("SELECT count(id_games) AS cnt FROM games WHERE tytul LIKE '%$search%'");
    $cnt = $count->fetch_assoc();

    if ($cnt['cnt'] <= 20){
        header("Location: ../index.php?action=searchgame&search={$search}");   
        exit;
    } else {
        header("Location: ../index.php?action=searchgame&search={$search}&page=1");   
        exit;
    }

    $connection->close();

?>