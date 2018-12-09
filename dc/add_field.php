<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}
$qury1 = "SELECT location_id,location_name FROM land_budget";
$qury2 = "SELECT user_id,name FROM user WHERE usertype=2";
$stmtresult = $conn->prepare($qury1);
$stmtresult->execute();
$stmuser = $conn->prepare($qury2);
$stmuser->execute();
$message = '';
if(!empty($_POST['location']) && !empty($_POST['uid']) && !empty($_POST['address'])){
    $location =$_POST['location'];
    $uid =$_POST['uid'];
    $address =$_POST['address'];


        $sql = "INSERT INTO field_profile (address, location_id, user_id) VALUES (:address, :location, :uid)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':uid', $uid);

        if( $stmt->execute() ):
            $message = 'Successfully created new Field Owner';
        else:
            $message = 'Sorry there must have been an issue creating this account';
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
                    Add New Field Owner
                </h1>
            </div>
            <?php if(!empty($message)): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <form action="add_field.php" method="POST">
                <div class="form-group" class="form-control">
                    <label class="control-label col-sm-2" for="location">Location:</label>
                    <div class="col-sm-10">
                        <select name="location" class="form-control">
                            <?php while ($results = $stmtresult->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $results['location_id'];?>"> <?php echo $results['location_name'];
                                    ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group" class="form-control">
                    <label class="control-label col-sm-2" for="location">Land Owner:</label>
                    <div class="col-sm-10">
                        <select name="uid" class="form-control">
                            <?php while ($resultsuser = $stmuser->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $resultsuser['user_id'];?>"> <?php echo $resultsuser['name'];
                                    ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="email">Field Address:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Enter Field Address" name="address">
                    </div>
                </div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default">Add Field Owner</button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>

