<?php

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
        }

        if(ctype_alnum($nick) == false){
            $validation = false;
            $_SESSION['e_nick'] = "Login może się składać tylko z liter i cyfr, oraz nie może zawierać polskich znaków";
        }

        // Sprawdzanie poprawności email
        $email = $_POST['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

        if((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email)){
            $validation = false;
            $_SESSION['e_email'] = "Podaj poprawny adres email";
        }

        // Sprawdzanie poprawności hasła
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if((strlen($password1)<8) || (strlen($password1)>20)){
            $validation = false;
            $_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków";
        }

        if($password1 != $password2){
            $validation = false;
            $_SESSION['e_password'] = "Podane hasła nie są identyczne"; 
        }

        $password_hash = password_hash($password1, PASSWORD_DEFAULT);

        // Akceptacja regulaminu

        if(!isset($_POST['regulamin'])){
            $validation = false;
            $_SESSION['e_regulamin'] = "Musisz zaakceptować regulamin"; 
        }

        // ReCAPTCHA

        $secret_key = "6Ld8HCkUAAAAAMxUrNW4qVg9SvgaHtpYuf3OtJVv";
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);

        $response = json_decode($check);

        if($response->success == false){
            $validation = false;
            $_SESSION['e_bot'] = "Potwierdź, że nie jesteś botem"; 
        }

        require_once "db/connect.php";
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
                }

                // Sprawdzenie czy login jest zarezerwowany
                $result = $connection->query("SELECT id FROM users WHERE login='$nick'");

                if(!$result) throw new Exception($connection->error);

                $ile_loginow = $result->num_rows;
                if($ile_loginow > 0){
                    $validation = false;
                    $_SESSION['e_nick'] = "Istnieje już konto o takim loginie"; 
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
                        header('Location: index.php?action=thanksregistery');
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

<div class="register-new-user">
<h1>Rejestracja</h1>
    <form method="POST">
        <div class="form-line">
            <div class="form-left-column">
                <label>Login *</label>
            </div>
            <div class="form-right-column">
                <input type="text" name="nick">
            </div>
            <?php
                if(isset($_SESSION['e_nick'])){
                    echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
                    unset($_SESSION['e_nick']);
                }
            ?>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label>Płeć</label>
            </div>
            <div class="form-right-column">
                <input type="radio" value="Mężczyzna" name="plec" checked><span>Mężczyzna</span>
            </div>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label></label>
            </div>
            <div class="form-right-column">
                <input type="radio" value="Kobieta" name="plec"><span>Kobieta</span>
            </div>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label>Data urodenia</label>
            </div>
            <div class="form-right-column">
                <input type="date" name="data">
            </div>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label>Miejscowość</label>
            </div>
            <div class="form-right-column">
                <input type="text" name="miejscowosc">
            </div>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label>Email *</label>
            </div>
            <div class="form-right-column">
                <input type="email" name="email">
            </div>
            <?php
                if(isset($_SESSION['e_email'])){
                    echo '<div class="error">'.$_SESSION['e_email'].'</div>';
                    unset($_SESSION['e_email']);
                }
            ?>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label>Hasło *</label>
            </div>
            <div class="form-right-column">
                <input type="password" name="password1">
            </div>
            <?php
                if(isset($_SESSION['e_password'])){
                    echo '<div class="error">'.$_SESSION['e_password'].'</div>';
                    unset($_SESSION['e_password']);
                }
            ?>
        </div>
        <div class="form-line">
            <div class="form-left-column">
                <label>Powtórz hasło *</label>
            </div>
            <div class="form-right-column">
                <input type="password" name="password2">
            </div>
        </div>
        <div class="form-line">
            <input type="checkbox" name="regulamin"><label>* Akceptuję warunki <a href="index.php?action=regulamin">regulaminu</a></label>
            <?php
                if(isset($_SESSION['e_regulamin'])){
                    echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
                    unset($_SESSION['e_regulamin']);
                }
            ?>
        </div>
        <div class="form-line">
            <input type="checkbox" name="zgoda"><label>Wyrażam zgodę na przetwarzanie danych osobowych w celach marketingowych i celem otrzymywania informacji handlowych drogą elektroniczną</label>
        </div>
        <div class="g-recaptcha" data-sitekey="6Ld8HCkUAAAAAF4p89ycmPJNgquCBz166YGL1Vk6"></div>
        <?php
                if(isset($_SESSION['e_bot'])){
                    echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
                    unset($_SESSION['e_bot']);
                }
            ?>
        <input type="submit" value="Zarejestruj się">
    </form>
    <p class="need-to-registration">Pola oznaczone * są wymagane do rejestracji</p>
</div>