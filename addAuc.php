<?
	$title = "Сделать ставку";
	include "header.php";
	include "trans.php";
	$position = $_POST["position"];
	$skill = $_POST["skill"];
	$link = $_POST["link"];
	$time = date('U');
if (empty($link)){
		print "<h3><center>Некорректный переход на страницу</center></h3>";
		include "footer.php";
		die();
	}
if ($transfers == 0){
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="auction.php";', 5000 );
	</script>
	<h3><center>Делать новые ставки сегодня уже нельзя</h3></center>
HERE;
	include "footer.php";
	die ();
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

$file = file_get_contents($link);
$fl = false;
$pos = strpos($file, 'class="ac" style');
$pos1 = strpos($file,'alt',$pos);
$pos2 = strpos($file,'"',$pos1+5);
$teamIz = substr($file,$pos1+5,$pos2-$pos1-5);
$pos = strpos($file, '<img src="http://www.transfermarkt.de/bilder/spielerfotos/somebody.jpg"');
if (!$pos){
	$fl = true;
	$pos = strpos($file, '<img src="http://www.transfermarkt.de/bilder/spielerfotos/');
}
if (!$fl){
	$foto = substr($file,$pos,71);
} else{
	$pp = strpos ($file,'width',$pos);
	$foto = substr($file,$pos,$pp-1-$pos);
	}
$foto = $foto.">";

$pos1 = strpos($file, 'What happened on ');
$dr = substr($file,$pos1+17,10);

$pos3 = strpos($file, 'country-name s10">');
$help = strpos($file,'<',$pos3+17);
$l = $help-$pos3-18;
$country = substr($file,$pos3+18,$l);
$country = htmlspecialchars($country,ENT_QUOTES);

$pos4 = strpos($file, 'note">');
$help1 = strpos($file,' ',$pos4+6);
$l1 = $help1-$pos4;
$new4 = substr($file,$pos4+6,$l1);
$help2 = strpos($new4,'&');
$l2 = strlen($new4)-$help2;
$help3 = substr($new4,0,$help2);
if (strlen($help3)<9){
	$price = $help3*1000;
} else{
	$price = $help3*1000000;
	}

$pos5 = strpos($file, '<h1 style="color:#fff;">');
$help4 = strpos($file,'<',$pos5+26);
$ff = substr($file, $pos5+26, 1);
$c = 26;
if ($ff==" "){
$c++;
}
$l3 = $help4-$pos5-$c;
$name = substr($file,$pos5+$c,$l3);
$name = htmlspecialchars($name,ENT_QUOTES);

$pos6 = strpos($file, '<td>1,');
$help5 = strpos($file,'<',$pos6+4);
$l4 = $help5-$pos6;
$height = substr($file,$pos6+4,$l4);
if (empty($name)||empty($price)||empty($foto)||empty($country)||empty($dr)||empty($height)||empty($teamIz)){
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="auction.php";', 5000 );
	</script>
	<h3><center>Некорректная ссылка</h3></center>
HERE;
	include "footer.php";
	die();
} 


$sql = "SELECT name FROM players  WHERE team!=''";
$result = mysql_query($sql, $db);
$lN1 = array();
$i1 = 1;
$uzhe1 = false;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if($col=='name'){
			$lN1[$i1] = $val;
			$i1++;
		}
	}
}
for ($i = 0; $i <= $i1; $i++){
	if($lN1[$i]==$name){
		$uzhe1 = true;
	}
}
if($uzhe1){
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="auction.php";', 5000 );
	</script>
	<h3><center>Этот игрок принадлежит команде из карьеры</h3></center>
HERE;
	include "footer.php";
	die();	
}

$sql = "SELECT name FROM active  WHERE 1";
$result = mysql_query($sql, $db);
$lN = array();
$tI = array();
$i1 = 1;
$i2 = 1;
$uzhe = false;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if($col=='name'){
			$lN[$i1] = $val;
			$i1++;
		}
	}
}
for ($i = 0; $i <= $i1; $i++){
	if($lN[$i]==$name){
		$uzhe = true;
	}
}
if($uzhe){
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="auction.php";', 5000 );
	</script>
	<h3><center>Этот игрок уже куплен или находится на аукционе</h3></center>
HERE;
	include "footer.php";
	die();	
}

	if ($skill<=70){
		$zr = 100000;
	}
	if ($skill>70&&$skill<=75){
		$zr = 250000;
	}
	if ($skill>75&&$skill<=78){
		$zr = 500000;
	}
	if ($skill>78&&$skill<=81){
		$zr = 1000000;
	}
	if ($skill>81&&$skill<=84){
		$zr = 2000000;
	}
	if ($skill>84&&$skill<=87){
		$zr = 3000000;
	}
	if ($skill>87&&$skill<=90){
		$zr = 4000000;
	}
	if ($skill>90){
		$zr = 5000000;
	}
$sql = <<<HERE
INSERT INTO `players`(
`position`, `name`, `skill`, `zarp`, `price`,`link`,`foto`,`country`,`dr`,`height`,`contract`) VALUES (
'$position','$name',$skill, $zr, '$price','$link','$foto','$country','$dr','$height',3)
HERE;
mysql_query($sql);
$sql = <<<HERE
INSERT INTO `active`
(`time`, `name`, `position`, `skill`, `price`, `teamIz`, `teamV`) VALUES 
($time,'$name','$position',$skill,$price,'$teamIz','$teamV')
HERE;
mysql_query($sql);
$sql = <<<HERE
UPDATE teams
SET limitin = limitin+1,
	budget = budget - $price
WHERE tName = '$teamV'
HERE;
mysql_query($sql);
print <<<HERE
<h3><center>Ставка сделана. Сейчас вы перейдёте на страницу аукциона</h3></center>
	<script type = "text/javascript">
	setTimeout( 'location="auction.php";', 5000 );
	</script>
HERE;
include "footer.php";
?>