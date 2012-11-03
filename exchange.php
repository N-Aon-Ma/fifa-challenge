<?
	$title = "Сделать ставку";
	include "header.php";
	include "trans.php";
	$num = $_POST["number"];
	$price = $_POST["price"];
	$time = date('U');
	if (empty($price)){
		print "<h3><center>Некорректный переход на страницу</center></h3>";
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
	setTimeout( 'location="auction.php";', 5000 );
	</script>
	<h3><center>В вашем бюджете недостаточно средств для покупки этого игрока</h3></center>
HERE;
	include "footer.php";
	die();
	
}
if ($lim>=$limitin){
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="auction.php";', 5000 );
	</script>
	<h3><center>Вы исчерпали лимит по покупке игроков</h3></center>
HERE;
	include "footer.php";
	die();
}
$sql = "SELECT price,teamV FROM active WHERE ID = $num";
$result = mysql_query($sql, $db);
$tekPrice = 0;
$prTeam = "";
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if($col=='price'){
			$tekPrice = $val;
		}
		if($col=='teamV'){
			$prTeam = $val;
		}
	}
}
$tekPrice += 100000;
if ($tekPrice>$price){
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="auction.php";', 5000 );
	</script>
	<h3><center>Кто-то уже перебил ставку. Повысьте цену</h3></center>
HERE;
	include "footer.php";
	die();
}
$tekPrice -= 100000;
	$sql = <<<HERE
UPDATE active
SET
	time = $time,
	teamV = '$teamV',
	price = $price
WHERE
	ID = $num
HERE;
mysql_query($sql);
	
	$sql = <<<HERE
UPDATE teams
SET
	limitin = limitin + 1,
	budget = budget - $price
WHERE
	tName = '$teamV'
HERE;
mysql_query($sql);

	$sql = <<<HERE
UPDATE teams
SET
	limitin = limitin - 1,
	budget = budget + $tekPrice
WHERE
	tName = '$prTeam'
HERE;
mysql_query($sql);

print "<h3><center>Ставка перебита. Сейчас вы перейдёте на страницу аукциона</center></h3>";
include "footer.php";
?>
<script type = "text/javascript">
setTimeout( 'location="auction.php";', 3000 );
	</script>