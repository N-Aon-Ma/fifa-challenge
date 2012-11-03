<?
	$title = "Внести результат";
	include ("header.php");
$sql = "SELECT team FROM users WHERE email = '$_SESSION[email]'";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$team1 = $val;
	}
}
if ($team1==""){
	echo '<h3><center>Вы не являетесь тренером ни одной из команд</h3></center>';
	include ("footer.php");
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="index.php";', 5000 );
	</script>
HERE;
die();
}
	if (!$game){
	echo '<h3><center>В данный момент проводить игры запрещено</h3></center>';
	include ("footer.php");
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="index.php";', 5000 );
	</script>
HERE;
die();}

$sql = "SELECT * FROM teams WHERE tName = '$team1'";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$uch[$col] = $val;
	}
}
$sql = "SELECT lose FROM cup WHERE tName = '$team1'";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($val){
			$loseCup = true;
		}
	}
}
if ($uch['euro']=='lch'){
$sql = "SELECT i,grp,end FROM lch WHERE team = '$team1'";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$lch[$col] = $val;
	}
}
if ($lch['end']==false&&$lch['i']==6){
$sql = "SELECT lose FROM lchpo WHERE team = '$team1'";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$lchpo[$col] = $val;
	}
}
}
}
if ($uch['euro']=='le'){
$sql = "SELECT i,grp,end FROM le WHERE team = '$team1'";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$le[$col] = $val;
	}
}
if ($le['end']==false&&$le['i']==6){
$sql = "SELECT lose FROM lepo WHERE team = '$team1'";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$lepo[$col] = $val;
	}
}
}
}

$xl = ($kolTeams/2-1)*$roundl;
$xe = 3*$rounde;
$sql = "SELECT name FROM players WHERE team='$team1'";
$result = mysql_query($sql, $db);
$mas1 = array();
$mas2 = array();
$i = 0;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
			$mas1[$i] = $val;
			$i1 = $i;
			$i++;
	}
}
$sql = "SELECT tName,pls FROM teams WHERE tName!='$team1'";
$result = mysql_query($sql, $db);
$j=0;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='tName'){
			$teams[$j][tName]=$val;
		}
		if ($col=='pls'){
			$teams[$j][pls]=$val;
			$j++;
		}
	}
}
for ($j1 = 0; $j1 < $j; $j1++){	
$rr = $teams[$j1][tName];
$sql = "SELECT name FROM players WHERE team='$rr'";
$result = mysql_query($sql, $db);
$igr = 0;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
			${$rr}[$igr]=$val;
			$igr++;
	}
}	
}

?>
<script type="text/javascript">
var aHouseValues = new Array(
"N/A",
<?
if ($uch['leag']=='leaguea'){
$sql = "SELECT team FROM leaguea WHERE i<$xl AND team!='$team1' ORDER BY leaguea.score DESC";
$result = mysql_query($sql, $db);
print '"N/A';
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		print ",$val";
	}
}
print '",';
} 
if ($uch['leag']=='leagueb'){
$sql = "SELECT team FROM leagueb WHERE i<$xl AND team!='$team1' ORDER BY leagueb.score DESC";
$result = mysql_query($sql, $db);
print '"N/A';
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		print ",$val";
	}
}
print '",';
}
if (!$loseCup){
$sql = "SELECT tName FROM cup WHERE (shome = false OR saway = false) AND finalzb = 0 AND finalpr = 0 AND tName!='$team1' AND tName!='' ORDER BY cup.stad DESC";
$result = mysql_query($sql, $db);
print '"N/A';
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		print ",$val";
	}
}
print '",';
}
if ($uch['euro']=='lch'){
$sql = "SELECT team FROM lch WHERE i<$xe AND team!='$team1' AND grp = '$lch[grp]' ORDER BY lch.score DESC";
$result = mysql_query($sql, $db);
print '"N/A';
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		print ",$val";
	}
}
print '",';
}
if ($uch['euro']=='le'){
$sql = "SELECT team FROM le WHERE i<$xe AND team!='$team1' AND grp = '$le[grp]' ORDER BY le.score DESC";
$result = mysql_query($sql, $db);
print '"N/A';
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		print ",$val";
	}
}
print '",';
}
if ($lch['end']==false&&$lch['i']==6&&$uch['euro']=='lch'&&$lchpo['lose']==false){
$sql = "SELECT tName FROM lchpo WHERE (shome = false OR saway = false) AND finalzb = 0 AND finalpr = 0 AND tName!='$team1' ORDER BY lchpo.stad DESC";
$result = mysql_query($sql, $db);
print '"N/A';
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		print ",$val";
	}
}
print '",';
}
if ($le['end']==false&&$le['i']==6&&$uch['euro']=='le'&&$lepo['lose']==false){
$sql = "SELECT tName FROM lepo WHERE (shome = false OR saway = false) AND finalzb = 0 AND finalpr = 0 AND tName!='$team1' ORDER BY lepo.stad DESC";
$result = mysql_query($sql, $db);
print '"N/A';
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		print ",$val";
	}
}
print '",';
}
if ($uch['scupl']){
$sql = "SELECT team FROM scups WHERE cup = 'scupl' AND syg = 0 AND team!='$team1'";
$result = mysql_query($sql, $db);
print '"N/A';
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		print ",$val";
	}
}
print '",';
}
if ($uch['scupe']){
$sql = "SELECT team FROM scups WHERE cup = 'scupe' AND syg = 0 AND team!='$team1'";
$result = mysql_query($sql, $db);
print '"N/A';
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		print ",$val";
	}
}
print '",';
}
if ($uch['gcup']){
$sql = "SELECT team FROM scups WHERE cup = 'gcup' AND syg = 0 AND team!='$team1'";
$result = mysql_query($sql, $db);
print '"N/A';
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		print ",$val";
	}
}
}
print '"");';
?>
function getHouseValuesByStreet(index){
 var sHouseValues = aHouseValues[index];
 return sHouseValues.split(","); 
}
function MkHouseValues(index){
 var aCurrHouseValues = getHouseValuesByStreet(index);
 var nCurrHouseValuesCnt = aCurrHouseValues.length;
 var oHouseList1 = document.forms["address"].elements["house1"];
 var oHouseListOptionsCnt1 = oHouseList1.options.length;
 oHouseList1.length = 0;  
 for (i = 0; i < nCurrHouseValuesCnt; i++){
 if (document.createElement){
 var newHouseListOption = document.createElement("OPTION");
 newHouseListOption.text = aCurrHouseValues[i];
 newHouseListOption.value = aCurrHouseValues[i];
 (oHouseList1.options.add) ? oHouseList1.options.add(newHouseListOption) : oHouseList1.add(newHouseListOption, null);
 }else{
 oHouseList1.options[i] = new Option(aCurrHouseValues[i], aCurrHouseValues[i], false, false);
 }
 }
}
MkHouseValues(document.forms["address"].elements["street"].selectedIndex);
</script>	


<center>
<h2><center>Внести результат</center></h2>
<form name = "address" action = "editTable.php" method = "post" onsubmit = "return fail()" enctype="multipart/form-data">
<table border = "0">
<tr>
<td colspan = "4"><center>
Турнир:
<select name="street" onChange="MkHouseValues(this.selectedIndex)">
<option value="N/A">N/A</option>
<? if ($uch['leag']=='leaguea'){
echo '<option value="leaguea">Лига А</option>';
}
if ($uch['leag']=='leagueb'){
echo '<option value="leagueb">Лига В</option>';
}
if (!$loseCup){
echo '<option value="cup">Кубок</option>';
}

if ($lch['end']==false&&$uch['euro']=='lch'){
	 echo '<option value="lch">Лига Чемпионов. Групповой этап</option>';
}
if ($le['end']==false&&$uch['euro']=='le'){
	 echo '<option value="lch">Лига Европы. Групповой этап</option>';
}
if ($lch['end']==true&&$lchpo['lose']==false){
	 echo '<option value="lch">Лига Чемпионов. Плей-офф</option>';
}
if ($le['end']==true&&$lepo['lose']==false){
	 echo '<option value="lch">Лига Европы. Плей-офф</option>';
}
if ($uch['scupl']){
	echo '<option value="scupl">Суперкубок Лиги</option>';
}
if ($uch['scupe']){
	echo '<option value="scupe">Суперкубок Европы</option>';
}
if ($uch['scupe']){
	echo '<option value="gcup">GOLDEN CUP</option>';
}
?>
</select></center>
</td>
</tr>
<tr>
<td>Вы:</td>
<td><? echo $team1 ?> 
<input type = 'hidden' name = "house2" value = '<? echo $team1 ?>'></td>
<td>Противник:</td>
<input type = 'hidden' name = "act" value = 33>
<td><select name="house1" onchange = "cre2()">
<option value="N/A">N/A</option>
</select></td>
</tr>
<tr>
<td>
Вы играли:
</td>
<td>
<input type="radio" name="where" value="inHome"> Дома</td>
 <td colspan = 2> <input type="radio" name="where" value="inAway"> В гостях </td>
 </tr>  
<tr>
<td>Счёт:</td>
<td><input name="Home" type="text" size="17" maxlength="30"  value="" onchange = "cre1()" /> </td>
<td></td>
<td><input name="Away" type="text" size="17" maxlength="30" value="" onchange = "cre2()"  /> </td>
<tr>
<td valign = top>Авторы голов:</td>
<td valign = top><table border = 0 name = "h">
</table>
</td> 
<td valign = top>Авторы голов:</td>
<td valign = top><table border = 0 name = "a">
</table>
</td> 
</tr>
</tr>
<script type = "text/javascript">

function cre1()
{
var sco1 = document.address.Home.value;
 var button1 = new Array (sco1);
nn1 = sco1-0;
 document.getElementsByName('h')[0].innerHTML = "";
 if(!isNaN(nn1)&&nn1>=0&&nn1<=20&&sco1!="")
 {
var i1 = <?php echo $i1 ?>;
 var mas1 = <?php echo json_encode($mas1) ?>;
for (var i=1; i<=sco1 ; i++){
button1[i] = document.createElement("SELECT");
button1[i].options[0] = new Option ("АГ","AG");
 for (var j=1;j<=i1+1;j++){
button1[i].options[j] = new Option (mas1[j-1],mas1[j-1]);
}
var nm1 = 'pl1'+i;
button1[i].setAttribute("name",nm1);
document.getElementsByName('h')[0].appendChild(button1[i]);//прикрепляем созданную кнопку к странице, причем "document.getElementsByTagName('body')[0]" выступает в роли родителя, то есть кнопка прикрепится к странице в конце элемента с тегом BODY
document.getElementsByName('h')[0].innerHTML += "<br>";
}
}
}
function cre2(){
var sco2 = document.address.Away.value;
 var button2 = new Array (sco2);
nn2 = sco2-0;
 document.getElementsByName('a')[0].innerHTML = "";
	if (document.address.house1.value!="N/A"&&!isNaN(nn2)&&nn2>=0&&nn2<=20&&sco2!=""){
		var ar0 = <? echo json_encode(${$teams[0][tName]}) ?>;
		var pl0 = <? echo $teams[0][pls] ?>;
		var ar1 = <? echo json_encode(${$teams[1][tName]}) ?>;
		var pl1 = <? echo $teams[1][pls] ?>;
		var ar2 = <? echo json_encode(${$teams[2][tName]}) ?>;
		var pl2 = <? echo $teams[2][pls] ?>;
		var ar3 = <? echo json_encode(${$teams[3][tName]}) ?>;
		var pl3 = <? echo $teams[3][pls] ?>;
		var ar4 = <? echo json_encode(${$teams[4][tName]}) ?>;
		var pl4 = <? echo $teams[4][pls] ?>;
		var ar5 = <? echo json_encode(${$teams[5][tName]}) ?>;
		var pl5 = <? echo $teams[5][pls] ?>;
		var ar6 = <? echo json_encode(${$teams[6][tName]}) ?>;
		var pl6 = <? echo $teams[6][pls] ?>;
		var ar7 = <? echo json_encode(${$teams[7][tName]}) ?>;
		var pl7 = <? echo $teams[7][pls] ?>;
		var ar8 = <? echo json_encode(${$teams[8][tName]}) ?>;
		var pl8 = <? echo $teams[8][pls] ?>;
		var ar9 = <? echo json_encode(${$teams[9][tName]}) ?>;
		var pl9 = <? echo $teams[9][pls] ?>;
		var ar10 = <? echo json_encode(${$teams[10][tName]}) ?>;
		var pl10 = <? echo $teams[10][pls] ?>;
		var ar11 = <? echo json_encode(${$teams[11][tName]}) ?>;
		var pl11 = <? echo $teams[11][pls] ?>;
		var ar12 = <? echo json_encode(${$teams[12][tName]}) ?>;
		var pl12 = <? echo $teams[12][pls] ?>;
		var ar13 = <? echo json_encode(${$teams[13][tName]}) ?>;
		var pl13 = <? echo $teams[13][pls] ?>;
		var ar14 = <? echo json_encode(${$teams[14][tName]}) ?>;
		var pl14 = <? echo $teams[14][pls] ?>;
		var ar15 = <? echo json_encode(${$teams[15][tName]}) ?>;
		var pl15 = <? echo $teams[15][pls] ?>;
		var ar16 = <? echo json_encode(${$teams[16][tName]}) ?>;
		var pl16 = <? echo $teams[16][pls] ?>;
		var ar17 = <? echo json_encode(${$teams[17][tName]}) ?>;
		var pl17 = <? echo $teams[17][pls] ?>;
		var ar18 = <? echo json_encode(${$teams[18][tName]}) ?>;
		var pl18 = <? echo $teams[18][pls] ?>;
		var ar19 = <? echo json_encode(${$teams[19][tName]}) ?>;
		var pl19 = <? echo $teams[19][pls] ?>;
		var ar20 = <? echo json_encode(${$teams[20][tName]}) ?>;
		var pl20 = <? echo $teams[20][pls] ?>;
		var ar21 = <? echo json_encode(${$teams[21][tName]}) ?>;
		var pl21 = <? echo $teams[21][pls] ?>;
		var ar22 = <? echo json_encode(${$teams[22][tName]}) ?>;
		var pl22 = <? echo $teams[22][pls] ?>;
		var ar23 = <? echo json_encode(${$teams[23][tName]}) ?>;
		var pl23 = <? echo $teams[23][pls] ?>;
		var ar24 = <? echo json_encode(${$teams[24][tName]}) ?>;
		var pl24 = <? echo $teams[24][pls] ?>;
		var ar25 = <? echo json_encode(${$teams[25][tName]}) ?>;
		var pl25 = <? echo $teams[25][pls] ?>;
		var ar26 = <? echo json_encode(${$teams[26][tName]}) ?>;
		var pl26 = <? echo $teams[26][pls] ?>;
		var ar27 = <? echo json_encode(${$teams[27][tName]}) ?>;
		var pl27 = <? echo $teams[27][pls] ?>;
		var ar28 = <? echo json_encode(${$teams[28][tName]}) ?>;
		var pl28 = <? echo $teams[28][pls] ?>;
		var ar29 = <? echo json_encode(${$teams[29][tName]}) ?>;
		var pl29 = <? echo $teams[29][pls] ?>;
		var ar30 = <? echo json_encode(${$teams[30][tName]}) ?>;
		var pl30 = <? echo $teams[30][pls] ?>;
			if (document.address.house1.value=='<? echo $teams[0][tName]; ?>'){
				var ar = ar0;
				var pl = pl0;
			}	
			if (document.address.house1.value=='<? echo $teams[1][tName]; ?>'){
				var ar = ar1;
				var pl = pl1;
			}
			if (document.address.house1.value=='<? echo $teams[2][tName]; ?>'){
				var ar = ar2;
				var pl = pl2;
			}
			if (document.address.house1.value=='<? echo $teams[3][tName]; ?>'){
				var ar = ar3;
				var pl = pl3;
			}
			if (document.address.house1.value=='<? echo $teams[4][tName]; ?>'){
				var ar = ar4;
				var pl = pl4;
			}
			if (document.address.house1.value=='<? echo $teams[5][tName]; ?>'){
				var ar = ar5;
				var pl = pl5;
			}
			if (document.address.house1.value=='<? echo $teams[6][tName]; ?>'){
				var ar = ar6;
				var pl = pl6;
			}
			if (document.address.house1.value=='<? echo $teams[7][tName]; ?>'){
				var ar = ar7;
				var pl = pl7;
			}
			if (document.address.house1.value=='<? echo $teams[8][tName]; ?>'){
				var ar = ar8;
				var pl = pl8;
			}
			if (document.address.house1.value=='<? echo $teams[9][tName]; ?>'){
				var ar = ar9;
				var pl = pl9;
			}
			if (document.address.house1.value=='<? echo $teams[10][tName]; ?>'){
				var ar = ar10;
				var pl = pl10;
			}
			if (document.address.house1.value=='<? echo $teams[11][tName]; ?>'){
				var ar = ar11;
				var pl = pl11;
			}
			if (document.address.house1.value=='<? echo $teams[12][tName]; ?>'){
				var ar = ar12;
				var pl = pl12;
			}
			if (document.address.house1.value=='<? echo $teams[13][tName]; ?>'){
				var ar = ar13;
				var pl = pl13;
			}
			if (document.address.house1.value=='<? echo $teams[14][tName]; ?>'){
				var ar = ar14;
				var pl = pl14;
			}
			if (document.address.house1.value=='<? echo $teams[15][tName]; ?>'){
				var ar = ar15;
				var pl = pl15;
			}
			if (document.address.house1.value=='<? echo $teams[16][tName]; ?>'){
				var ar = ar16;
				var pl = pl16;
			}
			if (document.address.house1.value=='<? echo $teams[17][tName]; ?>'){
				var ar = ar17;
				var pl = pl17;
			}
			if (document.address.house1.value=='<? echo $teams[18][tName]; ?>'){
				var ar = ar18;
				var pl = pl18;
			}
			if (document.address.house1.value=='<? echo $teams[19][tName]; ?>'){
				var ar = ar19;
				var pl = pl19;
			}
			if (document.address.house1.value=='<? echo $teams[20][tName]; ?>'){
				var ar = ar20;
				var pl = pl20;
			}
			if (document.address.house1.value=='<? echo $teams[21][tName]; ?>'){
				var ar = ar21;
				var pl = pl21;
			}
			if (document.address.house1.value=='<? echo $teams[22][tName]; ?>'){
				var ar = ar22;
				var pl = pl22;
			}
			if (document.address.house1.value=='<? echo $teams[23][tName]; ?>'){
				var ar = ar23;
				var pl = pl23;
			}
			if (document.address.house1.value=='<? echo $teams[24][tName]; ?>'){
				var ar = ar24;
				var pl = pl24;
			}
			if (document.address.house1.value=='<? echo $teams[25][tName]; ?>'){
				var ar = ar25;
				var pl = pl25;
			}
			if (document.address.house1.value=='<? echo $teams[26][tName]; ?>'){
				var ar = ar26;
				var pl = pl26;
			}
			if (document.address.house1.value=='<? echo $teams[27][tName]; ?>'){
				var ar = ar27;
				var pl = pl27;
			}
			if (document.address.house1.value=='<? echo $teams[28][tName]; ?>'){
				var ar = ar28;
				var pl = pl28;
			}
			if (document.address.house1.value=='<? echo $teams[29][tName]; ?>'){
				var ar = ar29;
				var pl = pl29;
			}
			if (document.address.house1.value=='<? echo $teams[30][tName]; ?>'){
				var ar = ar30;
				var pl = pl30;
			}
			for (var iii=1; iii<=sco2 ; iii++){
button2[iii] = document.createElement("SELECT");
button2[iii].options[0] = new Option ("АГ","AG");
 for (var jj=1;jj<=pl;jj++){
button2[iii].options[jj] = new Option (ar[jj-1],ar[jj-1]);
}
var nm2 = 'pl2'+iii;
button2[iii].setAttribute("name",nm2);
document.getElementsByName('a')[0].appendChild(button2[iii]);//прикрепляем созданную кнопку к странице, причем "document.getElementsByTagName('body')[0]" выступает в роли родителя, то есть кнопка прикрепится к странице в конце элемента с тегом BODY
document.getElementsByName('a')[0].innerHTML += "<br>";
}
	}
}

</script>
<tr>
<td colspan = "2">Скриншот результата:</td>
<td colspan = "2"><input type = "FILE" name = "screen1"></td>
</tr>	
<tr>
<td colspan = "2">Скриншот состава:</td>
<td colspan = "2"><input type = "FILE" name = "screen2"></td>
</tr>
<tr>
<td colspan = "2">Скриншот запаса:</td>
<td colspan = "2"><input type = "FILE" name = "screen3"></td>
</tr>
<tr>
<td colspan = "4"><center><input type="submit" value="Внести результат"></center></td>
</tr>
</center>
</table>
</form>
<script type = "text/javascript">
function fail(){
rad = false;
        for(pi=0;pi<document.address.where.length;pi++){
            if(document.address.where[pi].checked==true){
                rad = true;
                return;
            }
        }
	var team1 = document.address.house1.value;
	var scr1 = document.address.screen1.value;
	var scr2 = document.address.screen2.value;
	var scr3 = document.address.screen3.value;
	var sc1 = document.address.Home.value;
	nan1 = sc1-0;	
	var sc2 = document.address.Away.value;
	nan2 = sc2-0;
	if (rad&&!isNaN(nan1)&&!isNaN(nan2)&&sc1!=""&&sc2!=""&&team1!="N/A"&&team1!=""&&scr1!=""&&scr2!=""&&scr3!=""){
		return true;
	}
	else { 
		alert("Некорректный ввод");
		return false;
	}
}	
</script>





<?
	include ("footer.php");
?>