<?
	$title = 'Купить игрока';
	include_once "header.php";;
	$num = $_POST["number"];
	$price = $_POST["price"];
	if (empty($price)){
		print "<h3><center>Некорректный переход на страницу</center></h3>";
		die();
	}
$kon = false;
$teamIz = "";
$lName = "";
$sql = "SELECT end,team,name FROM transfers  WHERE id = $num";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=="end"){
		$kon = $val;
		}
		if ($col=="team"){
		$teamIz = $val;
		}
		if ($col=="name"){
		$lName = $val;
		}
	}
}
if ($kon){
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="transfers.php";', 5000 );
	</script>
	<h3><center>Вы опоздали. Игрок уже куплен</h3></center>
HERE;
	include "footer.php";
	die();
}



$sql = "SELECT budget,limitin,tName FROM teams  WHERE coach = '$origin'";
$result = mysql_query($sql, $db);
$bud = 0;
$lim = 0;
$teamV = "";
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if($col=='budget'){
			$bud = $val;
		}
		if($col=='limitin'){
			$lim = $val;
		}
		if($col=='tName'){
			$teamV = $val;
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
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="transfers.php";', 5000 );
	</script>
	<h3><center>Вы исчерпали лимит по покупке игроков</h3></center>
HERE;
	include "footer.php";
	die();
}

$sql = "SELECT limitout,pls FROM teams  WHERE tName = '$teamIz'";
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
	<h3><center>Этот игрок не может покинуть прежнюю команду, так как в ней минимальное число игроков</h3></center>
HERE;
	include "footer.php";
	die();
	
}
if ($limout>=$limitout){
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="transfers.php";', 5000 );
	</script>
	<h3><center>Этот игрок не может покинуть прежнюю команду, так как она исчерпала лимит по продаже игроков</h3></center>
HERE;
$sql = "DELETE FROM transfers WHERE team='$teamIz' AND end=false";
mysql_query($sql);
include "footer.php";
	die();
	
}
$zr = 0;
$sql = "SELECT zarp FROM players WHERE name = '$lName' AND team = '$teamIz'";
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
$sql = "UPDATE teams SET budget = budget - $price, limitin = limitin+1, pls = pls+1, kZarp = kZarp + $zr, dolg = dolg-$dolg WHERE tName = '$teamV'";
mysql_query($sql);

$sql = "UPDATE teams SET budget = budget + $price, limitout = limitout+1, pls = pls-1, kZarp = kZarp - $zr, dolg = dolg+$dolg WHERE tName = '$teamIz'";
mysql_query($sql);

$sql = "UPDATE players SET team = '$teamV' WHERE team = '$teamIz' AND name = '$lName'";
mysql_query($sql);

$sql = "UPDATE transfers SET end = true, newTeam = '$teamV' WHERE id = $num";
mysql_query($sql);
	die("<h3><center>Поздравляем! Вы удачно приобрели игрока</h3></center>");

	include "footer.php";
?>