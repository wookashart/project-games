<?php

    session_start();

    if((!isset($_SESSION['useronline'])) || ((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true) && ($_SESSION['user_type'] == 'user'))){
        header('Location: ../index.php');
        exit();
    }

    $dlcGame = $_POST['dlc-game'];
    $dlcTitle = addslashes($_POST['dlc-title']);
    $dlcTitlePl = addslashes($_POST['dlc-title-pl']);
    $dlcPlatform = implode(' / ', $_POST['dlc-platform']);
    $dlcDateWorld = $_POST['dlc-date-world'];
    $dlcDatePl = $_POST['dlc-date-pl'];
    $dlcDescription = addslashes($_POST['dlc-description']);

    $targetDir = "../db/covers_dlc/";
    $targetFile = $targetDir.basename($_FILES['dlc-cover']["name"]);
    $uploadOk = true;
    $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);

    if(isset($_POST['submit'])){
        $check = getimagesize($_FILES['dlc-cover']['tmp_name']);

        if($check !== false){
            $uploadOk = true;
        } else {
            $uploadOk = false;
        }
    }

    if($uploadOk == true){
        move_uploaded_file($_FILES['dlc-cover']['tmp_name'], $targetFile);
    }

    $addCover = $_FILES['dlc-cover']["name"];

    require_once "../db/connect.php";
    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0){
        
        $_SESSION['addalert'] = '<div class="error">Nie udało się dodać DLC do bazy. Spróbuj ponownie.</div>';
        header('Location: ../admins/admins.php?id=adddlc');
        exit();

    } else {

        $gameConnect = $connection->query("SELECT * FROM dlc WHERE dlc_name = '$dlcTitle'");
        $gamesCount = $gameConnect->num_rows;

        if ($gamesCount > 0){
            $_SESSION['addalert'] = '<div class="error">To DLC już jest w bazie!</div>';
            header('Location: ../admins/admins.php?id=adddlc');
            exit();
        } else {
            $addresoult = $connection->query("INSERT INTO dlc VALUES (NULL, '$dlcGame', '$dlcTitle', '$dlcTitlePl', '$dlcPlatform', '$dlcDateWorld', '$dlcDatePl', '$dlcDescription', '$addCover')");
            $_SESSION['addalert'] = '<div class="error">DLC pomyślnie dodane do bazy.</div>';
            header('Location: ../admins/admins.php?id=adddlc');
            exit();    
        }   
    }

    $connection->close();

?>