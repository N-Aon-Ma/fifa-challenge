<?
include "bd.php";
if ($sCount!=4){
	die();
} 
$sql = "UPDATE config SET game=0 WHERE 1";
mysql_query($sql,$db);
?>