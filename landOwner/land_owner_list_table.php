<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}


$idsearch = 2;
$recordstable = $conn->prepare('SELECT u.user_id,u.name,u.email,l.location_name FROM user u,
land_budget l WHERE u.location=l.location_id and u.usertype = :id');
$recordstable->bindParam(':id', $idsearch);
$recordstable->execute();


$arrVal = array();

$i=1;
while ($resultstable = $recordstable->fetch(PDO::FETCH_ASSOC)) {

    $name = array(
        'num' => $i,
        'id'=> $resultstable['user_id'],
        'name'=> $resultstable['name'],
        'email'=> $resultstable['email'],
        'location'=> $resultstable['location_name']
    );


    array_push($arrVal, $name);
    $i++;
}
echo  json_encode($arrVal);

?>
