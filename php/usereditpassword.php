<?php

session_start();
require_once "../db/connect.php";
$connection = @new mysqli($host, $db_user, $db_password, $db_name);

$userInfo = $connection->query("SELECT * FROM users WHERE id = {$_SESSION['id']}");
$info = $userInfo->fetch_assoc();

$oldPassword = $_POST['old-password'];
$newPassword = $_POST['new-password'];
$newPassword2 = $_POST['new-password-repeate'];

$validation = true;

if(password_verify($oldPassword, $info['password'])){
    
    if((strlen($newPassword) < 8) || (strlen($newPassword) > 20)){
        $_SESSION['passerr'] = '<div class="img-error">Nowe hasło musi posiadać od 8 do 20 znaków</div>';
        header('Location: ../index.php?action=editprofile');
        exit();
    }
    
    if($newPassword != $newPassword2){
        $_SESSION['passerr'] = '<div class="img-error">Hasło potwierdzające musi być takie samo jak nowe hasło</div>';
        header('Location: ../index.php?action=editprofile');
        exit();
    }

    if($validation = true){
        $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateInfo = $connection->query("UPDATE users SET password = '$password_hash' WHERE id = {$_SESSION['id']}");
        header('Location: ../index.php?action=editprofile');
        exit();

    } else {
        header('Location: ../index.php?action=editprofile');
        exit();
    }

} else {
    $_SESSION['passerr'] = '<div class="img-error">Stare hasło niepoprawne</div>';
    header('Location: ../index.php?action=editprofile');
    exit();
}

$connection->close();

?>