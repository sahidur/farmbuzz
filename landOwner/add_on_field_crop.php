<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

$searchuseriddata=$_SESSION['user_id'];

$qury1 = "SELECT user_id,name FROM user WHERE usertype=4";
$stmtresult = $conn->prepare($qury1);
$stmtresult->execute();

$qury2 = "SELECT field_id,address FROM field_profile WHERE user_id= :user_id";
$stmtresult1 = $conn->prepare($qury2);
$stmtresult1->bindParam(':user_id', $searchuseriddata);
$stmtresult1->execute();


$qury3 = "SELECT crop_id,name FROM crop_profile";
$stmtresult2 = $conn->prepare($qury3);
$stmtresult2->execute();





$message = '';
if(!empty($_POST['season']) && !empty($_POST['field']) && !empty($_POST['farmer']) && !empty($_POST['crop'])){
    $season =$_POST['season'];
    $field =$_POST['field'];
    $crop =$_POST['crop'];
    $farmer =$_POST['farmer'];

        $sql = "INSERT INTO on_field_crop (season,user_id,owner,crop_id,field_id) VALUES (:season, :user_id, :owner, :crop_id, :field_id )";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':season', $season);
        $stmt->bindParam(':user_id', $farmer);
        $stmt->bindParam(':owner', $searchuseriddata);
        $stmt->bindParam(':crop_id', $crop);
        $stmt->bindParam(':field_id', $field);

        if( $stmt->execute() ):
            $message = 'Successfully created new Crop field';
        else:
            $message = 'Sorry there must have been an issue creating thid crop field';
        endif;
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
    <a href="/dashboard.php"><img src="../assets/img/logo.png"></a>
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
                    Add New Crop Land
                </h1>
            </div>
            <?php if(!empty($message)): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <form action="add_on_field_crop.php" method="POST">
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

                <div class="form-group" class="form-control">
                    <label class="control-label col-sm-2" for="location">Select Farmer:</label>
                    <div class="col-sm-10">
                        <select name="farmer" class="form-control">
                            <?php while ($results = $stmtresult->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $results['user_id'];?>"> <?php echo $results['name'];
                                    ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group" class="form-control">
                    <label class="control-label col-sm-2" for="location">Select Field:</label>
                    <div class="col-sm-10">
                        <select name="field" class="form-control">
                            <?php while ($results1 = $stmtresult1->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $results1['field_id'];?>"> <?php echo $results1['address'];
                                    ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" class="form-control">
                    <label class="control-label col-sm-2" for="location">Select Crop:</label>
                    <div class="col-sm-10">
                        <select name="crop" class="form-control">
                            <?php while ($results2 = $stmtresult2->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $results2['crop_id'];?>"> <?php echo $results2['name'];
                                    ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default">Add Crop On Field</button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>

