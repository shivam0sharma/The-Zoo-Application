<?php 
require_once('network.php');
 
$sql = "SELECT *  FROM `Animal`";
if($res = mysqli_query($ntwk, $sql)) {
//var_dump($res);
echo "<br />";
$arr = mysqli_fetch_assoc($res);
var_dump($arr);
 
}
else echo mysqli_error($ntwk);
?>