<?
	$title = "Состав";
	include ("header.php");
	$team = $_POST["team"];
?>
<center>
<?
print 'Через 3 секунды вы будете автоматичеcки перенаправлены. Нажмите <a href="teams.php?id=';
print $team;
print '">перейти</a>, если вы не хотите ждать.';
?>
</center>
<?
$position = array();
$link = array();
$skill = array();
$zarp = array();
$contract = array();
$kZarp = 0;
$sponsor = $_POST["sponsor"];
for ($j = 1; $j<=$pls; $j++){
	$position[$j] = $_POST["position$j"];
	$link[$j] = $_POST["link$j"];
	$skill[$j] = $_POST["skill$j"];
	$contract[$j] = $_POST["contract$j"];
	if ($skill[$j]<=70){
		$zr = 100000;
	}
	if ($skill[$j]>70&&$skill[$j]<=75){
		$zr = 250000;
	}
	if ($skill[$j]>75&&$skill[$j]<=78){
		$zr = 500000;
	}
	if ($skill[$j]>78&&$skill[$j]<=81){
		$zr = 1000000;
	}
	if ($skill[$j]>81&&$skill[$j]<=84){
		$zr = 2000000;
	}
	if ($skill[$j]>84&&$skill[$j]<=87){
		$zr = 3000000;
	}
	if ($skill[$j]>87&&$skill[$j]<=90){
		$zr = 4000000;
	}
	if ($skill[$j]>90){
		$zr = 5000000;
	}
	$zarp[$j] = $zr;
	$kZarp += $zarp[$j];
}

for ($j = 1; $j<=$pls; $j++){


$fl = false;
$file = file_get_contents($link[$j]);
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

$pos6 = strpos($file, '<td>1,');
$help5 = strpos($file,'<',$pos6+4);
$l4 = $help5-$pos6;
$height = substr($file,$pos6+4,$l4);



$sql = <<<HERE
INSERT INTO `players`(
`position`, `name`, `skill`, `zarp`, `team`,`price`,`link`,`foto`,`country`,`dr`,`height`,`contract`) VALUES (
'$position[$j]','$name',$skill[$j], $zarp[$j], '$team','$price','$link[$j]','$foto','$country','$dr','$height','$contract[$j]')
HERE;
mysql_query($sql);
}
$bud = 100000000-$kZarp*2;
$sql = "UPDATE teams SET done = true, pls = 23,sponsor = '$sponsor', kZarp = $kZarp, budget = $bud WHERE tName = '$team'";
mysql_query($sql);
 
print <<<HERE
<script type = "text/javascript">
	setTimeout( 'location="
HERE;
print $team;
print <<<HERE
.php";', 3000 );
	</script>
HERE;
?>
</body>
</html>	