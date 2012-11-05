<?
include("header.php");
//include("addforums.php");
$sql = "SELECT id,pos	 FROM forums  ";
$result = mysql_query($sql, $db);


$description = $_POST['description'];

$name = $_POST['name'];
while ($row = mysql_fetch_assoc($result))
	foreach ($row as $col=>$val)
	
if($col=='id'){
 "$val";

$pos=$val;}
	
	$id_forums=12;
$sql = <<<HERE
INSERT INTO `forums`(
 `name`, `description`, `pos`) VALUES (
'$name','$description','$pos')
HERE;
mysql_query($sql);


echo "<meta http-equiv='Refresh' content='3; URL=forum.php'></head><body>Ваше сообщение отправлено! Вы будете перемещены через 3 сек ";//перенаправляем пользователя

include ("footer.php");
?>