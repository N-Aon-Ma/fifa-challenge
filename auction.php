<?
	$title = "Аукцион";
	include_once "header.php";
	include "trans.php"; 
?>
<script type = "text/javascript">
function fail(){
	var pos = document.auc.position.value;
	var skill = document.auc.skill.value;
	var link = document.auc.link.value;
	if (pos!="N/A"&&skill!="N/A"&&link!=""){
		return true;
	}else{
		alert("Введите все параметры");
		return false;
	}
}
</script>
<style type="text/css">
   TABLE {
    border-collapse: collapse; /* Убираем двойные линии между ячейками */
   text-align: center;
   }
     TH {
	font-size: 14px;
   }
   TD {
	font-size: 12px;
   }
   
  </style>
<?
  if(!$open||($koma==''&&$group!='admin')){
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="index.php";', 5000 );
	</script>
	<h3><center>Трансферное окно закрыто</h3></center>
HERE;
	include_once "footer.php";
	die();
}

if ($transfers!=0){
print <<<HERE
<center><h3>Сделать ставку на нового игрока</h3></center>
<form name = "auc" action = "addAuc.php" method = "post" onsubmit = "return fail()">
<table border = 1 width = 100% cellpadding = 7>
<tr>
	<th>Позиция</th>
	<th>Скилл</th>
	<th>Ссылка</th>
	<th>Ставка</th>
</tr>
	<tr>
	<td> <select name = "position" id="position">
		<option value = "N/A">N/A</option>
		<option value = "GK">ВРТ</option>
		<option value = "LWB">ЛФЗ</option>
		<option value = "LB">ЛЗ</option>
		<option value = "CB">ЦЗ</option>
		<option value = "RB">ПЗ</option>
		<option value = "RWB">ПФЗ</option>
		<option value = "CDM">ЦОП</option>
		<option value = "LM">ЛП</option>
		<option value = "CM">ЦП</option>
		<option value = "RM">ПП</option>
		<option value = "LWM">ЛФА</option>
		<option value = "CAM">ЦАП</option>
		<option value = "RWM">ПФА</option>
		<option value = "CF">ЦФД</option>
		<option value = "ST">ФРВ</option>
	</td>	
	<td> <select name = "skill" id = "skill">
		<option value = "N/A">N/A</option>
HERE;
	
			for ($i = 99; $i>=50; $i--){
				print '<option value = "';
				print $i;
				print '">';
				print $i;
				print '</option>';
			}
		print <<<HERE
		</select></td>
	<td><input type = "text"  name = "link" id = "link" size="24" maxlength="300" value="">
	</td>
	<td ><input type = "submit" value = "Сделать ставку"><br></td>
</tr>	
</table>
</form>
HERE;

$end = array();
$today = date('U') - 3600;
$sql = "SELECT ID, time, name,teamIz, position, skill, price,teamV FROM active WHERE end = false ORDER BY active.time ASC";
$result = mysql_query ($sql, $db);
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$i6 = 1;
$i7 = 1;
$i8 = 1;
$pos = array();
$lName = array();
$skill = array();
$teamIz = array();
$teamV = array();
$time = array();
$min = array();
$sec = array();
$ID = array();
$price = array();
$link = array();
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		switch ($col){
			case 'ID':
				$ID[$i6] = $val;
				$i6++;
				break;
			case 'time':
				$time[$i7] = $val;
				if ($time[$i7]<=$today){
					$end[$i7] = true;
				}
				$i7++;
				break;
			case 'name':
				$lName[$i1] = $val;
				$i1++;
				break;
			case 'teamIz':
				$teamIz[$i2] = $val;
				$i2++;
				break;
			case 'position':
				$pos[$i3] = $val;
				$i3++;
				break;
			case 'skill':
				$skill[$i4] = $val;
				$i4++;
				break;
			case 'price':
				$price[$i5] = $val;
				$i5++;
				break;
			case 'teamV':
				$teamV[$i8] = $val;
				$i8++;
				break;
			default:
				print "Неудача";
		}
	}
}
for ($i = 1; $i < $i7; $i++){
	if ($end[$i]){
	$zr = 0;
	if ($skill[$i]<=70){
		$zr = 100000;
	}
	if ($skill[$i]>70&&$skill[$i]<=75){
		$zr = 250000;
	}
	if ($skill[$i]>75&&$skill[$i]<=78){
		$zr = 500000;
	}
	if ($skill[$i]>78&&$skill[$i]<=81){
		$zr = 1000000;
	}
	if ($skill[$i]>81&&$skill[$i]<=84){
		$zr = 2000000;
	}
	if ($skill[$i]>84&&$skill[$i]<=87){
		$zr = 3000000;
	}
	if ($skill[$i]>87&&$skill[$i]<=90){
		$zr = 4000000;
	}
	if ($skill[$i]>90){
		$zr = 5000000;
	}
	$dolg = 0;
	if ($transfers==1){
		$dolg = $zr/2;
	}
	
	$sql = <<<HERE
UPDATE active
SET
	end = true
WHERE
	ID = $ID[$i]
HERE;
mysql_query($sql);
	
$sql = <<<HERE
UPDATE teams
SET
	pls = pls + 1,
	kZarp = kZarp + $zr,
	dolg = dolg - $dolg
WHERE
	tName = '$teamV[$i]'
HERE;
mysql_query($sql);	

	$sql = "UPDATE players SET team = '$teamV[$i]' WHERE name = '$lName[$i]' AND (team='SA' OR team='')";
	mysql_query($sql);
	}
}

$sql = "SELECT ID,position,name,skill,price,teamIz,teamV,time FROM active WHERE end = false ORDER BY active.time ASC";
$result = mysql_query ($sql, $db);
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$i6 = 1;
$i7 = 1;
$i8 = 1;
$i9 = 1;
$i10 = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		switch ($col){
			case 'ID':
				$ID1[$i8] = $val;
				$i8++;
				break;
			case 'position':
				$pos1[$i1] = $val;
				$i1++;
				break;
			case 'name':
				$lName1[$i3] = $val;
				$i3++;;
				break;
			case 'skill':
				$skill1[$i4] = $val;
				$i4++;
				break;
			case 'teamIz':
				$teamIz1[$i5] = $val;
				$i5++;
				break;
			case 'teamV':
				$teamV1[$i6] = $val;
				$i6++;
				break;
			case 'time':
				$time1[$i7] = $val;
				$i7++;
				break;
			case 'price':
				$price1[$i2] = $val;
				$i2++;
				break;	
			default:
				print "Неудача";
		}
	}
}


print <<<HERE
<center><h3>Текущие аукционы</h3></center>
<table border = 1 width = 100% cellpadding = 5>
<tr>
<th>Поз</th>
<th>Имя</th>
<th>Скилл</th>
<th>Откуда</th>
<th>Куда</th>
<th>Цена</th>
<th>Время</th>
<th>Новая цена</th>
<th>Перебить</th>
</tr>
HERE;
for ($i = 1; $i<$i7; $i++){
	$time1[$i] = 3600 - date('U') + $time1[$i];
	$sec[$i] = $time1[$i]%60;
	$min[$i] = ($time1[$i]-$sec[$i])/60;
}
for ($i = 1; $i<$i1; $i++){
	$tsena = number_format($price1[$i],0,'',' ');
	print <<<HERE
	<tr>
		<td>$pos1[$i]</td>
		<td>$lName1[$i]</td>
		<td>$skill1[$i]</td>
		<td>$teamIz1[$i]</td>
		<td>$teamV1[$i]</td>
		<td width = 70px>$tsena</td>
		<td>
		
		<span id='timer$i'></span>
<script type='text/javascript'><!--
var min$i = $min[$i];
var sec$i = $sec[$i];
var timerid$i;
function timer$i()
{
  sec$i--; /* уменьшаем на одну секунду */
  if (sec$i<0) /* следующая минута */
  {
    sec$i = 59;
    min$i--;
  }
  var smin$i = ''+min$i;
  var ssec$i = ''+sec$i;
   if (smin$i.length<2) smin$i = '0'+smin$i; /* добавляем ведущие нули */
   if (ssec$i.length<2) ssec$i = '0'+ssec$i;
      document.getElementById('timer$i').innerHTML = smin$i+':'+ssec$i; /* и выводим на страницу текущее значение */
       if (min$i==0 && sec$i==0)
        {
          clearInterval(timerid$i); /* останавливаем таймер */
		  setTimeout ('location ="auction.php";',0000 );
        }
}
timerid$i = setInterval(timer$i,1000); /* запускаем таймер */
 --></script>
		
		</td>
	<form name = 'pereb$i' action = 'exchange.php' method = 'post' onsubmit = 'return fail$i()'>	
	<td>
	<input type = 'text' name = 'price' value = "" size = "12" maxlength = "15">
	</td>
	<input type = 'hidden' name = 'number' value = "$ID[$i]">
	<td>
	<input type = 'submit' value = "Перебить">
	</form>
	</td>
	</tr>
	
	<script type = "text/javascript">
function fail$i(){
	var price$i = document.pereb$i.price.value;
	nan$i = price$i - 0;
	var razn$i = nan$i - $price[$i]; 
	if (!isNaN(nan$i)&&razn$i>=100000){
		return true;
	}else{
		alert("Введите все параметры. Шаг цены - 100.000");
		return false;
	}
}
</script>
HERE;

}
	print "</table>";
} else {
$today = date('U') - 3600;
$sql = "SELECT ID,name,skill,price,teamV FROM active WHERE end = false";
$result = mysql_query ($sql, $db);
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$i6 = 1;
$i7 = 1;
$i8 = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		switch ($col){
			case 'ID':
				$ID2[$i6] = $val;
				$i6++;
				break;
			case 'name':
				$lName2[$i1] = $val;
				$i1++;
				break;
			case 'skill':
				$skill2[$i4] = $val;
				$i4++;
				break;
			case 'price':
				$price2[$i5] = $val;
				$i5++;
				break;
			case 'teamV':
				$teamV2[$i8] = $val;
				$i8++;
				break;
			default:
				print "Неудача";
		}
	}
}
for ($i = 1; $i < $i1; $i++){
	$zr = 0;
	if ($skill2[$i]<=70){
		$zr = 100000;
	}
	if ($skill2[$i]>70&&$skill2[$i]<=75){
		$zr = 250000;
	}
	if ($skill2[$i]>75&&$skill2[$i]<=78){
		$zr = 500000;
	}
	if ($skill2[$i]>78&&$skill2[$i]<=81){
		$zr = 1000000;
	}
	if ($skill2[$i]>81&&$skill2[$i]<=84){
		$zr = 2000000;
	}
	if ($skill2[$i]>84&&$skill2[$i]<=87){
		$zr = 3000000;
	}
	if ($skill2[$i]>87&&$skill2[$i]<=90){
		$zr = 4000000;
	}
	if ($skill2[$i]>90){
		$zr = 5000000;
	}
	$dolg = 0;
	if ($transfers==1){
		$dolg = $zr/2;
	}
	
	$sql = <<<HERE
UPDATE active
SET
	end = true
WHERE
	ID = $ID2[$i]
HERE;
mysql_query($sql);
	
$sql = <<<HERE
UPDATE teams
SET
	pls = pls + 1,
	kZarp = kZarp + $zr,
	dolg = dolg - $dolg
WHERE
	tName = '$teamV2[$i]'
HERE;
mysql_query($sql);	

	$sql = "UPDATE players SET team = '$teamV2[$i]' WHERE name = '$lName2[$i]' AND (team='SA' OR team='')";
	mysql_query($sql);
}
}	
	
	
$sql = "SELECT position,name,skill,price,teamIz,teamV FROM active WHERE end = true ORDER BY active.skill DESC";
$result = mysql_query ($sql, $db);
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$i6 = 1;
$i7 = 1;
$i8 = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		switch ($col){
			case 'position':
				$pos3[$i1] = $val;
				$i1++;
				break;
			case 'name':
				$lName3[$i3] = $val;
				$i3++;;
				break;
			case 'skill':
				$skill3[$i4] = $val;
				$i4++;
				break;
			case 'teamIz':
				$teamIz3[$i5] = $val;
				$i5++;
				break;
			case 'teamV':
				$teamV3[$i6] = $val;
				$i6++;
				break;
			case 'price':
				$price3[$i7] = $val;
				$i7++;
				break;	
			default:
				print "Неудача";
		}
	}
}


print <<<HERE
<center><h3>Завершённые аукционы</h3></center>
<table border = 1 width = 100% cellpadding = 3>
<tr>
<th> Позиция </th>
<th> Имя </th>
<th> Скилл </th>
<th> Цена</th>
<th> Откуда </th>
<th> Куда </th>
</tr>
HERE;
for ($i = 1; $i<$i1; $i++){
	$tsena3 = number_format($price3[$i],0,'',' ');
	print <<<HERE
	<tr>
		<td>$pos3[$i]</td>
		<td>$lName3[$i]</td>
		<td>$skill3[$i]</td>
		<td width = 70px>$tsena3</td>
		<td>$teamIz3[$i]</td>
		<td>$teamV3[$i]</td>
		</tr>
HERE;
}		
print "</table>";
include "footer.php";
?>