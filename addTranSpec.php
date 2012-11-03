<?
	$title = "Продать игрока";
	include_once "header.php";
	$team = $_POST["team"];
	$lastName = $_POST["plays"];
	$price = $_POST["tsena"];
	$st = $_POST["tms"];
if (empty($price)){
		print "<h3><center>Некорректный переход на страницу</center></h3>";
		die();
	}
$sql = "SELECT limitout FROM teams  WHERE tName = '$team'";
$result = mysql_query($sql, $db);
$lim = 0;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$lim = $val;
	}
}
if ($lim>=$limitout){
$sql = "DELETE FROM transfers WHERE team='$team' AND end=false";
mysql_query($sql,$db);
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="index.php";', 5000 );
	</script>
	<h3><center>Вы исчерпали лимит по продаже игроков</h3></center>
HERE;
	include "footer.php";
	die();
}

$sql = "SELECT limitin FROM teams  WHERE tName = '$st'";
$result = mysql_query($sql, $db);
$limin = 0;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$limin = $val;
	}
}
if ($limin>=$limitin){
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="index.php";', 5000 );
	</script>
	<h3><center>Вы не можете продать игрока этой команде, так как у неё исчерпан лимит на покупку игроков</h3></center>
HERE;
	include "footer.php";
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


$sql = "SELECT name, position, skill,zarp FROM players  WHERE name = '$lastName' AND team = '$team'";
$result = mysql_query($sql, $db);
$inf = mysql_fetch_assoc($result);

$sql = <<<HERE
INSERT INTO `transfers`(
`name`, `position`, `skill`, `team`, `price`, `newTeam`,`pr`,`zarp`) VALUES (
'$lastName', '$inf[position]',$inf[skill],'$team','$price','$st',true,$inf[zarp])
HERE;
mysql_query($sql);

print <<<HERE
<h3><center>Игрок выставлен на трансфер для команды 
HERE;
print $st;
print <<<HERE
. Сейчас вы перейдёте на трансферный стол</h3></center>
	<script type = "text/javascript">
	setTimeout( 'location="transfers.php";', 5000 );
	</script>
HERE;
include "footer.php";	
?>