<?
	$title = 'Отменить';
	include_once "header.php";;
	$num = $_POST["number"];
	if (empty($num)){
		print "<h3><center>Некорректный переход на страницу</center></h3>";
		include "footer.php";
                die();
	}

$sql = "DELETE FROM transfers WHERE id=$num";
mysql_query($sql);
	echo "<h3><center>Игрок убран с трансферного стола</h3></center>";
	include "footer.php";
	die();
?>