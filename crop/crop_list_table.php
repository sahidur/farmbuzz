<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

$recordstable = $conn->prepare('SELECT crop_id,name,variety,season FROM crop_profile');
$recordstable->execute();


$arrVal = array();
$i=1;
while ($resultstable = $recordstable->fetch(PDO::FETCH_ASSOC)) {

    $name = array(
        'num' => $i,
        'id'=> $resultstable['crop_id'],
        'name'=> $resultstable['name'],
        'variety'=> $resultstable['variety'],
        'season'=> $resultstable['season']
    );


    array_push($arrVal, $name);
    $i++;
}
echo  json_encode($arrVal);

?>
