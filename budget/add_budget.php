<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

$message = '';
if(!empty($_POST['locationid']) && !empty($_POST['name']) && !empty($_POST['budget'])){
    $name =$_POST['name'];
    $budget =$_POST['budget'];
    $landlocation =$_POST['locationid'];

    $sql = "INSERT INTO budget_land (location_name,total_budget,land_location) VALUES (:name, :budget, :landlocation)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':budget', $budget);
    $stmt->bindParam(':landlocation', $landlocation);

    if( $stmt->execute() ) {
        $message = 'Successfully Add New Budget';
    }
    else {
        $message = 'Sorry there must have been an issue for this operation';
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
                    Add New Area Budget
                </h1>
            </div>
            <?php if(!empty($message)): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <form action="add_budget.php" method="POST">
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="name">Location ID:</label>
                    <div class="col-sm-10">
                        <input type="number" min="0" class="form-control" placeholder="Enter Area ID" name="locationid">
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="name">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Enter Location Name" name="name">
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="name">Budget:</label>
                    <div class="col-sm-10">
                        <input type="number" min="0" class="form-control" placeholder="Enter Location Budget" name="budget">
                    </div>
                </div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default">Add Budget</button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>

