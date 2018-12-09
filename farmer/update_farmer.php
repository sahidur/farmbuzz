<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

$message = '';
if(!empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['email'])):
    $idsearchnew =$_POST['id'];
    $namesearchnew =$_POST['name'];
    $emailsearchnew =$_POST['email'];
    if (!filter_var($emailsearchnew, FILTER_VALIDATE_EMAIL)) {
        echo '<script language="javascript">';
        echo 'alert("Invalid Email Format")';
        echo '</script>';

    }
    else {
        $sql = "UPDATE user SET user_id=:idsearchnew, name=:namesearchnew, email=:emailsearchnew WHERE user_id=:idsearchnew";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':idsearchnew', $idsearchnew);
        $stmt->bindParam(':namesearchnew', $namesearchnew);
        $stmt->bindParam(':emailsearchnew', $emailsearchnew);

        if( $stmt->execute() ):
            $message = 'Successfully update Farmer information';
        else:
            $message = 'Sorry there must have been an issue updating this account';
        endif;
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
            <form action="update_form_farmer.php" method="POST">
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="email">Id:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Enter Farmer Id" name="id">
                    </div>
                </div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default">Search Farmer</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

