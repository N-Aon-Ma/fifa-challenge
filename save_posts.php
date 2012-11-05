<?
include("header.php");
//include("post_forums.php");

$valr = $_GET['id_themes'];
$sql = "SELECT id	 FROM posts  ";
$result = mysql_query($sql, $db);
$val1= $_GET['id_themes'];
//print "$val1 d";
//$description = $_POST['name'];

$name = $_POST['name'];
//	$id_forums=12;
$author=$origin;
if(!empty($name)){
$sql = <<<HERE

INSERT INTO `posts`(
 `name`,`id_themes`,`author`) VALUES (
'$name','$valr','$author')
HERE;
mysql_query($sql);
}
echo "<meta http-equiv='Refresh' content='0; URL=post_forums.php?id_themes=$val1'></head><body>обновление ";//перенаправляем пользователя
include ("footer.php");

?>