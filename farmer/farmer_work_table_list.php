<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}


$searchidfarmar = $_SESSION['user_id'];
$recordstable = $conn->prepare('SELECT  user.user_id,on_field_crop.id,land_budget.location_name, field_profile.address,
crop_profile.name,on_field_crop.season
 , crop_profile.variety FROM on_field_crop NATURAL  JOIN crop_profile,land_budget,
  field_profile JOIN user
    ON field_profile.user_id = user.user_id

WHERE field_profile.location_id =land_budget.location_id and on_field_crop.user_id = user.user_id and user.user_id =:searchidfarmar');
$recordstable->bindParam(':searchidfarmar', $searchidfarmar);
$recordstable->execute();


$arrVal = array();

$i=1;
while ($resultstable = $recordstable->fetch(PDO::FETCH_ASSOC)) {

    $name = array(
        'num' => $i,
        'id'=> $resultstable['id'],
        'lname'=> $resultstable['location_name'],
        'address'=> $resultstable['address'],
        'cropname'=> $resultstable['name'],
        'season'=> $resultstable['season'],
        'variety'=> $resultstable['variety'],

    );


    array_push($arrVal, $name);
    $i++;
}
echo  json_encode($arrVal);

?>
