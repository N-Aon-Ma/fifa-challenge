<?
	$title = 'Выставить на трансфер';
	include_once "header.php";
	$team = $_POST["team"];
	$lastName = $_POST["plays"];
	$price = $_POST["tsena"];

	if (empty($price)){
		print "<h3><center>Некорректный переход на страницу</center></h3>";
		die();
	}
$sql = "SELECT name, team FROM transfers  WHERE 1";
$result = mysql_query($sql, $db);
$allln = array();
$allteam = array();
$i1 = 0;
$i2 = 0;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='name'){
			$allln[$i1] = $val;
			$i1++;
		}
		if ($col=='team'){
			$allteam[$i2] = $val;
			$i2++;
		}
	}
}
for ($i = 0; $i <= $i2; $i++){
	if ($allln[$i]=="$lastName"&&$allteam[$i]=="$team"){
		print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="index.php";', 5000 );
	</script>
	<h3><center>Этот игрок уже выставлен на трансфер</h3></center>
HERE;
	include "footer.php";
	die();
	}
}


$sql = "SELECT * FROM players  WHERE name = '$lastName' AND team = '$team'";
$result = mysql_query($sql, $db);
$inf = mysql_fetch_assoc($result);
$sql = <<<HERE
INSERT INTO `transfers`(
`name`, `position`, `skill`, `team`, `zarp`,`price`) VALUES (
'$lastName','$inf[position]',$inf[skill],'$team',$inf[zarp],'$price')
HERE;
mysql_query($sql);

print <<<HERE
<h3><center>Игрок выставлен на трансфер. Сейчас вы перейдёте на трансферный стол</h3></center>
	<script type = "text/javascript">
	setTimeout( 'location="transfers.php";', 5000 );
	</script>
HERE;
include "footer.php";
?>