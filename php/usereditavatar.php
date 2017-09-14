<?php

    session_start();
    require_once "../db/connect.php";
    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
  
    $userInfo = $connection->query("SELECT * FROM users WHERE id = {$_SESSION['id']}");
    $info = $userInfo->fetch_assoc();
  
    $fileName = $info['login'];
    $fileFormat = $_FILES['change-avatar']['type'];
  
    if($fileFormat == 'image/jpg'){
      $avatar = $fileName.'.jpg';
    }
  
    if($fileFormat == 'image/jpeg'){
      $avatar = $fileName.'.jpeg';
    }

    if($fileFormat == 'image/png'){
      $avatar = $fileName.'.png';
    }
  
    if($fileFormat == 'image/gif'){
      $avatar = $fileName.'.gif';
    }

    $targetDir = "../db/useravatars/";
    $targetFile = $targetDir.basename($avatar);
    $uploadOk = true;
    $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);

    $_SESSION['imgerr'] = '';

    if(isset($_POST['submit'])){
        $check = getimagesize($_FILES['change-avatar']['tmp_name']);

        if($check !== false){
            $uploadOk = true;
        } else {
            $uploadOk = false;
            $_SESSION['imgerr'] = '<div class="img-error">Plik nie jest obrazkierm</div>';
        }
    }

    if($_FILES["change-avatar"]["size"] > 500000) {    // 500kb
        $_SESSION['imgerr'] = '<div class="img-error">Plik jest zbyt duży</div>';
        $uploadOk = false;
    }
    
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $_SESSION['imgerr'] = '<div class="img-error">Niedozwolony format obrazka</div>';
        $uploadOk = false;
    }

    if($uploadOk == true){
        move_uploaded_file($_FILES['change-avatar']['tmp_name'], $targetFile);
        $updateInfo = $connection->query("UPDATE users SET avatar = '$avatar' WHERE id = {$_SESSION['id']}");
    }
    

    header('Location: ../index.php?action=editprofile');
    exit();

    $connection->close();

?>