<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

$searchuid=$_SESSION['user_id'];

$qury = "SELECT field_id,address FROM field_profile WHERE user_id = :searchuid";
$stmtresult = $conn->prepare($qury);
$stmtresult->bindParam(':searchuid', $searchuid);
$stmtresult->execute();

$message = '';
if(!empty($_POST['fid'])){

        $fid =$_POST['fid'];
        $sql = "INSERT INTO apply_fund (apply_status, field_id,landcondition) VALUES ('No', :field_id,'nvb')";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':field_id', $fid);

        if( $stmt->execute() ):
            $message = 'Apply Successful';
        else:
            $message = 'Sorry Submission Unsuccessful';
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
                    Apply For Funding
                </h1>
            </div>
            <?php if(!empty($message)): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <form action="apply_fund.php" method="POST">
                <div class="form-group" class="form-control">
                    <label class="control-label col-sm-2" for="location"> Select Field Location Location:</label>
                    <div class="col-sm-10">
                        <select name="fid" class="form-control">
                            <?php while ($results = $stmtresult->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?php echo $results['field_id'];?>"> <?php echo $results['address'];
                                    ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default">Apply</button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>

