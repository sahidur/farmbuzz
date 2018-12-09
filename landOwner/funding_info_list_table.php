<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}


$idsearch = $_SESSION['user_id'];
$recordstable = $conn->prepare('SELECT apply_fund.apply_id,field_profile.address,test_lab.approximately_budget,
apply_fund.apply_status from 
 field_profile JOIN apply_fund JOIN test_lab
    ON (field_profile.field_id = apply_fund.field_id)
WHERE  field_profile.user_id =:idsearch');
$recordstable->bindParam(':idsearch', $idsearch);
$recordstable->execute();


$arrVal = array();

$i=1;
while ($resultstable = $recordstable->fetch(PDO::FETCH_ASSOC)) {

    $name = array(
        'num' => $i,
        'id'=> $resultstable['apply_id'],
        'address'=> $resultstable['address'],
        'budget'=> $resultstable['approximately_budget'],
        'status'=> $resultstable['apply_status']
    );


    array_push($arrVal, $name);
    $i++;
}
echo  json_encode($arrVal);

?>
