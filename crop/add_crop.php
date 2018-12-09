<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

$message = '';
if(!empty($_POST['name']) && !empty($_POST['variety']) && !empty($_POST['season'])){
    $name =$_POST['name'];
    $variety =$_POST['variety'];
    $season =$_POST['season'];

        $sql = "INSERT INTO crop_profile (name,variety,season) VALUES (:name, :variety, :season)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':variety', $variety);
        $stmt->bindParam(':season', $season);

        if( $stmt->execute() ) {
            $message = 'Successfully Added New Crop';
        }
        else {
            $message = 'Sorry there must have been an issue creating this crop profile';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <meta name="viewport" content="width=device-width, initial-scale=1" >
    <title>E-Farm CSE311</title>

    <link rel="shortcut icon" href="assets/img/favicon.png">
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
                    Add New Crop
                </h1>
            </div>
            <?php if(!empty($message)): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <form action="add_crop.php" method="POST">
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="name">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Enter crop Name" name="name">
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="name">Variety:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Enter crop Variety" name="variety">
                    </div>
                </div>
                <div class="form-group" class="form-control">
                    <label class="control-label col-sm-2" for="season">Season:</label>
                    <div class="col-sm-10">
                        <select name="season" class="form-control">
                            <option value="Summer">Pre-monsoon hot season from March-May</option>
                            <option value="Rainy">Rainy monsoon season from June-October</option>
                            <option value="Winter">Cool dry winter season from November-February</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default">Add Crop</button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>

