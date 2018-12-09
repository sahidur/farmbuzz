<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

$message = '';
if(!empty($_POST['email']) && !empty($_POST['check_email'])):
    $email =$_POST['email'];
    $check_email =$_POST['check_email'];
    if (strcmp($email,$check_email)) {
        echo '<script language="javascript">';
        echo 'alert("Please Correctly Input Email")';
        echo '</script>';

    }
    else {
        $sql1 = "SELECT usertype FROM user WHERE email = :email";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bindParam(':email', $email);
        $stmt1->execute();
        $resultusertype = $stmt1->fetch(PDO::FETCH_ASSOC);
        $resultfordelete = $resultusertype['usertype'];

        if($resultfordelete=='2'){
        $dlt = 2;
        $sql2 = "DELETE FROM user WHERE email = :email and usertype =:dlt";
        $stmt = $conn->prepare($sql2);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':dlt', $dlt);

        if( $stmt->execute() ):
            $message = 'Successfully delete land owner';
        else:
            $message = 'Sorry there must have been an issue deleting this account';
        endif;
        }
        else
            $message = 'Sorry this is not a valid land owner email';
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
                    Delete Land Owner
                </h1>
            </div>
            <br>
            <?php if(!empty($message)): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <form action="delete_land_owner.php" method="POST">
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" placeholder="Enter Land Owner Email" name="email">
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="email">ReType-Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" placeholder="Retype Email" name="check_email">
                    </div>
                </div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default">Delete User</button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>

