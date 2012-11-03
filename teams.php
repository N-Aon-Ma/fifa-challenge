<?
	if (isset($_GET['id'])) {$id =$_GET['id']; } //id "хозяина" странички
else
{ exit("Вы зашли на страницу без параметра!");} //если не указали id, то выдаем ошибку
	$teamName = $id;
	$title = $teamName;
	include "header.php";
	$sql = "SELECT tName FROM teams  WHERE tName = '$id'";
$result = mysql_query($sql, $db);
$tnm = "";
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$tnm = $val;
	}
}

?>
<script type = "text/javascript">
function fail(){
	var flag = true;
	var sponsor = document.getElementById('sponsor').value;
	var pos = new Array();
	var ln = new Array();
	var skill = new Array();
	for (var i = 1; i<=<? echo $pls ?>;i++){
		pos[i] = document.getElementById('position'+i).value;
		ln[i] = document.getElementById('link'+i).value;
		skill[i] = document.getElementById('skill'+i).value;
	}
	for (var j = 1; j<=<? echo $pls ?>;j++){
		if (pos[j]=='N/A'||ln[j]==''||skill[j]=='N/A'||sponsor=='N/A'){
			flag = false;
		}
	}
	if (!flag){
		alert("Необходимо внести все параметры для 23-ех игроков и выбрать спонсора");
	}
	return flag;
}	
</script>
<style type="text/css">
   TH {
   }
   TABLE {
    border-collapse: collapse; /* Убираем двойные линии между ячейками */
   text-align: center;
   }
    #content1 a:link {
    color: #4D7992; /* Цвет ссылок */
   }
   #content1 a:visited {
    color: #4D7992; /* Цвет посещенных ссылок */
   }
    .block1 { 
    width: 70%; 
    padding: 0px;
    float: left;
   }
   .block2 { 
    width: 28%; 
    padding: 0px; 
    float: right; 
	}
   
  </style>
<?
$leag = 'leaguea'.Goals;
$pl = 'leaguea'.Place;
$euro = "";
$ePlace = "";
$sql = "SELECT done FROM teams WHERE tName = '$teamName'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$done = $val;
	}
}
print "<table border = 0 align = center valign = center><tr><td><img style='margin: 0px 10px 0px 0px;padding:0;border:0;' src = 'images/";
print $teamName;
print ".png' height = 75px></td><td><h1>$teamName</h1></td></tr></table><br>";
	
if ($done==false){
$sql = "SELECT team FROM users WHERE email = '$_SESSION[email]'";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$team1 = $val;
	}
}
if ($team1!=$teamName){
	echo '<h3><center>Профиль команды не заполнен</h3></center>';
	include ("footer.php");
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="index.php";', 5000 );
	</script>
HERE;
die();
}
print <<<HERE
<form name = "add" action = "addPlayers.php" method = "post" onsubmit = "return fail()">
<table border = 1 align = 'center' >
<tr>
	<th>Позиция</th>
	<th>Ссылка</th>
	<th>Скилл</th>
	<th>Контракт</th>
</tr>
HERE;
	for ($j = 1; $j<=$pls; $j++){
	print <<<HERE
	<tr>
	<td> <select name = "position$j" id="position$j">
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
	<td><input type = "text"  name = "link$j" id = "link$j" size="50" maxlength="360" value="">
	</td>
	<td> <select name = "skill$j" id = "skill$j">
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
<td> <select name = "contract$j" id = "contract$j">
		<option value = 1>1 год</option>
		<option value = 2>2 года</option>
		<option value = 3>3 года</option>	
		</select></td>
		
</tr>
HERE;
	
	}
print <<<HERE
<tr>
	<th colspan = 2><center>Спонсор:</th><td colspan = 2>
	<select name = 'sponsor' id = 'sponsor'>
<option value = 'N/A'>N/A</option>
<option value = 'Adidas'>Adidas</option>
<option value = 'Philips'>Philips</option>
<option value = 'Nike'>Nike</option>
<option value = 'Reebok'>Reebok</option>
<option value = 'Etihad'>Etihad</option>
<option value = 'Gazprom'>Gazprom</option>
<option value = 'Fly Emirates'>Fly Emirates</option>
<option value = 'Samsung'>Samsung</option>
<option value = 'LG'>LG</option>
<option value = 'Pirelli'>Pirelli</option>
</select>
</td>
</tr>	
<tr>
	<th colspan = "4"> <center><input type = "submit"></center></th>
</tr>	
</table>
<input type="hidden" name = "team" value= "$teamName">
</form>

HERE;
} else {
	print "<div class= 'block1'><h3><center>Состав команды</center></h3>";
	$sql = "SELECT foto, name, position, skill, zarp, contract, price, country, dr, height, link FROM players WHERE team = '$teamName' AND position = 'GK' ORDER BY players.skill DESC";
	$result = mysql_query ($sql, $db);
	print "<table border = 1 align = 'left' width = 100%>\n";
	print "<tr>\n";
	$dolg = 0;
	$i = 1;
	$j = 1;
	$k = 1;
	$l = 1;
	$df[] = array();
	$mf[] = array();
	$st[] = array();
	$gk[] = array();
	/*foreach ($zag as $value){
		print "<th>$value</th>";
	}*/
	print "</tr><tr><th colspan = 5><center>ВРАТАРИ</center></th></tr><tr>";
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			if ($col=="link"){
				$gk[$i][$col]=$val;
				$i++;
			} else{
				$gk[$i][$col]=$val;
		
			}
		}
	}
	for ($i1=1;$i1<$i;$i1++){
		echo '
		<td rowspan = 6 width = 100px>'.$gk[$i1][foto].'</td>
		<td colspan = 4><font size=5><a href = "'.$gk[$i1][link].'">'.$gk[$i1][name].'</a></font></td></tr>
		<td>Позиция</td><td>'.$gk[$i1][position].'</td><td>Скилл</td><td>'.$gk[$i1][skill].'</td></tr>
		<tr><td>Страна</td><td>'.$gk[$i1][country].'</td><td>Зарплата</td><td>'.number_format($gk[$i1][zarp],0,'',' ').'</td></tr>
		<tr><td>Дата рождения</td><td>'.$gk[$i1][dr].'</td><td>Контракт</td><td>'.$gk[$i1][contract]; if ($gk[$i1][contract]==1){echo " год";} else{echo " года";} echo '</td></tr>
		<tr><td>Рост</td><td>'.$gk[$i1][height].'</td><td>Цена</td><td>'.number_format($gk[$i1][price],0,'',' ').'</td></tr></tr><tr></tr>';

	}
	$sql = "SELECT foto, name, position, skill, zarp, contract, price, country, dr, height, link FROM players WHERE team = '$teamName' AND position LIKE '%B' ORDER BY players.skill DESC";
	$result = mysql_query ($sql, $db);
	print "</tr><tr><th colspan = 5><center>ЗАЩИТНИКИ</center></th></tr><tr>";
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			if ($col=="link"){
				$df[$j][$col]=$val;
				$j++;
			} else{
				$df[$j][$col]=$val;
		
			}
		}
	}
	for ($j1=1;$j1<$j;$j1++){
		echo '
		<td rowspan = 6 width = 100px>'.$df[$j1][foto].'</td>
		<td colspan = 4><font size=5><a href = "'.$df[$j1][link].'">'.$df[$j1][name].'</a></font></td></tr>
		<td>Позиция</td><td>'.$df[$j1][position].'</td><td>Скилл</td><td>'.$df[$j1][skill].'</td></tr>
		<tr><td>Страна</td><td>'.$df[$j1][country].'</td><td>Зарплата</td><td>'.number_format($df[$j1][zarp],0,'',' ').'</td></tr>
		<tr><td>Дата рождения</td><td>'.$df[$j1][dr].'</td><td>Контракт</td><td>'.$df[$j1][contract]; if ($df[$j1][contract]==1){echo " год";} else{echo " года";} echo '</td></tr>
		<tr><td>Рост</td><td>'.$df[$j1][height].'</td><td>Цена</td><td>'.number_format($df[$j1][price],0,'',' ').'</td></tr></tr><tr></tr>';

	}
	$sql = "SELECT foto, name, position, skill, zarp, contract, price, country, dr, height, link FROM players WHERE team = '$teamName' AND position LIKE '%M' ORDER BY players.skill DESC";
	$result = mysql_query ($sql, $db);
		print "</tr><tr><th colspan = 5><center>ПОЛУЗАЩИТНИКИ</center></th></tr><tr>";
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			if ($col=="link"){
				$mf[$k][$col]=$val;
				$k++;
			} else{
				$mf[$k][$col]=$val;
		
			}
		}
	}
	for ($k1=1;$k1<$k;$k1++){
		echo '
		<td rowspan = 6 width = 100px>'.$mf[$k1][foto].'</td>
		<td colspan = 4><font size=5><a href = "'.$mf[$k1][link].'">'.$mf[$k1][name].'</a></font></td></tr>
		<td>Позиция</td><td>'.$mf[$k1][position].'</td><td>Скилл</td><td>'.$mf[$k1][skill].'</td></tr>
		<tr><td>Страна</td><td>'.$mf[$k1][country].'</td><td>Зарплата</td><td>'.number_format($mf[$k1][zarp],0,'',' ').'</td></tr>
		<tr><td>Дата рождения</td><td>'.$mf[$k1][dr].'</td><td>Контракт</td><td>'.$mf[$k1][contract]; if ($mf[$k1][contract]==1){echo " год";} else{echo " года";} echo '</td></tr>
		<tr><td>Рост</td><td>'.$mf[$k1][height].'</td><td>Цена</td><td>'.number_format($mf[$k1][price],0,'',' ').'</td></tr></tr><tr></tr>';

	}
	$sql = "SELECT foto, name, position, skill, zarp, contract, price, country, dr, height, link FROM players WHERE team = '$teamName' AND (position = 'ST' OR position = 'CF') ORDER BY players.skill DESC";
	$result = mysql_query ($sql, $db);
		print "</tr><tr><th colspan = 5><center>НАПАДАЮЩИЕ</center></th></tr><tr>";
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			if ($col=="link"){
				$st[$l][$col]=$val;
				$l++;
			} else{
				$st[$l][$col]=$val;
		
			}
		}
	}
	for ($l1=1;$l1<$l;$l1++){
		echo '
		<td rowspan = 6 width = 100px>'.$st[$l1][foto].'</td>
		<td colspan = 4><font size=5><a href = "'.$st[$l1][link].'">'.$st[$l1][name].'</a></font></td></tr>
		<td>Позиция</td><td>'.$st[$l1][position].'</td><td>Скилл</td><td>'.$st[$l1][skill].'</td></tr>
		<tr><td>Страна</td><td>'.$st[$l1][country].'</td><td>Зарплата</td><td>'.number_format($st[$l1][zarp],0,'',' ').'</td></tr>
		<tr><td>Дата рождения</td><td>'.$st[$l1][dr].'</td><td>Контракт</td><td>'.$st[$l1][contract]; if ($st[$l1][contract]==1){echo " год";} else{echo " года";} echo '</td></tr>
		<tr><td>Рост</td><td>'.$st[$l1][height].'</td><td>Цена</td><td>'.number_format($st[$l1][price],0,'',' ').'</td></tr></tr><tr></tr>';

	}
	print "</table><br><br></div><div class = 'block2'>";
	$sql = "SELECT coach,budget,kZarp, dolg, sponsor,pls FROM teams WHERE tName='$teamName'";
	$result = mysql_query ($sql, $db);
	$inf = array();
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			$inf[$col] = $val;
		}
	}
	$zarp = $inf[kZarp]+$inf[dolg];
	print <<<HERE
	<h3><center>Сведения о команде</center></h3>
	<table border = 0 align = center>
	<tr>
		<td align = left width = 50%>Тренер:</td>
		<td align = left>
HERE;
		$result = mysql_query("SELECT id,origin FROM users WHERE origin = '$inf[coach]'",$db); //извлекаем логин и идентификатор пользователей
		$myrow = mysql_fetch_array($result);

printf("<a href='page.php?id=%s'>%s</a><br>",$myrow['id'],$myrow['origin']);	
	$budget = number_format($inf[budget],0,'',' ');
	$zarplata = number_format($zarp,0,'',' ');
	print <<<HERE
	</tr>
	<tr>
		<td align = left>Бюджет:</td>
		<td align = left>$budget</td>
	</tr>
	<tr>
		<td align = left>Общая зарплата:</td>
		<td align = left>$zarplata</td>
	</tr>
	<tr>
		<td align = left>Спонсор:</td>
		<td align = left>$inf[sponsor]</td>
	</tr>
	<tr>
		<td align = left>Количество игроков:</td>
		<td align = left>$inf[pls]</td>
	</tr>
	</table>
HERE;
	if ($open&&$koma==$teamName){
	print <<<HERE
	<h3><center>Выставить на трансфер</center></h3>
	<form name = "tran" action = "addTran.php" method = "post" onsubmit = "return fail1()">
	<table border = 0 width = 100%>
	<tr>
		<th>Игрок</th>
	</tr>
HERE;
	$sql = "SELECT name FROM players WHERE team = '$teamName' ORDER BY players.skill DESC";
	$result = mysql_query($sql, $db);
	$play1 = array();
	$i = 0;
	$kol = 0;
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			$play1[$i] = $val;
			$kol = $i;
			$i++;
		}
	}
	print <<<HERE
	<tr>
	<td>
	<select name = "plays">
	<option value = 'N/A'>N/A</option>
HERE;
	for ($i = 0; $i<=$kol; $i++){
		print <<<HERE
		<option value = '$play1[$i]'>$play1[$i]</option>
HERE;
		
	}
	print <<<HERE
	</select></td></tr><tr>
			<th>Цена</th></tr><tr>
	<input type = 'hidden' name = 'team' value = "$teamName">
	<td><input type = 'text' name = 'tsena' size = '12'></td>
	<tr><td><input type = 'submit' value = 'Выставить на трансфер'></td>
	</tr></table></form>

	<script type = "text/javascript">
function fail1(){
	var plays = document.tran.plays.value;
	var tsena = document.tran.tsena.value;
	nani = tsena - 0;
	if (plays!="N/A"&&tsena!=""&&!isNaN(nani)){
		return true;
	}else{
		alert("Некорректный ввод");
		return false;
	}
}
</script>
HERE;

print <<<HERE
	<h3><center><br>Прямая продажа</center></h3>
	<form name = "tran1" action = "addTranSpec.php" method = "post" onsubmit = "return fail2()">
	<table border = 0 width = 100%>
	<tr>
		<th>Игрок</th>
	</tr>
HERE;
	$sql = "SELECT name FROM players WHERE team = '$teamName' ORDER BY players.skill DESC";
	$result = mysql_query($sql, $db);
	$play2 = array();
	$i = 0;
	$kol = 0;
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			$play2[$i] = $val;
			$kol = $i;
			$i++;
		}
	}
	$sql = "SELECT tName FROM teams WHERE 1";
	$result = mysql_query($sql, $db);
	$tms = array();
	$i = 0;
	$kolTms = 0;
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			if ($val != $teamName){			
			$tms[$i] = $val;
			$kolTms = $i;
			$i++;
			}
		}
	}
	print <<<HERE
	<tr>
	<td>
	<select name = 'plays'>
	<option value = 'N/A'>N/A</option>
HERE;
	for ($i = 0; $i<=$kol; $i++){
		print <<<HERE
		<option value = '$play2[$i]'>$play2[$i]</option>
HERE;
		
	}
	print <<<HERE
	</select></td></tr><tr>
	<th>Цена</th></tr><tr>	
	<input type = 'hidden' name = 'team' value = "$teamName">
	<td><input type = 'text' name = 'tsena' size = '12'></td>
	</tr><tr><th>Покупатель</th></tr><tr>
	<td>
	<select name = 'tms'>
	<option value = 'N/A'>N/A</option>
HERE;
		for ($i = 0; $i<=$kolTms; $i++){
		print <<<HERE
		<option value = "$tms[$i]">$tms[$i]</option>
HERE;
		
	}
	print <<<HERE
	</select></td></tr>
	<tr><td colspan = 4><input type = 'submit' value = 'Продать'></td>
	</tr></table></form>

	<script type = "text/javascript">
function fail2(){
	var plays1 = document.tran1.plays.value;
	var tsena1 = document.tran1.tsena.value;
	var tms1 = document.tran1.tms.value;
	nani1 = tsena1 - 0;
	if (plays1!="N/A"&&tsena1!=""&&!isNaN(nani1)&&tms1!="N/A"){
		return true;
	}else{
		alert("Некорректный ввод");
		return false;
	}
}
</script>
HERE;


print <<<HERE
	<h3><center><br>Сдача в СА</center></h3>
	<form name = "tran2" action = "addTranSA.php" method = "post" onsubmit = "return fail3()">
	<table border = 0 width = 100%>
	<tr>
		<th>Игрок</th>
	</tr>
HERE;
	$sql = "SELECT name FROM players WHERE team = '$teamName' ORDER BY players.skill DESC";
	$result = mysql_query($sql, $db);
	$play3 = array();
	$i = 0;
	$kol = 0;
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			$play3[$i] = $val;
			$kol = $i;
			$i++;
		}
	}
	print <<<HERE
	<tr>
	<td>
	<select name = 'plays'>
	<option value = 'N/A'>N/A</option>
HERE;
	for ($i = 0; $i<=$kol; $i++){
		print <<<HERE
		<option value = '$play3[$i]'>$play3[$i]</option>
HERE;
		
	}
	print <<<HERE
	</select></td></tr>
	<input type = 'hidden' name = 'team' value = "$teamName">
	<tr><td><input type = 'submit' value = 'Сдать в СА'></td>
	</tr></table></form>

	<script type = "text/javascript">
function fail3(){
	var plays2 = document.tran2.plays.value;
	if (plays2!="N/A"){
		return true;
	}else{
		alert("Некорректный ввод");
		return false;
	}
}
</script>
HERE;

	}
	echo '</div>';
}	
include ("footer.php");
?>
