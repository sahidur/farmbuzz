<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}
$qury = "SELECT location_id,location_name FROM land_budget";
$stmtresult = $conn->prepare($qury);
$stmtresult->execute();

$message = '';
if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['location'])):
    $name =$_POST['name'];
    $email =$_POST['email'];
    $location =$_POST['location'];
    $designation = 'Farmer';
    $usertypeX= 4;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script language="javascript">';
        echo 'alert("Invalid Email Format")';
        echo '</script>';

    }
    else {

// Enter the new user in the database
        $sql = "INSERT INTO user (name, email, password, designation,location, usertype)
 VALUES (:name, :email, :password, :designation, :location, :usertype )";
        $stmt = $conn->prepare($sql);
        $password=password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':designation', $designation);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':usertype', $usertypeX);

        if( $stmt->execute() ):
            $message = 'Successfully created new Farmer';
        else:
            $message = 'Sorry there must have been an issue creating this account';
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
                    Add New Farmer
                </h1>
            </div>
            <?php if(!empty($message)): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <form action="add_farmer.php" method="POST">
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="email">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Enter Farmer Name" name="name">
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" placeholder="Enter Farmer Email" name="email">
                    </div>
                </div>
                <div class="form-group ">
                    <label class="control-label col-sm-2" for="email">Password:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" placeholder="Enter Farmer Password" name="password">
                    </div>
                </div>
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
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-default">Add Farmer</button>
                </div>
            </form>
            </form>
        </div>
    </div>
</div>
</div>
</body>
</html>

