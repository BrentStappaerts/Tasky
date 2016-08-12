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
    $allTasks = $deadline->getAll();

    if(!empty($_POST['btnAddTaak'])) {
        try {
            $deadline->Titel = $_POST["titel"];
            $deadline->Vak = $_POST["vak"];
            $deadline->Datum = $_POST["datum"];
            $deadline->Add();
            $succes = "Taak succesvol toegevoegd!";
            $allTasks = $deadline->getAll();
        } catch (Exception $e) {
            $error = "Taak niet correct toegevoegd";
        }
    }

    if(isset($_POST['btnDone'])) {
        $deadline->DeadlineID = $_POST["deadlineID"];
        $deadline->done();
        $allTasks = $deadline->getAll();
    }

    if(isset($_POST['btnDeleteTask'])) {
        $deadline->DeadlineID = $_POST["deleteDeadlineID"];
        $result = $deadline->deleteTask();
        $allTasks = $deadline->getAll();
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
            <img src="public/images/profile.png"/>
            <div class="col-sm-5 .col-md-6" id="gegevens">
                <h5><?php print($userRow['name']); ?></h5>
            </div>
            <div class="col-sm-5 .col-md-6" id="settings">
                <a href=""><img src="public/images/settings.png" /></a>
            </div>  
            <div id="taak">
            <h5>Taak toevoegen aan de lijst</h5>
            <form action="" method="post">
            <div class="form-group">
                <input type="text" name="titel" placeholder="Naam taak" />
            </div>
            <div class="form-group">
                <input type="text" name="vak" placeholder="Vak" />
            </div>
            <div class="form-group">
                <input type="date" name="datum" placeholder="Datum" />
            </div>
            <div class="form-group">
                <input type="hidden" name="action" value="addTaak">
                <input type="submit" class="btn btn-warning form--addTaak__btn" name="btnAddTaak" value="Taak toevoegen" />
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
        <div class="col-sm-5 .col-md-6" id="home">
                <h3>Mijn taken</h3>
                <?php if(count($allTasks) > 0):?>
            <ul class="comments__list">
                <?php foreach( $allTasks as $row): ?>  
                <?php
                $deadline_id = $row['deadline_id'];
                $deadline_date = $row['datum'];
                $daydifference = abs(floor((time() - strtotime($deadline_date))/(60*60*24)));
                $deadline_name = $row['titel'];
                $deadline_done = $row['done'];
                ?>
                <li class="comments__list__item">
                    <div id="taken">
                        <div class="col-sm-5 .col-md-6" id="taakT">
                            <a href="task.php?Task=<?php echo $deadline_id; ?>" class="done<?php echo $deadline_done; ?>"><?php echo $deadline_name; ?></a> 
                            <p><span><?php echo $daydifference . " dagen resterend"; ?></span></p>
                        </div>
                        <div class="col-sm-5 .col-md-6" id="taskMenu">
                            <div class="col-md-4">
                             <form action="" method="post">
                                <input type="hidden" name="deadlineID" value="<?php echo $deadline_id; ?>">
                                <input type="submit" name="btnDone" value="Voltooien" class="done">
                             </form> 
                            </div>
                            <div class="col-md-4">
                             <form action="" method="post">
                                <input type="hidden" name="deleteDeadlineID" value="<?php echo $deadline_id; ?>">
                                <input type="submit" name="btnDeleteTask" value="Verwijderen" >
                             </form> 
                            </div>
                            <div class="col-md-4">
                                <div id="bewerkenTaak">
                                    <a href="editedDeadline.php?Task=<?php echo $deadline_id ?>">Bewerken</a> 
                                </div>
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
</div>

</body>
</html>