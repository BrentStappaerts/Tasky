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

    if(isset($_POST['btnUpdateTask'])) {
        try{
            $deadline->Titel = $_POST["titel"];
            $deadline->Vak = $_POST["vak"];
            $deadline->Datum = $_POST["datum"];
            $deadline->Werkdruk = $_POST["werkdruk"];
            $deadline->updateTask();
            header('Location: task.php?Task=' . $_GET['Task']);
        } catch (Exception $e){
            $error= "Bewerking mislukt!";
        }
    }

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasky | Taak </title>
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
            <h3>Taak bewerken</h3>
            <?php if(count($oneTask) > 0):?>
            <ul class="comments__list">
                <?php foreach( $oneTask as $row): ?>
                <?php
                $deadline_id = $row['deadline_id'];
                $deadline_name = $row['titel'];
                $deadline_vak = $row['vak'];
                $deadline_date = $row['datum'];
                $deadline_werkdruk = $row['werkdruk'];
                ?>
                <li class="comments__list__item">
                    <div id="taakDetails">
                        <form action="" method="post">
                            <div class="form-group">
                               Titel: <input type="text" name="titel" value="<?php echo $deadline_name ?>" />
                            </div>
                            <div class="form-group">
                                Vak: <input type="text" name="vak" value="<?php echo $deadline_vak ?>" />
                            </div>
                            <div class="form-group">
                                Datum deadline: <input type="date" name="datum" value="<?php echo $deadline_date ?>" />
                            </div>
                            <div class="form-group">
                                Aantal werkuren: <input type="number" name="werkdruk" value="<?php echo $deadline_werkdruk ?>" />
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="updateDeadlineID" value="addTaak">
                                <input type="submit" class="btn btn-warning form--updateTask__btn" name="btnUpdateTask" value="Taak bewerken" />
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