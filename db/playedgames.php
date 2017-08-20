<?php

    session_start();

    require_once "connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    $score = $_POST['played-slider'];
    $gameHour = $_POST['played-hour'];
    $gameMinut = $_POST['played-minut'];
    $idGame = $_SESSION['gameId'];
    $idUser = $_SESSION['id'];

    if ($gameHour != null) {
        $gameHour = $_POST['played-hour'];
    } else {
        $gameHour = 0;
    }

    if ($gameHour != null) {
        $gameMinut = $_POST['played-minut'];
    } else {
        $gameMinut = 0;
    }


    if(isset($connection)) {

        if ($scoreGame = $connection->query("SELECT * FROM finish_games WHERE id_gracza = $idUser AND id_gry = $idGame")){
            $alredyScore = $scoreGame->num_rows;

            if($alredyScore == 0){
                $addScoreGame = $connection->query("INSERT INTO finish_games VALUES (NULL, '$idGame', '$score', '$gameHour', '$gameMinut', '$idUser')");    
                header('Location: ../index.php?action=gamedetail&id='.$idGame);
                exit();

            } else {
                header('Location: ../index.php?action=gamedetail&id='.$idGame);
                exit();
            }
        }
    } else {
        $_SESSION['connect-error'] = 'Przepraszamy, nie można w tej chwili nawiązać połączenia z bazą. Spróbuj za chwilę.';
    }



    $connection->close();

?>