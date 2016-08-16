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

    $deadline = new Deadline();
    $oneTask = $deadline->getTask();

    $comment = new Comment();
    $comments = $comment->getAll();

    if(!empty($_POST['btnAddComment'])) {
        try {
            
            $comment->Comment = $_POST["comment"];
            $comment->CommentUsername = $_POST["username"];
            $comment->Add();
            $comments = $comment->getAll();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

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
                <h5><?php print($userRow['name']); ?></h5></br>
                <a href="home.php">Mijn Lijsten</a>
            </div>
            <div class="col-sm-5 .col-md-6" id="settings">
                <a href="editedProfile.php?id=<?php echo $user_id ?>"><img src="public/images/settings.png" /></a>
            </div> 

        </div>
        <div class="col-sm-5 .col-md-6" id="home">
                <h3>Taak</h3>
                <?php if(count($oneTask) > 0):?>
            <ul class="comments__list">
                <?php foreach( $oneTask as $row): ?>
                <?php
                $deadline_id = $row['deadline_id'];
                $deadline_name = $row['titel'];
                $deadline_vak = $row['vak'];
                $deadline_date = $row['datum'];
                $deadline_werkdruk = $row['werkdruk'];
                $daydifference = abs(floor((time() - strtotime($deadline_date))/(60*60*24)));
                ?>
                <li class="comments__list__item">
                    <div id="taakDetails">
                     <p><strong>Titel: </strong> <?php echo $deadline_name; ?></p> 
                     <p><strong>Vak: </strong> <?php echo $deadline_vak; ?></p> 
                     <p><strong>Deadline: </strong> <?php echo $deadline_date; ?></p> 
                     <p><strong>Resterende dagen: </strong> <?php echo $daydifference ?></p> 
                     <p><strong>Aantal werkuren: </strong><?php echo $deadline_werkdruk ?></p>
                    </div>
                 </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
                <ul class="comments__list"></ul>
            <?php endif; ?>
            <div id="taak">
            <h5>Comment op deze taak plaatsen</h5>
            <form action="" method="post">
            <div class="form-group">
                <input type="text" name="comment" placeholder="Schrijf een comment" />
            </div>
            <div class="form-group">
                <input type="hidden" name="username" value="<?php echo $userRow['name']; ?>">
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

        <?php foreach( $comments as $row): ?>
        <?php 
        $comment_text = $row['comment'];
        $comment_username = $row['username'];
        ?>
        <p><strong><?php echo $comment_username; ?>:</strong> <?php echo $comment_text; ?></p>
        <?php endforeach; ?>

    </div>
        </div>
        </div>

    </div>
</div>

</body>
</html>