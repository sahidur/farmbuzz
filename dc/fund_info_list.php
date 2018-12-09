<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}


$recordstable = $conn->prepare('SELECT land_budget.location_name,field_profile.address,user.name,land_budget.budget,apply_fund.apply_status 
FROM field_profile NATURAL  JOIN apply_fund NATURAL JOIN land_budget NATURAL  JOIN user
');
$recordstable->execute();


$arrVal = array();

$i=1;
while ($resultstable = $recordstable->fetch(PDO::FETCH_ASSOC)) {

    $name = array(
        'num' => $i,
        'lname'=> $resultstable['location_name'],
        'address'=> $resultstable['address'],
        'name'=> $resultstable['name'],
        'budget'=> $resultstable['budget'],
        'status'=> $resultstable['apply_status']
    );


    array_push($arrVal, $name);
    $i++;
}
echo  json_encode($arrVal);

?>
