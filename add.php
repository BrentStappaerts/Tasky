<?php
    session_start();
    spl_autoload_register(function ($class_name) {
        include 'classes/' .$class_name . '.class.php';
    });

    if(isset($_SESSION['loggedin']) && isset($_SESSION['user_id'])){
        $user = new User();
        $user_id = $_SESSION['user_id'];

        $db =  Db::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE user_id=:user_id");
        $stmt->execute(array(":user_id"=>$user_id));  
        $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
    }
    else {
        header('Location: index.php');
    }

  $lijst = new Lijst();
    
    if(!empty($_POST)) {
        try {
            $lijst->Name = $_POST["name"];
            $lijst->Add();
            $succes = "Lijst succesvol toegevoegd!";
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasky | Toevoegen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="public/js/jquery-2.2.3.min.js"></script>
    <link rel="stylesheet" href="public/css/bootstrap.min.css" type="text/css">
    <script src="public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Cuprum">
</head>
<body>
<?php include 'nav.inc.php'; ?></div>
    <div id="timeline">
        <div class="col-sm-5 .col-md-6" id="leftbalk">
            <img src="public/images/profile.png"/>
            <div class="col-sm-5 .col-md-6" id="gegevens">
                <h5><?php print($userRow['name']); ?></h5>
            </div>
            <div class="col-sm-5 .col-md-6" id="settings">
                <a href=""><img src="public/images/settings.png" /></a>
            </div>   
        </div>
        <div class="col-sm-5 .col-md-6" id="home">
            <div id="lijsten">
            <h3>Nieuwe lijst toevoegen</h3>
            <form action="" method="post">
            <div class="form-group">
                <input type="text" name="name" placeholder="Naam lijst" />
            </div>
            <div class="form-group">
                <input type="hidden" name="action" value="add">
                <input type="submit" class="btn btn-warning form--add__btn" name="btnAdd" value="Toevoegen" />
            </div>
        </form>
    </div>


        <?php if(isset($error)): ?>
        <div class="error">
            <?php echo $error; ?>
        </div>
        <?php endif; ?>

        <?php if(isset($succes)): ?>
        <div class="feedback">
            <?php echo $succes; ?>
        </div>
        <?php endif; ?>
    </form>


    </div>
</div>

</body>
</html>