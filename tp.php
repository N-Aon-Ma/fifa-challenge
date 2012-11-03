<?
	$title = "Расставить ТП/ТН";
	include ("header.php");
?>
<?
if (!empty($_SESSION['email']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сессиях, то проверяем, действительны ли они
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$sql = "SELECT `group` FROM users WHERE email = '$_SESSION[email]' AND password = '$_SESSION[password]'";
$result = mysql_query ($sql, $db);
if(!$result) exit("Ошибка - ".mysql_error().", ".$result);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$group = $val;
	}
} 
if ($group!='admin')
   {
   //Если не действительны, то закрываем доступ
    exit("Эта страница только для администрации!");
   }
}
else {
//Проверяем, зарегистрирован ли вошедший
	exit("Эта страница только для администрации!"); 
}
$sql = "SELECT tID,team,i FROM leaguea WHERE 1 ORDER BY leaguea.tID";
$result = mysql_query ($sql, $db);
if($result) {
$i=1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='tID'){
			$ida[$i] = $val;
		}	
		if ($col=='team'){
			$ta[$i] = $val;
		}
		if ($col=='i'){
			$ia[$i] = $val;
			$i++;
		}
	}
} 
for ($ja=1;$ja<$i;$ja++){
	$sql = "SELECT m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12,m13,m14,m15,m16 FROM leaguea WHERE tID=$ja";
	$result = mysql_query ($sql, $db);
	while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($val<$roundl){
			$ka = substr($col,1);
			$nsa[$ja][$ka] = true;
		}
	}
}
}
}



$sql = "SELECT tID,team,i FROM leagueb WHERE 1 ORDER BY leagueb.tID";
$result = mysql_query ($sql, $db);
if($result) {
$i=1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='tID'){
			$idb[$i] = $val;
		}	
		if ($col=='team'){
			$tb[$i] = $val;
		}
		if ($col=='i'){
			$ib[$i] = $val;
			$i++;
		}
	}
} 
for ($jb=1;$jb<$i;$jb++){
	$sql = "SELECT m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12,m13,m14,m15,m16 FROM leagueb WHERE tID=$jb";
	$result = mysql_query ($sql, $db);
	while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($val<$roundl){
			$kb = substr($col,1);
			$nsb[$jb][$kb] = true;
		}
	}
}
}
}




$sql = "SELECT tID,tName,stad,num,done FROM cup WHERE done<2 AND stad!=1 AND tName!='' ORDER BY cup.tID";
$result = mysql_query ($sql, $db);
if($result) {
$i=1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='tID'){
			$idc[$i] = $val;
		}	
		if ($col=='tName'){
			$tc[$idc[$i]] = $val;
		}
		if ($col=='stad'){
			$stc[$i] = $val;
			$stadc[$idc[$i]] = $val;
		}
		if ($col=='num'){
			$nc[$i] = $val;
		}
		if ($col=='done'){
			$dc[$idc[$i]] = $val;
			$i++;
		}
	}
} 
for ($jc=1;$jc<$i;$jc++){
	$tn1 = $nc[$jc]-1;
	$tn2 = $nc[$jc]+1;
	$sql = "SELECT tID FROM cup WHERE (num=$tn1 OR num=$tn2) AND stad = $stc[$jc] AND tName!=''";
	$result = mysql_query ($sql, $db);
	if ($result){
	while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
			$idc1 = $idc[$jc];
			$idc2 = $val;
			$nsc[$idc1][$idc2] = true;
		}
	}
}
}
}
?>
<h2><center>Несыгранные матчи:</center></h2>
<form action="put_tp.php" method="post">
  <br>
  <table border = 0>
  <tr>
    <th>Турнир</th>
    <th>Матч</th>
	<th>Результат</th>
  </tr>

<? $number = 0;
	for ($i=1;$i<$ja;$i++){
		for ($l=1;$l<=$ka;$l++){
			if ($nsa[$i][$l]&&$i<$l){
				$number++;
				print <<<HERE
				<tr><td>Лига А<input type = 'hidden' name = 'tr$number' value = 'leaguea'></td>
				<td>$ta[$i]<input type = 'hidden' name = 'home$number' value = '$ta[$i]'> vs $ta[$l]<input type = 'hidden' name = 'away$number' value = '$ta[$l]'>
				<br>$ia[$i] игр vs $ia[$l] игр</td>
				<td><input type="radio" name='res$number' value=1> $ta[$i]<Br>
					<input type="radio" name='res$number' value=2> Ничья<Br>
					<input type="radio" name='res$number' value=3> $ta[$l]<Br></td></tr>
HERE;
			}
		}
	}
	
	
		for ($i=1;$i<$jb;$i++){
		for ($l=1;$l<=$kb;$l++){
			if ($nsb[$i][$l]&&$i<$l){
				$number++;
				print <<<HERE
				<tr><td>Лига B<input type = 'hidden' name = 'tr$number' value = 'leagueb'></td>
				<td>$tb[$i]<input type = 'hidden' name = 'home$number' value = '$tb[$i]'> vs $tb[$l]<input type = 'hidden' name = 'away$number' value = '$tb[$l]'>
				<br>$ib[$i] игр vs $ib[$l] игр</td>
				<td><input type="radio" name='res$number' value=1> $tb[$i]<Br>
					<input type="radio" name='res$number' value=2> Ничья<Br>
					<input type="radio" name='res$number' value=3> $tb[$l]<Br></td></tr>
HERE;
			}
		}
	}
	
	
		for ($i=1;$i<=63;$i++){
		for ($l=1;$l<=63;$l++){
			if ($nsc[$i][$l]&&$i<$l){
				$number++;
				print <<<HERE
				<tr><td>Кубок<input type = 'hidden' name = 'tr$number' value = 'cup'></td>
				<td>$tc[$i]<input type = 'hidden' name = 'home$number' value = '$tc[$i]'> vs $tc[$l]<input type = 'hidden' name = 'away$number' value = '$tc[$l]'>
				<br>1/$stadc[$i] финала</td>
				<td><input type="radio" name='res$number' value=1> $tc[$i]<Br>
					<input type="radio" name='res$number' value=3> $tc[$l]<Br></td></tr>
					<input type = hidden name = 'stad$number' value = $stadc[$i]>
HERE;
			}
		}
	}
	print "<input type = hidden name = 'number' value = $number>";
?>	
</table>
<input type = submit value = "Отправить">
</form>

	
	

<?
	include ("footer.php");
?>