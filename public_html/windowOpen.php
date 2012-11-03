<?
include "bd.php";
if ($tCount!=2){
	$sql = "UPDATE config SET tCount=2 WHERE 1";
	mysql_query($sql,$db);
	die();
} else{
	$sql = "UPDATE config SET tCount=1 WHERE 1";
	mysql_query($sql,$db);
}
$sql = "UPDATE config SET open=1,game=0 WHERE 1";
mysql_query($sql,$db);
if ($prtransfers){
	$sql = "UPDATE config SET prtransfers=0,roundl=1 WHERE 1";
	mysql_query($sql,$db);
} else{
	$sql = "UPDATE config SET prtransfers=1,roundl=2 WHERE 1";
	mysql_query($sql,$db);
}
?>