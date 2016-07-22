<?php
spl_autoload_register(function ($class_name) {
    include 'classes/' .$class_name . '.class.php';
});

if(!empty($_POST)){
    if($_POST['action'] === "inloggen") {
        if(!empty($_POST["email"]) && !empty($_POST["passwordLogin"])){
            $user = new User();
            $user->Email = $_POST["email"];
            $user->Password = $_POST["passwordLogin"];
            if($user->canLogin()){
                $_SESSION['loggedin'] = true;
                header('Location: home.php');
            }  else {
                echo"Could not log you on";
            }
        }else{
            echo "Please fill in all fields";
        }
    }
}
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasky | Inloggen</title>
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
        <form action="" method="post">
            <div class="form-group">
                <input type="text" name="email" placeholder="Email" />
            </div>
            <div class="form-group">
                <input type="password" name="passwordLogin" placeholder="Password" />
            </div>
            <div class="form-group">
                <input type="hidden" name="action" value="inloggen">
                <input type="submit" class="btn btn-warning form--login__btn" name="btnLogin" value="Inloggen" />
            </div>
        </form>
    </div>
</div>

</body>
</html>