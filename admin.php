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

    if ($userRow['admin'] != 1) {
        header('Location: home.php');
    }

    $vak = new Vak();

    if(isset($_POST['addVak'])) {
        $vak->VakNaam = $_POST["vak_naam"];
        $vak->Add();
    }

    if(isset($_POST['btnUpdateVak'])) {
        $vak->VakID = $_POST["updateVakID"];
        $vak->VakNaam = $_POST["updateVak"];
        $vak->updateVak();
    }

    if(isset($_POST['btnDeleteVak'])) {
        $vak->VakID = $_POST["deleteVakID"];
        $vak->deleteVak();
    }
    $vakken = $vak->getAll();

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
            <h3>Nieuw vak toevoegen</h3>
                <ul class="comments__list">
                    <div id="vakToevoegen">
                        <form action="" method="post">
                         <input type="text" name="vak_naam" placeholder="Naam vak">
                         <input type="submit" name="addVak" value="Vak toevoegen">
                        </form>
                    </div>
            <?php if(count($vakken) > 0):?>
                <?php foreach($vakken as $row): ?>
                <?php
                $vak_id = $row['vak_id'];
                $vak_name = $row['vak_name'];
                ?>
                <li class="comments__list__item"> 
                    <div id="verwijderen"> 
                        <div class="col-sm-5 .col-md-6">
                            <form action="" method="post">
                                <input name="updateVakID" value="<?php echo $vak_id; ?>" hidden>
                                <input name="updateVak" value="<?php echo $vak_name; ?>">
                                <input type="submit" name="btnUpdateVak" value="Bijwerken">
                            </form>
                        </div>
                    </div>
                        <div id="verwijderen">
                        <div class="col-sm-5 .col-md-6">
                             <form action="" method="post">
                                <input type="hidden" name="deleteVakID" value="<?php echo $vak_id; ?>">
                                <input type="submit" name="btnDeleteVak" value="Vak verwijderen">
                             </form> 
                        </div> 
                    </br>
                    </div>           
                 </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
                <ul class="comments__list">
                    Geen vakken beschikbaar
                </ul>
            <?php endif; ?>
        </div>

    </div>
</div>

</body>
</html>