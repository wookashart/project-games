<?php

    session_start();

    require_once "./db/connect.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if($polaczenie->connect_errno!=0)
    {
        echo "Error: ".$polaczenie->connect_errno;
    }
    else
    {
        $login = $_POST['login'];
		$haslo = $_POST['haslo'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");
        

        if ($rezultat = @$polaczenie->query(
            sprintf("SELECT * FROM users WHERE login='%s'", mysqli_real_escape_string($polaczenie, $login))))
        {
            $ilu_userow = $rezultat->num_rows;
            if($ilu_userow>0)
            {
                
                $wiersz = $rezultat->fetch_assoc();

                if(password_verify($haslo, $wiersz['password'])){

                    $_SESSION['useronline'] = true;
                    $_SESSION['id'] = $wiersz['id'];
                    $_SESSION['login'] = $wiersz['login'];
                    $_SESSION['user_type'] = $wiersz['konto'];

                    unset($_SESSION['blad']);
                    $rezultat->free_result();

                    header('Location: index.php');
                } else {
                    $_SESSION['blad'] = '<span style="color:red>Nieprawidłowy login lub hasło</span>';
                }
            }
            else {
                $_SESSION['blad'] = '<span style="color:red>Nieprawidłowy login lub hasło</span>';
            }
        }

        $polaczenie->close();
    }

?>