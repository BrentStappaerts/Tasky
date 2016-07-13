<?php
include_once "classes/User.class.php";

session_start();

if( !empty( $_POST ) ){
    try{
        $user = new User();
        $user->Email = $_POST['email'];
        $user->Name = $_POST['name'];
        $user->Password = $_POST['password'];
        $user->register();

    }catch(Exception $e){
        $feedback = $e->getMessage();
    }
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasky | Register</title>

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
        <?php if(isset($feedback)){ echo "<div class='alert alert-danger' role='alert'>".$feedback."</div>";}?>
        <form action="" class="post__form--register" method="post">
            <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="text" class="form-control"  name="name" id="name" placeholder="Name">
            </div>
            <div class="form-group">
                <input type="password" class="form-control"  name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-warning form--register__btn" value="Registreer nu!">
            </div>
        </form>
    </div>
    </div>

    </div>
    </div>
	
</body>
</html>
