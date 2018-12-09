<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

$message = '';
if(!empty($_POST['id']) && !empty($_POST['check_id'])):
    $idcrop =$_POST['id'];
    $check_id =$_POST['check_id'];
    if (strcmp($idcrop,$check_id)) {
        echo '<script language="javascript">';
        echo 'alert("Please Correctly Input ID")';
        echo '</script>';

    }
    else {

            $sql2 = "DELETE FROM crop_profile WHERE crop_id = :idcrop";
            $stmt = $conn->prepare($sql2);
            $stmt->bindParam(':idcrop', $idcrop);
            if( $stmt->execute() ) {
                $message = 'Successfully delete Crop';
            }
            else{
                $message = 'Sorry there must have been an issue deleting this crop';
        }
    }
endif;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <title>E-Farm CSE311</title>

    <link rel="shortcut icon" href="../assets/img/favicon.png">
    <link rel="stylesheet" href="../assets/css/plugins-bundle.css" >
    <link rel="stylesheet" href="../assets/css/icons-bundle.css" >
    <link rel="stylesheet" href="../assets/css/maincss.min.css" >

</head>

<body>
<header id="header">
    <a href="/311/dashboard.php"><img src="../assets/img/logo.png"></a>
    <nav id="nav-main">
        <ul class="nav nav-main-vertical">
            <li><a href=""></i><?php echo "$nam"; ?></a></li>
        </ul>
        <p class="text-muted"><?php echo "$desi"; ?></p>
        <hr>
    </nav>
    <?php
    if($usertype==1)
        include('../menu/adminmenu.php');
    else if($usertype==2)
        include('../menu/landownermenu.php');
    else if ($usertype==3)
        include('../menu/dcmenu.php');
    else if ($usertype==4)
        include('../menu/farmermenu.php');
    else if ($usertype==5)
        include('../menu/labmenu.php');
    else {
        echo '<script language="javascript">';
        echo 'alert("Error!")';
        echo '</script>';
    }
    ?>
    <div class="bottom">
        <p class="text-muted">CSE311L Final Project</p>
        <p class="text-muted">Md. Sahidur Rahman</p>
        <p class="text-muted">Rabiul Ali Sarkar</p>
        <p class="text-muted">Tasdid Rahman</p>
        <ul class="nav-bottom">
            <li><a></span>Group: R4H</a></li>
        </ul>
    </div>

</header>
<div id="content">

    <div class="container">
        <div class="col-md-12">
            <br>
            <br>
            <br>
            <div class="page-header">
                <h1>
                    Delete Crop
                </h1>
            </div>
            <br>
            <?php if(!empty($message)): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <form action="delete_crop.php" method="POST">
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="email">ID:</label>
                    <div class="col-sm-10">
                        <input type="number" min="0" class="form-control" placeholder="Enter crop ID" name="id">
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="email">ReType-ID:</label>
                    <div class="col-sm-10">
                        <input type="number" min="0" class="form-control" placeholder="Retype ID" name="check_id">
                    </div>
                </div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default">Delete Crop</button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>

