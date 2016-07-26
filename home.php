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
    $allLists = $lijst->getAll();
    //print_r($allLists);

    if(!empty($_POST['btnDeleteList'])){
        $lijst = new Lijst();
        $lijst->deleteList();
    }

 

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasky | Homepage</title>
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
            <?php if(count($allLists) > 0):?>
            <ul class="comments__list">
                <?php foreach( $allLists as $item): ?>
                <li class="comments__list__item">
                     <a href="list.php?list=<?php echo $item ?>"><?php echo $item ?></a> 
                     <form action="" method="post">
                         <input type="hidden" name="deleteListID" id="deleteListID" class="deleteID">
                         <input type="submit" value="Verwijder deze lijst" class="list__delete" name="btnDeleteList" id="btnDeleteList">
                    </form>             
                 </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
                <ul class="comments__list"></ul>
            <?php endif; ?>
        </div>

    </div>
</div>

</body>
</html>