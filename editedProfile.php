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

    if(isset($_POST['uploadImage'])) {
        //get image extension (.jpg, .png, ...)
        $image_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        //set unique filename to avoid images with the same name/path
        $user->Image = uniqid().'.'.$image_extension;
        //temporary image
        $image_tmp_name = $_FILES['image']['tmp_name'];
        //set path to directory
        $path = 'uploads/'.$user->Image;
        //get image width and height
        list($image_width, $image_height) = getimagesize($image_tmp_name);
        //set new
        $width = 250;
        $height = 250;
        $height = (int) (($width / $image_width) * $image_height);
        $image_p = imagecreatetruecolor($width, $height);
        $image   = imagecreatefromjpeg($image_tmp_name);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $image_width, $image_height);
        imagejpeg($image_p, $path, 90);

        $user->Upload();
        header('Location: home.php');
    }

 

?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasky | Profiel bewerken</title>
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
            <h3>Profiel</h3></br>

            <p><strong>Naam: </strong><?php print($userRow['name']); ?> </p>
            <p><strong>Email: </strong><?php print($userRow['email']); ?> </p></br>
            <p><strong>Profiel foto toevoegen: </strong></p>
                <div class="col-sm-5 .col-md-6">
                     <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="image" id="image" accept="image/*">
                        <input type="submit" name="uploadImage" value="Upload">
                     </form> 
                </div>        
        </div>

    </div>
</div>

</body>
</html>