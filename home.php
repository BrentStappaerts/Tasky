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

    if(isset($_POST['btnDeleteList'])) {
        $lijst->ListID = $_POST["deleteListID"];
        $result = $lijst->deleteList();
        header('Location: home.php');
    }

    if(isset($_POST['btnDeelList'])) {
        $lijst->ListID = $_POST["deelListID"];
        $lijst->share();
        header('Location: lijsten.php');
    }

 

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
                <h5><?php echo htmlspecialchars($userRow['name']); ?></h5>
            </div>
            <div class="col-sm-5 .col-md-6" id="settings">
                <a href="editedProfile.php?id=<?php echo htmlspecialchars($user_id) ?>"><img src="public/images/settings.png" /></a>
            </div>   
        </div>
        <div class="col-sm-5 .col-md-6" id="home">
            <h3>Mijn lijsten</h3>
            <?php if(count($allLists) > 0):?>
            <ul class="comments__list">
                <?php foreach($allLists as $row): ?>
                <?php
                $list_id = $row['list_id'];
                $list_name = $row['name'];
                ?>
                <li class="comments__list__item">
                    <div id="verwijderen">
                        <div class="col-sm-5 .col-md-6">
                             <a href="list.php?list=<?php echo htmlspecialchars($list_id) ?>"><?php echo htmlspecialchars($list_name); ?></a> 
                        </div>
                        <div class="col-sm-5 .col-md-6" id="taskMenu">
                            <div class="col-md-4">
                             <form action="" method="post">
                                <input type="hidden" name="deleteListID" value="<?php echo htmlspecialchars($list_id); ?>">
                                <input type="submit" name="btnDeleteList" value="Verwijderen">
                             </form> 
                            </div>
                            <div class="col-md-4">
                             <form action="" method="post">
                                <input type="hidden" name="deelListID" value="<?php echo htmlspecialchars($list_id); ?>">
                                <input type="submit" name="btnDeelList" value="Delen" >
                             </form> 
                            </div>
                        </div> 
                    </div>          
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