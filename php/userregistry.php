<?php

    session_start();

    if((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true)){
        header('Location: index.php');
        exit();
    } 

    if(isset($_POST['email'])){
        // Udana walidacja
        $validation = true;

        // Sprawdzenie loginu
        $nick = $_POST['nick'];

        // Sprawdzenie długości loginu
        if((strlen($nick)<3) || (strlen($nick)>20)){
            $validation=false;
            $_SESSION['e_nick'] = "Login musi posiadać od 3 do 20 znaków";
            header('Location: ../index.php?action=registration');
            exit();
        }

        if(ctype_alnum($nick) == false){
            $validation = false;
            $_SESSION['e_nick'] = "Login może się składać tylko z liter i cyfr, oraz nie może zawierać polskich znaków";
            header('Location: ../index.php?action=registration');
            exit();
        }

        // Sprawdzanie poprawności email
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        if((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)){
            $validation = false;
            $_SESSION['e_email'] = "Podaj poprawny adres email";
            header('Location: ../index.php?action=registration');
            exit();
        }

        // Sprawdzanie poprawności hasła
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if((strlen($password1)<8) || (strlen($password1)>20)){
            $validation = false;
            $_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków";
            header('Location: ../index.php?action=registration');
            exit();
        }

        if($password1 != $password2){
            $validation = false;
            $_SESSION['e_password'] = "Podane hasła nie są identyczne"; 
            header('Location: ../index.php?action=registration');
            exit();
        }

        $password_hash = password_hash($password1, PASSWORD_DEFAULT);

        // Akceptacja regulaminu

        if(!isset($_POST['regulamin'])){
            $validation = false;
            $_SESSION['e_regulamin'] = "Musisz zaakceptować regulamin"; 
            header('Location: ../index.php?action=registration');
            exit();
        }

        // ReCAPTCHA

        $secret_key = "6LcLmDAUAAAAAOBsDbQYtVjEcocxWOsMIEeAg-0c";
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);

        $response = json_decode($check);

        if($response->success == false){
            $validation = false;
            $_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem"; 
            header('Location: ../index.php?action=registration');
            exit();
        }

        require_once "../db/connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try {
            $connection = @new mysqli($host, $db_user, $db_password, $db_name);
            if($connection->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            } else {
                // Sprawdzenie czy mail jest zarezerwowany
                $result = $connection->query("SELECT id FROM users WHERE email='$email'");

                if(!$result) throw new Exception($connection->error);

                $ile_maili = $result->num_rows;
                if($ile_maili > 0){
                    $validation = false;
                    $_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu email"; 
                    header('Location: ../index.php?action=registration');
                    exit();
                }

                // Sprawdzenie czy login jest zarezerwowany
                $result = $connection->query("SELECT id FROM users WHERE login='$nick'");

                if(!$result) throw new Exception($connection->error);

                $ile_loginow = $result->num_rows;
                if($ile_loginow > 0){
                    $validation = false;
                    $_SESSION['e_nick'] = "Istnieje już konto o takim loginie"; 
                    header('Location: ../index.php?action=registration');
                    exit();
                }
                
                
                // Pola nieobowiązkowe
                $miasto = $_POST['miejscowosc'];
                $data_ur = $_POST['data'];
                $radio_value = $_POST['plec'];

                if(isset($_POST['zgoda'])){
                    $zgoda_marketingowa = "TAK";
                } else {
                    $zgoda_marketingowa = "NIE";
                }
                
                if($validation == true){
                    // Weryfikacja udana
                    if($connection->query("INSERT INTO users VALUES (NULL, '$nick', '$password_hash', 'user', '$email', '$radio_value', '$miasto', '$data_ur', '$zgoda_marketingowa', '', '')")){
                        $_SESSION['udanarejestracja'] = true;
                        header('Location: ../index.php?action=thanksregistery');
                        exit();
                    } else {
                        throw new Exception($connection->error);
                    }
                }
                $connection->close();
            }

        } catch(Exception $e){
            echo '<span style="color:red">Błąd serwera, przepraszamy za niedogodności. Prosimy o rejestrację w późniejszym terminie</span>';
            // echo '<br />Informacja developerska: '.$e;
        } 
    }
    
?>