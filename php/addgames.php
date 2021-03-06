<?php

    session_start();

    if((!isset($_SESSION['useronline'])) || ((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true) && ($_SESSION['user_type'] == 'user'))){
        header('Location: ../index.php');
        exit();
    }

    $gameTitle = addslashes($_POST['game-title']);
    $gameTitlePl = addslashes($_POST['game-title-pl']);
    $gamePlatform = implode(' / ', $_POST['game-platform']);
    $gameDateWorld = $_POST['game-date-world'];
    $gameDatePl = $_POST['game-date-pl'];
    $gameType = implode(' / ', $_POST['game-type']);
    $gameProducer = addslashes($_POST['game-producer']);
    $gamePublisher = addslashes($_POST['game-publisher']);
    $gameDistributor = addslashes($_POST['game-distributor']);
    $gameDescription = addslashes($_POST['game-description']);
    $gameProcessor = $_POST['game-processor'];
    $gameGraphic = $_POST['game-graphic'];
    $gameRam = $_POST['game-ram'];
    $gameSystem = $_POST['game-system'];
    $gameDirectx = $_POST['game-directx'];
    $gameSpace = $_POST['game-space'];
    $addDate = date('Y-m-d H:i:s');

    // upload cover
    $targetDir = "../db/covers/";
    $targetFile = $targetDir.basename($_FILES['game-cover']["name"]);
    $uploadOk = true;
    $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);

    if(isset($_POST['submit'])){
        $check = getimagesize($_FILES['game-cover']['tmp_name']);

        if($check !== false){
            $uploadOk = true;
        } else {
            $uploadOk = false;
        }
    }

    if($uploadOk == true){
        move_uploaded_file($_FILES['game-cover']['tmp_name'], $targetFile);
    }

    $addCover = $_FILES['game-cover']["name"];


    require_once "../db/connect.php";

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    if($connection->connect_errno!=0){

        $_SESSION['addalert'] = '<div class="error">Nie udało się dodać gry do bazy. Spróbuj ponownie.</div>';
        header('Location: ../admins/admins.php?id=addgame');
        exit();

    } else {

        $gameConnect = $connection->query("SELECT * FROM games WHERE tytul = '$gameTitle'");
        $gamesCount = $gameConnect->num_rows;

        if ($gamesCount > 0){
            $_SESSION['addalert'] = '<div class="error">Ta gra już jest w bazie!</div>';
            header('Location: ../admins/admins.php?id=addgame');
            exit();
        } else {
            $addresoult = $connection->query("INSERT INTO games VALUES (NULL, '$gameTitle', '$gameTitlePl', '$gamePlatform', '$gameDateWorld', '$gameDatePl', '$gameType', '$gameProducer', '$gamePublisher', '$gameDistributor', '$gameDescription', '$gameProcessor', '$gameGraphic', '$gameRam', '$gameSystem', '$gameDirectx', '$gameSpace', '$addDate', '$addCover')");
            $_SESSION['addalert'] = '<div class="error">Gra pomyślnie dodana do bazy.</div>';
            header('Location: ../admins/admins.php?id=addgame');
            exit();    
        }   
    }
    
    $connection->close();

?>
