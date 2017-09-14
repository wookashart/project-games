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

    $userInfo = $connection->query("SELECT * FROM users WHERE email = '$email' AND id != {$_SESSION['id']}");
    $info = $userInfo->num_rows;

    if($info > 0){
        $_SESSION['emailerr'] = '<div class="img-error">Ten mail jest już zajęty przez innego użytkownika</div>';
        header('Location: ../index.php?action=editprofile');
        exit();

    } else {

        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        if((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)){
            $_SESSION['emailerr'] = '<div class="img-error">Podaj poprawny email</div>';
            header('Location: ../index.php?action=editprofile');
            exit();
        }

        $updateInfo = $connection->query("UPDATE users SET email = '$email', plec = '$sex', miejscowosc = '$place', urodzony = '$date', opis = '$description' WHERE id = {$_SESSION['id']}");
        header('Location: ../index.php?action=editprofile');
        exit();
    }
        
    $connection->close();

?>