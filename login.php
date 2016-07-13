<?php

include_once "classes/User.class.php";

session_start();

    if(isset($_SESSION['loggedin'])){
        header('location: home.php');
    }

    if(!empty($_POST)){
      $user = new User();
      $name = $_POST['name'];
      $password = $_POST['password'];

      if($user->Login($name, $password)){
            $_SESSION['loggedin'] = "ja";
            header('location: home.php');
      }else{
        $feedback = "Foute inlogegegvens. Probeer opnieuw!.";
      }
    }



?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasky | Login</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="public/js/jquery-2.2.3.min.js"></script>
    <link rel="stylesheet" href="public/css/bootstrap.min.css" type="text/css">
    <script src="public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
<body>
    <div class="form--register">
        <div class="col-sm-5 .col-md-6" id="logoForm">
            <img src="public/images/TaskyLogo.png" width="100%" />
        </div>
        <div id="transparant">
        <div class="col-sm-5 .col-md-6" id="registerForm">
        <form action="" class="post__form--login" method="post">
            <div class="form-group">
                <input type="text" class="form-control"  name="name" id="name" placeholder="Name">
            </div>
            <div class="form-group">
                <input type="password" class="form-control"  name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning form--login__btn" value="Inloggen">
            </div>
        </form>
    </div>
    </div>

    </div>
    </div>
	
</body>
</html>