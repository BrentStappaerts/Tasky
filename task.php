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
    $comment = new Comment();
    
    if(!empty($_POST)) {
        try {
            $comment->Comment = $_POST["comment"];
            $comment->Add();
            $succes = "Comment succesvol toegevoegd!";
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
    $deadline = new Deadline();
    $oneTask = $deadline->getTask();



?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasky | Lijst</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="public/js/jquery-2.2.3.min.js"></script>
    <link rel="stylesheet" href="public/css/bootstrap.min.css" type="text/css">
    <script src="public/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
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
                <h5>Naam taak</h5>
                <?php if(count($oneTask) > 0):?>
            <ul class="comments__list">
                <?php foreach( $oneTask as $row): ?>
                <?php
                $deadline_id = $row['deadline_id'];
                $deadline_name = $row['titel'];
                $deadline_vak = $row['vak'];
                ?>
                <li class="comments__list__item">
                     <p><?php echo $deadline_name; ?></p> 
                     <p><?php echo $deadline_vak; ?></p> 
           
                 </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
                <ul class="comments__list"></ul>
            <?php endif; ?>
                        <div id="taak">
            <h5>Comment plaatsen</h5>
            <form action="" method="post">
            <div class="form-group">
                <input type="text" name="comment" placeholder="Schrijf een comment" />
            </div>
            <div class="form-group">
                <input type="hidden" name="action" value="addComment">
                <input type="submit" class="btn btn-warning form--addComment__btn" name="btnAddComment" value="Plaats een comment" />
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
        </div>

    </div>
</div>

</body>
</html>