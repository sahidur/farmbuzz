<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

$message = '';
if(!empty($_POST['id'])):
    $idsearch =$_POST['id'];
    if (!is_numeric($idsearch)) {
        echo '<script language="javascript">';
        echo 'alert("Please Correctly Input ID")';
        echo '</script>';

    }
    else {

        $degx = 4;
        $sql = "SELECT user_id,name,email FROM user WHERE user_id = :idsearch and usertype= :degx";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idsearch', $idsearch);
        $stmt->bindParam(':degx', $degx);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $comp = $result['user_id'];
        $namesearch=$result['name'];
        $emailsearch=$result['email'];
        if (strcmp($idsearch, $comp) !== 0) {
            $message = 'Sorry No Farmer found';
        } else {
            $message = 'Farmer Found';

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
                    Update Farmer Information
                </h1>
            </div>
            <br>
            <?php if(!empty($message)): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <form action="update_farmer.php" method="POST">
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="id">Id:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo "$comp";?>" name="id" readonly>
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="name">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo "$namesearch";?>" name="name">
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="email">email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" value="<?php echo "$emailsearch";?>" name="email">
                    </div>
                </div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default">Update Farmer</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>

