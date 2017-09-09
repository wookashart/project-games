<?php

    session_start();

    $site = (isset($_GET['action'])) ? $_GET['action'] : 'home';

    require_once "./db/connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);

?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Project Games</title>
        <link rel="stylesheet" href="./css/main.css">
        <link rel="stylesheet" href="./css/font-awesome.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/css/bootstrap-slider.css">
        <link href="https://fonts.googleapis.com/css?family=Oswald:400,700|Roboto:400,400i,900,900i&amp;subset=latin-ext" rel="stylesheet">
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head>
    <body>
        <header>
            <div class="header-conteiner">
                <!--Pierwsza linia headera-->
                <div class="header-first-line">
                    <div class="first-line-conteiner">
                        <div class="website-name"><a href="index.php?action=home">project games</a></div>
                        <div class="second-line-conteiner">
                            <form method="GET" action="php/searchresult.php">
                                <input type="text" placeholder="Wyszukaj grę" class="base-input find-game-input" name="search">
                                <button class="search-btn"><i class="fa fa-search" aria-hidden="true"></i></button>
                                <!-- <input type="submit" value="szukaj"> -->
                            </form>
                            
                        </div>
                        <?php
                            if((isset($_SESSION['useronline'])) && ($_SESSION['useronline'] == true)){

                                echo '<div class="website-user-logged"><div class="greatings"><ul><li><a href="#" class="user-panel">'.$_SESSION['login'].'<i class="fa fa-caret-down" aria-hidden="true"></i></a><ul><li><a href="index.php?action=userprofile" class="user-panel-menu-item">mój profil</a></li><li><a href="index.php?action=editprofile" class="user-panel-menu-item">edytuj profil</a></li><li><a href="index.php?action=mycollection&amp;page=1" class="user-panel-menu-item">moje gry</a></li><li><a href="index.php?action=playedgames&amp;page=1" class="user-panel-menu-item">ostatnio grane</a></li><li><a href="php/logout.php" class="user-panel-menu-item">Wyloguj się</a></li>';

                                if(($_SESSION['user_type'] == 'admin')){
                                    echo '<li><a href="./admins/admins.php" target="_blank" class="user-panel-menu-item">panel admina</a></li>';
                                }

                                echo '</ul></li></ul></div></div>';

                            } else {
                                echo '<div class="website-login-panel"><a class="login-panel-button" href="#">Zaloguj się / Zarejestruj się</a></div>';
                            }

                        ?>       
                    </div>
                    <div class="login-box">
                        <p class="log-reg-text">Zaloguj się</p>
                        <form action="php/userlogin.php" method="post">
                            <input type="text" name="login" placeholder="Login" class="base-input">
                            <input type="password" name="haslo" placeholder="Hasło" class="base-input">
                            <input type="submit" value="Zaloguj się">
                        </form>
                        <?php
                            if(isset($_SESSION['blad']))
                            {echo $_SESSION['blad'];}
                        ?>
                        <p class="password-reminder"><a href="#">Przypomnienie hasła</a></p>
                        <p class="log-reg-text">Zarejestruj się</p>
                        <button class="base-btn registration-button"><a href="index.php?action=registration">Rejestracja</a></button>
                    </div>
                </div>
                <!--Druga linia headera-->
                <!-- <div class="header-second-line">
                    
                </div> -->
                <!--Menu hamburger-->
                <div class="header-hamburger-line">
                    <div class="hamburger-line-conteiner">
                        <div class="hamburger-on"><i class="fa fa-bars" aria-hidden="true"></i></div>
                    </div>
                </div>
                <!--Trzecia linia headera-->
                <div class="header-third-line">
                    <div class="third-line-conteiner">
                        <nav>
                            <ul>
                                <!--<li><a href="index.php?action=home">Strona główna</a></li>-->
                                <li><a href="index.php?action=gamelibrary&amp;page=1">Biblioteka gier</a></li>
                                <li><a href="index.php?action=articles">Artykuły</a></li>
                                <li><a href="index.php?action=tutorials">Poradniki</a></li>
                                <li><a href="index.php?action=forum">Forum</a></li>
                                <li><a href="index.php?action=contact">Kontakt</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <section class="web-center-section">
            <?php
                switch($site){
                    case 'home' : include 'pages/home.php'; break;
                    case 'gamelibrary' : include 'pages/gamelibrary.php'; break;
                    case 'articles' : include 'pages/articles.php'; break;
                    case 'tutorials' : include 'pages/tutorials.php'; break;
                    case 'forum' : include 'pages/forum.php'; break;
                    case 'contact' : include 'pages/contact.php'; break;
                    case 'registration' : include 'pages/registration.php'; break;
                    case 'regulamin' : include 'pages/regulamin.php'; break;
                    case 'thanksregistery' : include 'pages/thanksregistery.php'; break;
                    case 'gamedetail' : include 'pages/gamedetail.php'; break;
                    case 'userprofile' : include 'pages/userprofile.php'; break;
                    case 'editprofile' : include 'pages/userprofileedit.php'; break;
                    case 'mycollection' : include 'pages/usergamecollection.php'; break;
                    case 'playedgames' : include 'pages/userplayedgames.php'; break;
                    case 'searchgame' : include 'pages/searchgame.php'; break;
                    default : include 'pages/home.php'; break;
                }
            ?>
        </section>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/bootstrap-slider.js"></script>
        <script src="./js/jquery-3.1.1.min.js"></script>
        <script src="./js/main.js"></script>
    </body>
</html>