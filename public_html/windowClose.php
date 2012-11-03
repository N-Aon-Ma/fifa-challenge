<?
include "bd.php";
if ($tCount==2){
	die();
}
$sql = "UPDATE config SET open=0,game=1 WHERE 1";
mysql_query($sql,$db);
$sql = "UPDATE teams SET limitin=0,limitout=0 WHERE 1";
mysql_query($sql,$db);
?>