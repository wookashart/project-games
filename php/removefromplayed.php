<?php
  
    session_start();
    require_once "../db/connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    $idUser = $_SESSION['id'];
    $idGame = $_POST['idGame'];

    $con = $connection->query("UPDATE users_library SET finish = 'no', finish_game_min = '0', rating = '0' WHERE id_user = $idUser AND id_game = $idGame");

?>