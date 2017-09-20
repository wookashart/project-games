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

    $tutGame = $_POST['tut-game'];
    $tutTitle = addslashes($_POST['tut-title']);
    $tutHeader = addslashes($_POST['tut-header']);
    $tutContent = addslashes($_POST['tut-content']);
    $tutDate = date('Y-m-d');
    $tutAuthor = $user['login'];

    if($connection->connect_errno != 0){
        $_SESSION['tutalert'] = '<div class="error">Nie udało się dodać poradnika. Spróbuj ponownie za chwilę</div>';
        header('Location: ../admins/admins.php?id=addtutorial');
        exit();

    } else {
        $_SESSION['tutalert'] = '<div class="error">Poradnik dodany. Możesz dodać kolejny</div>';
        $articleConnect = $connection->query("INSERT INTO tutorials VALUES (NULL, '$tutGame', '$tutTitle', '$tutHeader', '$tutContent', '$tutDate', '$tutAuthor')");
        header('Location: ../admins/admins.php?id=addtutorial');
        exit();
    }

?>