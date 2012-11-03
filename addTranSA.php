<?	
	$title = 'Сдать в СА';
	include_once "header.php";
	$team = $_POST["team"];
	$lastName = $_POST["plays"];
if (empty($team)){
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

$sql = "SELECT pls FROM teams  WHERE tName = '$team'";
$result = mysql_query($sql, $db);
$players = 0;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if($col=='pls'){
			$players = $val;
		}
	}
}
if ($players<=$minpls){
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="index.php";', 5000 );
	</script>
	<h3><center>Игрок не может покинуть вашу команду, так как в ней минимальное количество игроков</h3></center>
HERE;
	include "footer.php";
	die();
	
}
$zr = 0;
$sql = "SELECT zarp,price FROM players WHERE name = '$lastName' AND team = '$team'";
$result = mysql_query($sql, $db);
$zr = mysql_fetch_assoc($result);
$dolg = 0;
if ($prtransfers){
	$dolg = $zr[zarp]/2;
}
$price= $zr[price]/2;
$sql = "UPDATE teams SET budget = budget + $price, limitout = limitout+1, pls = pls-1, kZarp = kZarp - $zr[zarp], dolg = dolg+$dolg WHERE tName = '$team'";
mysql_query($sql);



$sql = <<<HERE
UPDATE players
SET 
	team = 'SA'
WHERE
	team = '$team' AND name = '$lastName' 
HERE;
mysql_query($sql);

print <<<HERE
<h3><center>Игрок сдан в СА</h3></center>
	<script type = "text/javascript">
	setTimeout( 'location="index.php";', 5000 );
	</script>
HERE;
	include "footer.php";
?>
