<?
include("header.php");

$val1= $_GET['pos'];
print "$val1";
$sql = "SELECT pos,id	 FROM themes WHERE pos=$val1  ";
$result = mysql_query($sql, $db);

$val= $_POST['val1'];
$time = time();
print "c ".date("Y-m-d H:i:s",$time) ;

$name = $_POST['name'];
while ($row = mysql_fetch_assoc($result))
	$cqlid =$row["id"];
	
$pos=1;	
$id_themes=$cqlid;	
$author=$origin;
print "$author";	
$sql = <<<HERE
INSERT INTO `themes`(
 `name`,`author`, `pos`,`id_themes`) VALUES (
'$name','$author','$val1','$id_themes')
HERE;
mysql_query($sql);

echo "<meta http-equiv='Refresh' content='1; URL=themes.php?pos=$val1'></head><body>Все збс! Вы будете перемещены через 3 сек ";//перенаправляем пользователя
include ("footer.php");

?>