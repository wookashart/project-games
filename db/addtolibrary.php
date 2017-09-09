<?php

    session_start();

    require_once "connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

    $selectPlatform = $_POST['select-platform'];
    $idGame = $_SESSION['gameId'];
    $idUser = $_SESSION['id'];

    if (!isset($_POST['distribution'])) {
        $selectDistribution = 'brak';
    } else {
        $selectDistribution = $_POST['distribution'];
    }

    if(isset($connection)) {

        if ($haveGame = $connection->query("SELECT * FROM users_library WHERE id_user = $idUser AND id_game = $idGame")){
            $alredyHave = $haveGame->num_rows;

            if($alredyHave == 0){
                $addGameLibr = $connection->query("INSERT INTO users_library VALUES (NULL, '$idUser', '$idGame', '$selectPlatform', '$selectDistribution')");    
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