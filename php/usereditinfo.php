<?php

    session_start();
    require_once "../db/connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    $sex = $_POST['change-sex'];
    $place = addslashes($_POST['change-place']);
    $date = $_POST['change-birth'];
    $email = addslashes($_POST['change-email']);
    $description = addslashes($_POST['change-description']);

    if($date == null){
        $date = date('Y-m-d');
    } 
        
    $updateInfo = $connection->query("UPDATE users SET email = '$email', plec = '$sex', miejscowosc = '$place', urodzony = '$date', opis = '$description' WHERE id = {$_SESSION['id']}");

    header('Location: ../index.php?action=editprofile');
    exit();

    $connection->close();

?>