<?php
session_start();
if(isset($_SESSION['loggedin']) && isset($_SESSION['user_id'])){
    header('Location: home.php');
} else {
    // do nothing
}
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasky | Welkom</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="public/js/jquery-2.2.3.min.js"></script>
    <link rel="stylesheet" href="public/css/bootstrap.min.css" type="text/css">
    <script src="public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
</head>
<body>
<div class="form--register">
    <div class="col-sm-5 .col-md-6" id="leftForm">
        <img src="public/images/TaskyLogo.png" width="100%" />
    </div>
    <div class="col-sm-5 .col-md-6" id="rightForm">
        <p>Helpt u bij het bijhouden van al uw deadlines</p>
        <a href="login.php"> Inloggen </a>
        <a href="register.php"> Registreren </a>
        </form>
    </div>
</div>

</body>
</html>