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
    $sharedList = $lijst->getSharedList();

    $deadline = new Deadline();
    $allSharedTasks = $deadline->getSharedTasks();



?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasky | Overzicht lijsten</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="public/js/jquery-2.2.3.min.js"></script>
    <link rel="stylesheet" href="public/css/bootstrap.min.css" type="text/css">
    <script src="public/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="public/images/favicon.png" type="image/x-icon"/>
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Cuprum">
</head>
<body>
    <?php include 'nav.inc.php'; ?></div>
    <div id="timeline">
        <div class="col-sm-5 .col-md-6" id="leftbalk">
            <?php if($userRow['user_image'] != ""): ?>
            <img src="uploads/<?php echo $userRow['user_image']; ?>"/>
            <?php else: ?>
            <img src="public/images/profile.png"/>
            <?php endif; ?>            
            <div class="col-sm-5 .col-md-6" id="gegevens">
                <h5><?php print($userRow['name']); ?></h5>
            </div>
            <div class="col-sm-5 .col-md-6" id="settings">
                <a href="editedProfile.php?id=<?php echo $user_id ?>"><img src="public/images/settings.png" /></a>
            </div>   
        </div>
        <div class="col-sm-5 .col-md-6" id="home">
            <h3>Gedeelde lijst </h3>

        <ul class="comments__list">
            <?php if(count($allSharedTasks) > 0):?>
            <ul class="comments__list">
                                <?php foreach($allSharedTasks as $row): ?>
                <?php
                $deadline_id = $row['deadline_id'];
                $deadline_name = $row['titel'];
                $deadline_vak = $row['vak'];
                $deadline_date = $row['datum'];
                $daydifference = abs(floor((time() - strtotime($deadline_date))/(60*60*24)));
                ?>

                <li class="comments__list__item">
                        <div class="col-sm-5 .col-md-6" id="GedeeldeTaken">
                             <a href="task.php?Task=<?php echo $deadline_id; ?>"><?php echo $deadline_name; ?></a> 
                             <p><span><?php echo $daydifference . " dagen resterend"; ?></span></p>
                        </div>
                                 
                 </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
                <ul class="comments__list"></ul>
            <?php endif; ?>




        </div>
    </div>




 


</body>
</html>