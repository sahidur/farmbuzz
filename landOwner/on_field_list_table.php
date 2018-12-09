<?php
require '../database.php';
require '../userinfo.php';

if( !isset($_SESSION['user_id']) ){
    header("Location: index.php");
}


$idsearch = 2;
$recordstable = $conn->prepare('SELECT DISTINCT  land_budget.location_name,field_profile.address,crop_profile.name,
  crop_profile.variety,
  on_field_crop.season
   from  crop_profile,land_budget JOIN field_profile JOIN user JOIN on_field_crop
    ON (land_budget.location_id = field_profile.location_id AND user.user_id =field_profile.user_id)
WHERE crop_profile.crop_id=on_field_crop.crop_id AND on_field_crop.season =crop_profile.season AND 
 user.user_id = :idsearch AND  user.usertype = 2');
$recordstable->bindParam(':idsearch', $idsearch);
$recordstable->execute();


$arrVal = array();

$i=1;
while ($resultstable = $recordstable->fetch(PDO::FETCH_ASSOC)) {

    $name = array(
        'num' => $i,
        'location'=> $resultstable['location_name'],
        'address'=> $resultstable['address'],
        'cropname'=> $resultstable['name'],
        'variety'=> $resultstable['variety'],
        'season'=> $resultstable['season']
    );


    array_push($arrVal, $name);
    $i++;
}
echo  json_encode($arrVal);

?>
