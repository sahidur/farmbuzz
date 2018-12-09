<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}

$recordstable = $conn->prepare('SELECT apply_fund.apply_id,field_profile.address from apply_fund
 NATURAL JOIN field_profile WHERE apply_fund.apply_status=\'No\'');

$recordstable->execute();


$arrVal = array();

$i=1;
while ($resultstable = $recordstable->fetch(PDO::FETCH_ASSOC)) {

    $name = array(
        'num' => $i,
        'applyid'=> $resultstable['apply_id'],
        'address'=> $resultstable['address']
    );


    array_push($arrVal, $name);
    $i++;
}
echo  json_encode($arrVal);

?>
