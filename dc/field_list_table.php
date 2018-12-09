<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}
$recordstable = $conn->prepare('SELECT field_profile.field_id,land_budget.location_name, field_profile.address,
 user.user_id, user.name FROM land_budget NATURAL JOIN user NATURAL JOIN field_profile WHERE user.usertype = 2 ORDER BY field_profile.field_id');
$recordstable->execute();
$arrVal = array();

$i=1;
while ($resultstable = $recordstable->fetch(PDO::FETCH_ASSOC)) {

    $name = array(
        'num' => $i,
        'fid'=> $resultstable['field_id'],
        'lname'=> $resultstable['location_name'],
        'address'=> $resultstable['address'],
        'oid'=> $resultstable['user_id'],
        'ownername'=> $resultstable['name']
    );


    array_push($arrVal, $name);
    $i++;
}
echo  json_encode($arrVal);

?>
