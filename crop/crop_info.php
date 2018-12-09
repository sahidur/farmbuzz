<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
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
    <link type="text/css" href="../assets/bootstrap/bootstrap-table.css" rel="stylesheet">
    <link type="text/css" href="../assets/bootstrap/font-awesome.css" rel="stylesheet">

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
                    Crop Information
                </h1>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading ">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="/311/crop/add_crop.php" class="btn btn-primary">Add New Crop</a>
                            <a href="/311/crop/delete_crop.php" class="btn btn-primary">Delete Crop</a>
                            <table 	id="table"
                                      data-show-columns="false"
                                      data-height="460">
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/plugins/js/jquery-1.11.1.min.js"></script>
    <script src="../assets/plugins/js/bootstrap.min.js"></script>
    <script src="../assets/plugins/js/bootstrap-table.js"></script>

    <script type="text/javascript">

        var $table = $('#table');
        $table.bootstrapTable({
            url: 'crop_list_table.php',
            search: true,
            pagination: true,
            buttonsClass: 'primary',
            showFooter: true,
            minimumCountColumns: 2,
            columns: [{
                field: 'num',
                title: 'Serial',
                sortable: true,
            },{
                field: 'id',
                title: 'Crop ID',
                sortable: true,
            },{
                field: 'name',
                title: 'Crop Name',
                sortable: true,

            },{
                field: 'variety',
                title: 'Variety',
                sortable: true,

            },{
                field: 'season',
                title: 'Season',
                sortable: true,

            },],

        });

    </script>


</div>
</body>
</html>

