<?
	$title = "Прямая покупка";
	include_once "header.php";
	$num = $_POST["number"];//ID трансферы
	$price = $_POST["price"];
	$nt = $_POST["nt"];
	$team = $_POST["team"];
if (empty($price)){
		print "<h3><center>Некорректный переход на страницу</center></h3>";
		die();
	}
$lName = "";
$sql = "SELECT name FROM transfers  WHERE id = $num";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$lName = $val;
	}
}

if ($koma!=$nt){
	print <<<HERE
	
	<h3><center>Этот трансфер предназначен другой команде</h3></center>
HERE;
	include "footer.php";
	die();
}

$sql = "SELECT budget,limitin FROM teams  WHERE tName = '$nt'";
$result = mysql_query($sql, $db);
$bud = 0;
$lim = 0;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if($col=='budget'){
			$bud = $val;
		}
		if($col=='limitin'){
			$lim = $val;
		}
	}
}
if ($bud<$price){
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="transfers.php";', 5000 );
	</script>
	<h3><center>В вашем бюджете недостаточно средств для покупки этого игрока</h3></center>
HERE;
	include "footer.php";
	die();
	
}
if ($lim>=$limitin){
$sql = "DELETE FROM transfers WHERE newTeam='$nt' AND end=false";
mysql_query($sql,$db);
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="transfers.php";', 5000 );
	</script>
	<h3><center>Вы исчерпали лимит по покупке игроков</h3></center>
HERE;
	include "footer.php";
	die();
}

$sql = "SELECT limitout,pls FROM teams  WHERE tName = '$team'";
$result = mysql_query($sql, $db);
$limout = 0;
$plays = 0;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if($col=='limitout'){
			$limout = $val;
		}
		if($col=='pls'){
			$plays = $val;
		}
	}
}
if ($plays<=$minpls){
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="transfers.php";', 5000 );
	</script>
	<h3><center>Этот игрок не может покинуть прежнюю команду, так как в ней минимальное количество игроков</h3></center>
HERE;
	include "footer.php";
	die();
	
}
if ($limout>=$limitout){
$sql = "DELETE FROM transfers WHERE team='$team' AND end=false";
mysql_query($sql,$db);
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="transfers.php";', 5000 );
	</script>
$team
	<h3><center>Этот игрок не может покинуть прежнюю команду, так как она исчерпала лимит по продаже игроков</h3></center>
HERE;
	include "footer.php";
	die();
	
}
$zr = 0;
$sql = "SELECT zarp FROM players WHERE name = '$lName' AND team = '$team'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$zr = $val;
	}
}

$dolg = 0;
if ($prtransfers){
	$dolg = $zr/2;
}
$sql = "UPDATE teams SET budget = budget - $price, limitin = limitin+1, pls = pls+1, kZarp = kZarp + $zr, dolg = dolg-$dolg WHERE tName = '$nt'";
mysql_query($sql);

$sql = "UPDATE teams SET budget = budget + $price, limitout = limitout+1, pls = pls-1, kZarp = kZarp - $zr, dolg = dolg+$dolg WHERE tName = '$team'";
mysql_query($sql);

$sql = "UPDATE players SET team = '$nt' WHERE team = '$team' AND name = '$lName'";
mysql_query($sql);

$sql = "UPDATE transfers SET end = true WHERE id = $num";
mysql_query($sql);
	echo "<h3><center>Поздравляем! Вы удачно приобрели игрока</h3></center>";
	include "footer.php";
?>