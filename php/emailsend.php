<?php

    session_start();

    $name = htmlspecialchars(trim($_POST['contact-name']));
    $email = htmlspecialchars(trim($_POST['contact-email']));
    $title =  htmlspecialchars(trim($_POST['contact-title']));
    $message = htmlspecialchars(trim($_POST['contact-message']));
    $send = $_POST['send'];

    $myEmail = 'wookashart@wookashart.usermd.net';

    $header = "Content-type: text/html; charset=utf-8\r\nFrom: $email";

    if (isset($_COOKIE['send'])){
        $_SESSION['conterror'] ='<div class="error">Odczekaj '.($_COOKIE['send']-time()).' sekund przed wysłaniem kolejnej wiadomości</div>';
        header('Location: ../index.php?action=contact');
        exit();
    } 

    if ($send && !isset($_COOKIE['send'])){
    
        if (empty($name)){ 
            $_SESSION['conterror'] = '<div class="error">Musisz wypełnić pole z nickiem!</div>';
            header('Location: ../index.php?action=contact');
            exit();
        } else if (strlen($name) > 20){ 
            $_SESSION['conterror'] = '<div class="error">Nick może mieć maksymalnie 20 znaków!</div>';
            header('Location: ../index.php?action=contact');
            exit();
        }
    


        if (empty($email)){ 
            $_SESSION['conterror'] = '<div class="error">Musisz podać email!</div>'; 
            header('Location: ../index.php?action=contact');
            exit();
        }
        else if (strlen($email) > 30){ 
            $_SESSION['conterror'] = '<div class="error">Email może mieć maksymalnie 30 znaków!</div>';
            header('Location: ../index.php?action=contact');
            exit();
        }
        elseif (preg_match('/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9\-\_\.]+\@[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ0-9\-\_\.]+\.[a-z]{2,4}$/',$email) == false){
            $_SESSION['conterror'] = '<div class="error">Niepoprawny adres Email!</div>'; 
            header('Location: ../index.php?action=contact');
            exit();
        }
        


        if (empty($title)){ 
            $_SESSION['conterror'] = '<div class="error">Musisz wypełnić pole z tematem!</div>'; 
            header('Location: ../index.php?action=contact');
            exit();
        }
            
        else if (strlen($title) > 120){ 
            $_SESSION['conterror'] = '<div class="error">Temat może mieć maksymalnie 120 znaków!</div>';
            header('Location: ../index.php?action=contact');
            exit();
        }



        
        if (empty($message)){ 
            $_SESSION['conterror'] = '<div class="error">Mususz wypełnić pole wiadomości!</div>';
            header('Location: ../index.php?action=contact');
            exit();
        }
        else if (strlen($message) > 500){ 
            $_SESSION['conterror'] = '<div class="error">Wiadomość może mieć maksymalnie 500 znaków!</div>'; 
            header('Location: ../index.php?action=contact');
            exit();
        }

        if (!isset($_SESSION['conterror'])){
            $post = 'Przysłał - '.$name.' ('.$email.') <br/> Treść wiadomości - '.$message;
        
            if (mail($myEmail, $title, $post, $header)){
                $_SESSION['conterror'] = '<div class="error">Twoja wiadomość została wysłana</div>';
                setcookie("send", time()+60, time()+60);
                header('Location: ../index.php?action=contact');
                exit();
            } else { 
                $_SESSION['conterror'] = '<div class="error">Wystąpił błąd podczas wysyłania wiadomości, spróbuj później.</div>';
                header('Location: ../index.php?action=contact');
                exit();
            }   
        }
    }



?>