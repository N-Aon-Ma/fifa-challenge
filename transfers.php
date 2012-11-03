<?
	$title = 'Трансферный стол';
	include_once "header.php";
?>
<style type="text/css">
	TABLE {
    border-collapse: collapse; /* Убираем двойные линии между ячейками */
   text-align: center;
   }
   TH {
	font-size: 15px;
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
	include "footer.php";
	die();
}


$sql = "SELECT position,name,zarp,skill,price,team,id FROM transfers WHERE end = false AND pr = false ORDER BY transfers.skill DESC";
$result = mysql_query ($sql, $db);
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$i6 = 1;
$i7 = 1;
$pos = array();
$lName = array();
$skill = array();
$team = array();
$price = array();
$ID = array();
$zarp = array();
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		switch ($col){
			case 'position':
				$pos[$i1] = $val;
				$i1++;
				break;
			case 'name':
				$lName[$i2] = $val;
				$i2++;;
				break;
			case 'zarp':
				$zarp[$i3] = $val;
				$i3++;;
				break;
			case 'skill':
				$skill[$i4] = $val;
				$i4++;
				break;
			case 'team':
				$team[$i5] = $val;
				$i5++;
				break;
			case 'price':
				$price[$i6] = $val;
				$i6++;
				break;
			case 'id':
				$ID[$i7] = $val;
				$i7++;
				break;
			default:
				print "Неудача";
		}
	}
}


print <<<HERE
<center><h3>Доступные трансферы</h3></center>
<table border = 1 width = 100% cellpadding = 5>
<tr>
<th> Позиция </th>
<th> Имя </th>
<th> Скилл </th>
<th> Зарплата </th>
<th> Цена </th>
<th> Откуда </th>
<th> Действие </th>
</tr>
HERE;
for ($i = 1; $i<$i1; $i++){
	$zarplata = number_format($zarp[$i],0,'',' ');
	$tsena = number_format($price[$i],0,'',' ');	
	print <<<HERE
	<tr>
		<td>$pos[$i]</td>
		<td>$lName[$i]</td>
		<td>$skill[$i]</td>
        <td>$zarplata</td>
		<td>$tsena</td>
		<td>$team[$i]</td>
HERE;
	if ($team[$i]!=$koma){
	print <<<HERE
	<form name = 'buy$i' action = 'buy.php' method = 'post'>	  
	<input type = 'hidden' name = 'number' value = "$ID[$i]">
	<input type = 'hidden' name = 'price' value = "$price[$i]">
	<td>
	<input type = 'submit' value = "Купить">
	</form>
	</td>
	</tr>
HERE;
	} else {
	print <<<HERE
	<form name = 'otm$i' action = 'otm.php' method = 'post'>	  
	<input type = 'hidden' name = 'number' value = "$ID[$i]">
	<td>
	<input type = 'submit' value = "Отменить">
	</form>
	</td>
	</tr>
HERE;
	}

}
	print "</table>";
	
	
$sql = "SELECT position,name,zarp,skill,price,team,id,newTeam FROM transfers WHERE end = false AND pr = true ORDER BY transfers.skill DESC";
$result = mysql_query ($sql, $db);
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$i6 = 1;
$i7 = 1;
$i8 = 1;
$nt1 = array();
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		switch ($col){
			case 'position':
				$pos1[$i1] = $val;
				$i1++;
				break;
			case 'name':
				$lName1[$i2] = $val;
				$i2++;
				break;
			case 'zarp':
				$zarp1[$i3] = $val;
				$i3++;;
				break;
			case 'skill':
				$skill1[$i4] = $val;
				$i4++;
				break;
			case 'team':
				$team1[$i5] = $val;
				$i5++;
				break;
			case 'price':
				$price1[$i6] = $val;
				$i6++;
				break;
			case 'id':
				$ID1[$i7] = $val;
				$i7++;
				break;
			case 'newTeam':
				$nt1[$i8] = $val;
				$i8++;
				break;
			default:
				print "Неудача";
		}
	}
}


print <<<HERE
<center><h3>Прямые трансферы</h3></center>
<table border = 1 width = 100% cellpadding = 5>
<tr>
<th> Позиция </th>
<th> Имя </th>
<th> Скилл </th>
<th> Зарплата </th>
<th> Цена </th>
<th> Откуда </th>
<th> Куда </th>
<th> Купить </th>
</tr>
HERE;
for ($i = 1; $i<$i1; $i++){
	$zarplata1 = number_format($zarp1[$i],0,'',' ');
	$tsena1 = number_format($price1[$i],0,'',' ');
	print <<<HERE
	<tr>
		<td>$pos1[$i]</td>
		<td>$lName1[$i]</td>
        <td>$skill1[$i]</td>
		<td>$zarplata1</td>
		<td>$tsena1</td>
		<td>$team1[$i]</td>
		<td>$nt1[$i]</td>
HERE;
	if ($team1[$i]!=$koma){
	print <<<HERE
	<form name = 'nbuy$i' action = 'buyPr.php' method = 'post'>	
	<input type = 'hidden' name = 'number' value = "$ID1[$i]">
	<input type = 'hidden' name = 'team' value = "$team1[$i]">
	<input type = 'hidden' name = 'nt' value = "$nt1[$i]">
	<input type = 'hidden' name = 'price' value = "$price1[$i]">
	<td>
	<input type = 'submit' value = "Купить">
	</form>
	</td>
	</tr>
HERE;
	} else{
	print <<<HERE
	<form name = 'notm$i' action = 'otm.php' method = 'post'>	
	<input type = 'hidden' name = 'number' value = "$ID1[$i]">
	<td>
	<input type = 'submit' value = "Отменить">
	</form>
	</td>
	</tr>
HERE;
	}
}
	print "</table>";	
	
	

$sql = "SELECT position,name,zarp,skill,price,team,newTeam FROM transfers WHERE end = true ORDER BY transfers.skill DESC";
$result = mysql_query ($sql, $db);
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$i6 = 1;
$i7 = 1;
$newTeam2 = array();
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		switch ($col){
			case 'position':
				$pos2[$i1] = $val;
				$i1++;
				break;
			case 'name':
				$lName2[$i2] = $val;
				$i2++;
				break;
			case 'zarp':
				$zarp2[$i3] = $val;
				$i3++;;
				break;
			case 'skill':
				$skill2[$i4] = $val;
				$i4++;
				break;
			case 'team':
				$team2[$i5] = $val;
				$i5++;
				break;
			case 'price':
				$price2[$i6] = $val;
				$i6++;
				break;
			case 'newTeam':
				$newTeam2[$i7] = $val;
				$i7++;
				break;
			default:
				print "Неудача";
		}
	}
}


print <<<HERE
<center><h3><br>Состоявшиеся трансферы</h3></center>
<table border = 1 width = 100% cellpadding = 5>
<tr>
<th> Позиция </th>
<th> Имя </th>
<th> Скилл </th>
<th> Зарплата </th>
<th> Цена </th>
<th> Откуда </th>
<th> Куда </th>
</tr>
HERE;
for ($i = 1; $i<$i1; $i++){
	$zarplata2 = number_format($zarp2[$i],0,'',' ');
	$tsena2 = number_format($price2[$i],0,'',' ');
	print <<<HERE
	<tr>
		<td>$pos2[$i]</td>
		<td>$lName2[$i]</td>
		<td>$skill2[$i]</td>
		<td>$zarplata2</td>
		<td>$tsena2</td>
		<td>$team2[$i]</td>
		<td>$newTeam2[$i]</td>
	</tr>
HERE;

}
	print "</table> <br><br>";	
	include "footer.php";	
?>