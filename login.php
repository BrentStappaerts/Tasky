<?php
$error = "";

spl_autoload_register(function ($class_name) {
    include 'classes/' .$class_name . '.class.php';
});

if(!empty($_POST)){
    if($_POST['action'] === "inloggen") {
        try{
            $user = new User();
            $user->Email = $_POST["email"];
            $user->Password = $_POST["passwordLogin"];
            if($user->canLogin()){
                    $_SESSION['loggedin'] = true;
                    header('Location: home.php');
            } else{
                    $error = "Inloggegvens zijn niet correct.";
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
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
    <link rel="shortcut icon" href="public/images/favicon.png" type="image/x-icon"/>
    <link rel="stylesheet" href="public/css/bootstrap.min.css" type="text/css">
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
        <p id="inlog">Inloggen bij <strong>Tasky</strong></p>
        <?php echo $error ?>
        <form action="" method="post">
            <div class="form-group">
                <input type="text" name="email" placeholder="Email" />
            </div>
            <div class="form-group">
                <input type="password" name="passwordLogin" placeholder="Password" />
            </div>
            <div class="form-group">
                <input type="hidden" name="action" value="inloggen">
                <input type="submit" class="btn form--login__btn" name="btnLogin" value="Inloggen" />
            </div>
        </form>
        <a href="register.php" id="geenAccount">Ik heb nog geen account op Tasky?</a>
    </div>
</div>

</body>
</html>