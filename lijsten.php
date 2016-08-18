
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

    if ($userRow['user_id'] != $userRow['user_id']) {
        header('Location: home.php');
    }

    $lijst = new Lijst();
    $sharedList = $lijst->getSharedList();



?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasky | Gedeelde lijsten</title>
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
            <h3>Gedeelde lijsten</h3>
        <ul class="comments__list">
            <?php if(count($sharedList) > 0):?>
            <ul class="comments__list">
                <?php foreach($sharedList as $row): ?>
                <?php
                $list_id = $row['list_id'];
                $list_name = $row['name'];
                ?>

                <li class="comments__list__item">
                        <div class="col-sm-5 .col-md-6" id="GedeeldeLijsten">
                              <a href="shared.php?list=<?php echo $list_id ?>"><?php echo $list_name; ?></a> 
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