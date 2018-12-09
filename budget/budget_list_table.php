<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

$recordstable = $conn->prepare('SELECT location_id,location_name,budget FROM land_budget');
$recordstable->execute();


$arrVal = array();
$i=1;
while ($resultstable = $recordstable->fetch(PDO::FETCH_ASSOC)) {

    $name = array(
        'num' => $i,
        'id'=> $resultstable['location_id'],
        'name'=> $resultstable['location_name'],
        'budget'=> $resultstable['budget']
    );


    array_push($arrVal, $name);
    $i++;
}
echo  json_encode($arrVal);

?>
