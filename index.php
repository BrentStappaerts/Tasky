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
    <link rel="shortcut icon" href="public/images/favicon.png" type="image/x-icon"/>
    <script src="public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Cuprum">
</head>
<body>
<div class="form--register">
    <div class="col-sm-5 .col-md-6" id="leftForm">
        <img src="public/images/TaskyLogo.png" width="100%" />
    </div>
    <div class="col-sm-5 .col-md-6" id="rightForm">
        <p>Nooit meer een deadline missen, klinkt dat niet geweldig? </br>
            Het kan nu met <strong>Tasky</strong>, een eenvoudige tool om al uw deadlines op te lijsten en te beheren.</p>
        <p><strong>Tasky</strong> is vanaf nu geheel gratis te gebruiken na registratie.</p>
        <p>Maak nu gratis een account aan en geniet van deze eenvoudige tool.<p> </br></br>
        <a href="login.php" class="Login"> Inloggen </a>
        <a href="register.php" class="Register"> Registreren </a>
        </form>
    </div>
</div>

</body>
</html>