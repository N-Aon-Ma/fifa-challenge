<?
$act = $_POST["act"];
if($act!=33){

	header ("Location: index.php"); 
}
	$title = "Внесение результат";
	include ("header.php");
?>
<font  color = "#176310" face= "franklin gothic medium , Calibri, Arial">
<?
$good = false;
$tournir = $_POST["street"];
$team1 = $_POST["house2"];
$team2 = $_POST["house1"];
$score1 = $_POST["Home"];
$score2 = $_POST["Away"];
$where = $_POST["where"];
$arr1 = array();
$arr2 = array();
if (empty($_FILES['screen1']['name'])or empty($_FILES['screen2']['name']) or empty($_FILES['screen3']['name'])) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
{
exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!"); //останавливаем выполнение сценариев
}

$path_to_90_directory = 'screens/';//папка, куда будет загружаться начальная картинка и ее сжатая копия

	

//конец процесса загрузки и присвоения переменной $avatar адреса загруженной авы

if(!preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['screen1']['name']) or !preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['screen2']['name']) or !preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['screen3']['name']))//проверка формата исходного изображения
	 {	 
       	exit ("Скриншоты должны быть в формате <strong>JPG,GIF или PNG</strong>"); //останавливаем выполнение сценариев
	}
if ($where=='inAway'){
	for ($i = 1; $i <=$score1; $i++){
		$arr2[$i] = $_POST["pl1$i"];
	}
	for ($i = 1; $i <=$score2; $i++){
		$arr1[$i] = $_POST["pl2$i"];
	}
	$tmp = $team1;
	$team1 = $team2;
	$team2= $tmp;
	$tmp = $score1;
	$score1 = $score2;
	$score2 = $tmp;
} else{
	for ($i = 1; $i <=$score1; $i++){
		$arr1[$i] = $_POST["pl1$i"];
	}
	for ($i = 1; $i <=$score2; $i++){
		$arr2[$i] = $_POST["pl2$i"];
	}
}


if ($score1>$score2){
	$max = $score1;
}else {
	$max = $score2;
}
$err = 0;
$sql = "SELECT done,coach FROM teams  WHERE tName = '$team1' OR tName = '$team2'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='done'&&$val==0){
			$err = 1;//анкета не заполнена
		}
		if ($col=='coach'&&$val==""){
			$err = 2;//анкета не заполнена
		}
	}
}
if ($tournir=='leaguea'||$tournir=='leagueb'){
$t1ID = 0;
$t2ID = 0;

$sql = "SELECT tID FROM $tournir  WHERE team = '$team2'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='tID'){
			$t2ID = $val;
		}
	}
}

$sql = "SELECT tID FROM $tournir  WHERE team = '$team1'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='tID'){
			$t1ID = $val;
		}
	}
}
$t1ID = "m".$t1ID;
$t2ID = "m".$t2ID;
$sql = "SELECT $t2ID FROM $tournir  WHERE team = '$team1'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=="$t2ID"&&$val>=$roundl){
			$err = 3;//все матчи сыграны
		}
	}
}
switch ($err){
case 1:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>Анкета одной из команд не заполнена</h3></center>
HERE;
	break;
case 2:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>У команды противника нет тренера</h3></center>
HERE;
	break;	
case 3:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>Все матчи между этими командами уже сыграны</h3></center>
HERE;
	break;		
default:	
$good = true;
$sql = "SELECT i,v,n,p,zm,pm,rm,om,op,score,$t2ID FROM $tournir  WHERE team = '$team1'";
$result = mysql_query($sql, $db);
$arr = array();
$i = 0;
mysql_fetch_field($result);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$arr[$i] = $val;
		$i++;
	}
}
$arr[0]+=1;
$arr[4]+=$score1;
$arr[5]+=$score2;
$arr[6] = $arr[4]-$arr[5];
if ($score1>$score2) { $arr[1]+=1; $arr[9]+=3;}
if ($score1==$score2) { $arr[2]+=1; $arr[9]+=1;}
if ($score1<$score2) { $arr[3]+=1;}	
$arr[7] = $arr[0]*3-$arr[9];
$arr[8] = $arr[9]/($arr[0]*3)*100;
$arr[10] += 1; 
$sql = <<<HERE
UPDATE $tournir
SET
	i = $arr[0],
	v = $arr[1],
	n = $arr[2],
	p = $arr[3],
	zm = $arr[4],
	pm = $arr[5],
	rm = $arr[6],
	om = $arr[7],
	op = $arr[8],
	score = $arr[9],
	$t2ID = $arr[10]
WHERE
	team = '$team1'
HERE;
mysql_query($sql);	

$sql = "SELECT i,v,n,p,zm,pm,rm,om,op,score,$t1ID FROM $tournir  WHERE team = '$team2'";
$result = mysql_query($sql, $db);
$arr = array();
$i = 0;
mysql_fetch_field($result);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$arr[$i] = $val;
		$i++;
	}
}
$arr[0]+=1;
$arr[4]+=$score2;
$arr[5]+=$score1;
$arr[6] = $arr[4]-$arr[5];
if ($score1<$score2) { $arr[1]+=1; $arr[9]+=3;}
if ($score1==$score2) { $arr[2]+=1; $arr[9]+=1;}
if ($score1>$score2) { $arr[3]+=1;}	
$arr[7] = $arr[0]*3-$arr[9];
$arr[8] = $arr[9]/($arr[0]*3)*100;
$arr[10] += 1;
$sql = <<<HERE
UPDATE $tournir
SET
	i = $arr[0],
	v = $arr[1],
	n = $arr[2],
	p = $arr[3],
	zm = $arr[4],
	pm = $arr[5],
	rm = $arr[6],
	om = $arr[7],
	op = $arr[8],
	score = $arr[9],
	$t1ID = $arr[10]
WHERE
	team = '$team2'
HERE;
mysql_query($sql);

$num = array();
$tms = array();
$i = 1;
$j = 1;
$sql = "SELECT num, tID FROM $tournir ORDER BY $tournir.score DESC, $tournir.v DESC, $tournir.rm DESC, $tournir.zm DESC, $tournir.i ASC";
$result = mysql_query($sql,$db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='tID'){
			$tms[$i] = $val;
			$i++;
		}
		if ($col=='num'){
			$num[$j] = $j;
			$j++;
		}
	}
}

for ($i = 1; $i <= count($num); $i++){
	$sql = <<<HERE
		UPDATE $tournir
		SET
			num = $num[$i]
		WHERE
			tID = $tms[$i]
HERE;
mysql_query($sql);	
}
}
}
if ($tournir=='cup'||$tournir=='lchpo'||$tournir=='lepo'){
	$t1 = array();
$t2 = array();
$sql = "SELECT `stad`, `num`, `done`, `homezb`, `homepr`, `awayzb`, `awaypr`, `shome`, `saway`, `finalzb`, `finalpr` FROM $tournir WHERE tName = '$team1' AND done<2";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$t1[$col] = $val;
	}
}
$sql = "SELECT `stad`, `num`, `done`, `homezb`, `homepr`, `awayzb`, `awaypr`, `shome`, `saway`, `finalzb`, `finalpr` FROM $tournir WHERE tName = '$team2' AND done<2";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$t2[$col] = $val;
	}
}
$final = false;
if ($t1[stad]==1){
	$final = true;
}
if ($t1[shome]==true||$t2[saway]==true){
	$err = 3;//команды сыграли на этом поле
}
if ($t1[stad]!=$t2[stad]){
	$err = 4;//эти команды в разных стадиях
}
$tm1 = $t2[num]-1;
$tm2 = $t2[num]+1;
if ($t1[num]!=$tm2&&$t1[num]!=$tm1){
	$err = 5;//между этими командами нет матчей
}
$j = 1;
$newn = 0;
for ($i = 1; $i<= 47; $i+=3){
	if ($t1[num]==$i||$t1[num]==$i-1||$t1[num]==$i+1){
		$newn = $j;
	}
	$j++;
	if ($j%3==0&&$j>2){
		$j++;
	}
}
switch ($err){
case 1:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>Анкета одной из команд не заполнена</h3></center>
HERE;
	break;
case 2:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>У команды противника нет тренера</h3></center>
HERE;
	break;	
case 3:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>Команды сыграли на этом поле</h3></center>
HERE;
	break;
case 4:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>Команды в разных стадиях турнира</h3></center>
HERE;
	break;
case 5:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>Между этими командами нет матчей</h3></center>
HERE;
	break;	
default:
$good = true;
if (!$final){	
$t1[homezb] = $score1;
$t1[homepr] = $score2;
$t2[awayzb] = $score2;
$t2[awaypr] = $score1;
$t1[shome] = true;
$t2[saway] = true;
$t1[done] += 1;
$t2[done] += 1;
$sql = <<<HERE
UPDATE $tournir
SET
	homezb = $t1[homezb],
	homepr = $t1[homepr],
	shome = $t1[shome],
	done = $t1[done]
WHERE
	tName = '$team1' AND stad = $t1[stad]
HERE;
mysql_query($sql);	

$sql = <<<HERE
UPDATE $tournir
SET
	awayzb = $t2[awayzb],
	awaypr = $t2[awaypr],
	saway = $t2[saway],
	done = $t2[done]
WHERE
	tName = '$team2' AND
	stad = $t2[stad]
HERE;
mysql_query($sql);
if ($t1[done]==2&&$t1[stad]!=1){
	$win = 0;
	$ls = 0;
	$full1 = $t1[homezb]+$t1[awayzb];
	$full2 = $t2[homezb]+$t2[awayzb];
	if ($full1>$full2){
		$win = $team1;
		$ls = $team2;
	}
	if ($full1<$full2){
		$win = $team2;
		$ls = $team1;
	}
	if ($full1==$full2){
		if ($t1[awayzb]>$t2[awayzb]){
			$win = $team1;
			$ls = $team2;
		}
		if ($t1[awayzb]<$t2[awayzb]){
			$win = $team2;
			$ls = $team1;
		}
	}
	$nstd1 = $t1[stad]/2;
	$nstd = $t1[stad] - $nstd1;
	$sql = "UPDATE $tournir SET tName='$win' WHERE stad='$nstd' AND num='$newn'";
	mysql_query($sql);
	$sql = "UPDATE $tournir SET lose=true WHERE tName = '$ls'";
	mysql_query($sql);
}
}else{
$t1[shome] = true;
$t1[saway] = true;
$t2[shome] = true;
$t2[saway] = true;
$t1[done] += 2;
$t2[done] += 2;
$t1[finalzb] = $score1;
$t1[finalpr] = $score2;
$t2[finalzb] = $score2;
$t2[finalpr] = $score1;
$sql = <<<HERE
UPDATE $tournir
SET
	finalzb = $t1[finalzb],
	finalpr = $t1[finalpr],
	shome = $t1[shome],
	saway = $t1[saway],
	done = $t1[done]
WHERE
	tName = '$team1' AND stad = $t1[stad]
HERE;
mysql_query($sql);	

$sql = <<<HERE
UPDATE $tournir
SET
	finalzb = $t2[finalzb],
	finalpr = $t2[finalpr],
	shome = $t2[shome],
	saway = $t2[saway],
	done = $t2[done]
WHERE
	tName = '$team2' AND
	stad = $t2[stad]
HERE;
mysql_query($sql);
$sql = <<<HERE
UPDATE $tournir
SET
	lose = true
WHERE
	tName = '$team2' OR
	tName = '$team1'
HERE;
mysql_query($sql);

}
}
}
if ($tournir == 'lch'||$tournir == 'le'){

$gr1 = "";
$gr2 = "";
$sql = "SELECT grp FROM $tournir  WHERE team = '$team1'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='grp'){
			$gr1 = $val;
		}
	}
}	
$sql = "SELECT grp FROM $tournir  WHERE team = '$team2'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='grp'){
			$gr2 = $val;
		}
	}
}
$t1ID = 0;
$t2ID = 0;	
$sql = "SELECT grID FROM $tournir  WHERE team = '$team2'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='grID'){
			$t2ID = $val;
		}
	}
}
$sql = "SELECT grID FROM $tournir  WHERE team = '$team1'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='grID'){
			$t1ID = $val;
		}
	}
}
$t1ID = "m".$t1ID;
$t2ID = "m".$t2ID;
$sql = "SELECT $t2ID FROM $tournir  WHERE team = '$team1'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=="$t2ID"&&$val>=$rounde){
			$err = 3;//все матчи сыграны
		}
	}
}
if ($gr1!=$gr2){
	$err = 4;//команды в разных группах
}	
switch ($err){
case 1:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>Анкета одной из команд не заполнена</h3></center>
HERE;
	break;
case 2:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>У команды противника нет тренера</h3></center>
HERE;
	break;	
case 3:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>Все матчи между этими командами уже сыграны</h3></center>
HERE;
	break;		
case 4:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>Команды играют в разных группах</h3></center>
HERE;
	break;	
default:
$good = true;	
$sql = "SELECT i,v,n,p,zm,pm,rm,om,op,score,$t2ID FROM $tournir  WHERE team = '$team1'";
$result = mysql_query($sql, $db);	
$arr = array();
$i = 0;
mysql_fetch_field($result);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$arr[$i] = $val;
		$i++;
	}
}
$arr[0]+=1;
$arr[4]+=$score1;
$arr[5]+=$score2;
$arr[6] = $arr[4]-$arr[5];
if ($score1>$score2) { $arr[1]+=1; $arr[9]+=3;}
if ($score1==$score2) { $arr[2]+=1; $arr[9]+=1;}
if ($score1<$score2) { $arr[3]+=1;}	
$arr[7] = $arr[0]*3-$arr[9];
$arr[8] = $arr[9]/($arr[0]*3)*100;
$arr[10] += 1; 
$sql = <<<HERE
UPDATE $tournir
SET
	i = $arr[0],
	v = $arr[1],
	n = $arr[2],
	p = $arr[3],
	zm = $arr[4],
	pm = $arr[5],
	rm = $arr[6],
	om = $arr[7],
	op = $arr[8],
	score = $arr[9],
	$t2ID = $arr[10]
WHERE
	team = '$team1'
HERE;
mysql_query($sql);
$sql = "SELECT i,v,n,p,zm,pm,rm,om,op,score,$t1ID FROM $tournir  WHERE team = '$team2'";
$result = mysql_query($sql, $db);
$arr = array();
$i = 0;
mysql_fetch_field($result);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$arr[$i] = $val;
		$i++;
	}
}
$arr[0]+=1;
$arr[4]+=$score2;
$arr[5]+=$score1;
$arr[6] = $arr[4]-$arr[5];
if ($score1<$score2) { $arr[1]+=1; $arr[9]+=3;}
if ($score1==$score2) { $arr[2]+=1; $arr[9]+=1;}
if ($score1>$score2) { $arr[3]+=1;}	
$arr[7] = $arr[0]*3-$arr[9];
$arr[8] = $arr[9]/($arr[0]*3)*100;
$arr[10] += 1;
$sql = <<<HERE
UPDATE $tournir
SET
	i = $arr[0],
	v = $arr[1],
	n = $arr[2],
	p = $arr[3],
	zm = $arr[4],
	pm = $arr[5],
	rm = $arr[6],
	om = $arr[7],
	op = $arr[8],
	score = $arr[9],
	$t1ID = $arr[10]
WHERE
	team = '$team2'
HERE;
mysql_query($sql);
$num = array();
$tms = array();
$i = 1;
$j = 1;
$sql = "SELECT num, grID FROM $tournir WHERE grp='$gr1' ORDER BY $tournir.score DESC, $tournir.v DESC, $tournir.rm DESC, $tournir.zm DESC, $tournir.i ASC";
$result = mysql_query($sql,$db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='grID'){
			$tms[$i] = $val;
			$i++;
		}
		if ($col=='num'){
			$num[$j] = $j;
			$j++;
		}
	}
}

for ($i = 1; $i <= count($num); $i++){
	$sql = <<<HERE
		UPDATE $tournir
		SET
			num = $num[$i]
		WHERE
			grID = $tms[$i]
HERE;
mysql_query($sql);	
}
$sql = "SELECT num, i FROM $tournir WHERE grp='$gr1'";
$result = mysql_query($sql,$db);
$i=0;
$j=0;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='num'){
			$num[$i] = $val;
			$i++;
		}
		if ($col=='i'){
			$ig[$j] = $j;
			$j++;
		}
	}
}
$all= 0;
for ($k = 0; $k<$j; $k++){
	if ($ig[$k]==6){
		$all++;
	}
}
$sql = "SELECT team FROM $tournir WHERE grp='$gr1' AND num=1";
$result = mysql_query($sql,$db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$tp1 = $val;
	}
}
$sql = "SELECT team FROM $tournir WHERE grp='$gr1' AND num=2";
$result = mysql_query($sql,$db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$tp2 = $val;
	}
}
if ($all==4){
$sql = <<<HERE
UPDATE $tournir
SET
	end = true
WHERE
	grp = '$gr1' AND
	num>2
HERE;
mysql_query($sql);
$tr = "$tournir"."po";
if ($gr1=='A'){
	$newn1 = 1;
	$newn2 = 5;
}
if ($gr1=='B'){
	$newn1 = 4;
	$newn2 = 2;
}
if ($gr1=='C'){
	$newn1 = 7;
	$newn2 = 11;
}
if ($gr1=='D'){
	$newn1 = 10;
	$newn2 = 8;
}
$sql = "INSERT INTO $tr(`tName`, `stad`, `num`) VALUES ('$tp1', 4, $newn1 )";
mysql_query($sql);
$sql = "INSERT INTO $tr(`tName`, `stad`, `num`) VALUES ('$tp2', 4, $newn2 )";
mysql_query($sql);
	
}

}
}
if ($tournir=='scupl'||$tournir=='scupe'||$tournir=='gcup'){
	$sql = "SELECT syg FROM scups WHERE team = '$team1' AND cup = '$tournir'";
	$result = mysql_query($sql, $db);
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			if ($col=='syg'&&$val==true){
				$err = 3; //команды сыграли
			}
		}
	}
switch ($err){
case 1:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>Анкета одной из команд не заполнена</h3></center>
HERE;
	break;
case 2:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>У команды противника нет тренера</h3></center>
HERE;
	break;	
case 3:
	print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="input.php";', 3000 );
	</script>
	<center><h3>Матч уже сыгран</h3></center>
HERE;
	break;		
default:	
	$sql = <<<HERE
	UPDATE scups
	SET
		syg = true
		zm = $score1,
		pm = $score2
	WHERE
		team = '$team1' AND
		cup = '$tournir'
HERE;
mysql_query($sql);
$sql = <<<HERE
	UPDATE scups
	SET	
		syg = true
		zm = $score2,
		pm = $score1
	WHERE
		team = '$team2' AND
		cup = '$tournir'
HERE;
mysql_query($sql);
	
}
}

if ($good){
$sql = "SELECT rating FROM users  WHERE team = '$team1'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$rat1 = $val;
	}
}
$sql = "SELECT rating FROM users  WHERE team = '$team2'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$rat2 = $val;
	}
}
$dr = $rat1 - $rat2;
switch ($tournir){
	case 'leaguea':
		$k = 50;
		break;
	case 'leagueb':
		$k = 45;
		break;
	case 'lch':
		$k = 35;
		break;
	case 'le':
		$k = 30;
		break;
	case 'lchpo':
		$k = 60;
		break;
	case 'lepo':
		$k = 55;
		break;
	case 'cup':
		$k = 40;
		break;		
	case 'scupl':
		$k = 65;
		break;
	case 'scupe':
		$k = 70;
		break;
	case 'gcup':
		$k = 75;
		break;	
}
$kg = 0;
if ($score1>$score2){
	$g = $score1-$score2;
	$w = 1;	
}
if ($score1==$score2){
	$g = 0;
	$w = 0.5;
	$kg = 1;
}
if ($score1<$score2){
	$g = $score2-$score1;
	$w = 0;	
}

if ($kg == 0){
	if ($g == 1){
		$kg = 1;
	} else {
		if ($g == 2){
			$kg = 1.5;
		} else{
			$kg = (11+$g)/8;
		}
	}
}

$exp = -$dr/400;
$base = pow(10,$exp);
$we = 1/($base+1);	
$p = $k*$kg*($w-$we);
$sql = "UPDATE users SET rating = rating + $p WHERE team = '$team1'";
mysql_query($sql);
$sql = "UPDATE users SET rating = rating - $p WHERE team = '$team2'";
mysql_query($sql);


if ($tournir=='lchpo'){
	$tournir = 'lch';
}
if ($tournir=='lepo'){
	$tournir = 'le';
}



$arr11 = serialize($arr1);
$arr12 = serialize($arr2);
$filename1 = $_FILES['screen1']['name'];
		$source = $_FILES['screen1']['tmp_name'];	
		$target = $path_to_90_directory . $filename1;
		move_uploaded_file($source, $target);
		if(preg_match('/[.](GIF)|(gif)$/', $filename1)) {
			$im = imagecreatefromgif($path_to_90_directory.$filename1) ;
		}
		if(preg_match('/[.](PNG)|(png)$/', $filename1)) {
			$im = imagecreatefrompng($path_to_90_directory.$filename1) ;
		}
		if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename1)) {
			$im = imagecreatefromjpeg($path_to_90_directory.$filename1); 
		}
		$ratio = imagesx($im)/imagesy($im);
		$w_src = imagesx($im);
		$h_src = imagesy($im); 
		$sz = 1;
		if ($w_src>800&&$w_src<=1024){
			$sz = 1.3;
		}
		if ($w_src>1024&&$w_src<=1440){
			$sz = 1.65;
		}
		if ($w_src>1440){
			$sz = 2;
		}
		$w = $w_src/$sz;
		$h = $h_src/$sz;
        $dest = imagecreatetruecolor($w,$h); 
        imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $h, $w_src, $h_src); 
		$date='rez'.time('U'); 
		$screen1 = 'screens/'.$date.'.jpg';
		imagejpeg($dest, $path_to_90_directory.$date.".jpg");
		$delfull = $path_to_90_directory.$filename1; 
		unlink ($delfull);
		
		$filename2 = $_FILES['screen2']['name'];
		$source = $_FILES['screen2']['tmp_name'];	
		$target = $path_to_90_directory . $filename2;
		move_uploaded_file($source, $target);
		if(preg_match('/[.](GIF)|(gif)$/', $filename2)) {
			$im = imagecreatefromgif($path_to_90_directory.$filename2) ;
		}
		if(preg_match('/[.](PNG)|(png)$/', $filename2)) {
			$im = imagecreatefrompng($path_to_90_directory.$filename2) ;
		}
		if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename2)) {
			$im = imagecreatefromjpeg($path_to_90_directory.$filename2); 
		}
		$ratio = imagesx($im)/imagesy($im);
		$w_src = imagesx($im);
		$h_src = imagesy($im); 
		$w = $w_src/$sz;
		$h = $h_src/$sz;
        $dest = imagecreatetruecolor($w,$h); 
        imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $h, $w_src, $h_src); 
		$date='sos'.time('U'); 
		$screen2 = 'screens/'.$date.'.jpg';
		imagejpeg($dest, $path_to_90_directory.$date.".jpg");
		$delfull = $path_to_90_directory.$filename2; 
		unlink ($delfull);
		
		$filename3 = $_FILES['screen3']['name'];
		$source = $_FILES['screen3']['tmp_name'];	
		$target = $path_to_90_directory . $filename3;
		move_uploaded_file($source, $target);
		if(preg_match('/[.](GIF)|(gif)$/', $filename3)) {
			$im = imagecreatefromgif($path_to_90_directory.$filename3) ;
		}
		if(preg_match('/[.](PNG)|(png)$/', $filename3)) {
			$im = imagecreatefrompng($path_to_90_directory.$filename3) ;
		}
		if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename3)) {
			$im = imagecreatefromjpeg($path_to_90_directory.$filename3); 
		}
		$ratio = imagesx($im)/imagesy($im);
		$w_src = imagesx($im);
		$h_src = imagesy($im); 
		$w = $w_src/$sz;
		$h = $h_src/$sz;
        $dest = imagecreatetruecolor($w,$h); 
        imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $h, $w_src, $h_src); 
		$date='zap'.time('U'); 
		$screen3 = 'screens/'.$date.'.jpg';
		imagejpeg($dest, $path_to_90_directory.$date.".jpg");
		$delfull = $path_to_90_directory.$filename3; 
		unlink ($delfull);


$sql = <<<HERE
INSERT INTO `results`(
`dt`, `tournir`, `team1`, `team2`, `score1`, `score2`,`goals1`,`goals2`, `screen1`, `screen2`, `screen3`, `flag`, `rat`, `pisets`) VALUES (
NULL,'$tournir','$team1','$team2',$score1,$score2,'$arr11','$arr12','$screen1','$screen2','$screen3',0, $p, '$origin')
HERE;
mysql_query($sql);


$goal = "$tournir"."Goals";
$place = "$tournir"."Place";
for ($i = 1; $i<=$score1;$i++){
	if ($arr1[$i]!="AG"){;
		$sql = <<<HERE
UPDATE players
SET
	$goal = $goal+1
WHERE
	team = '$team1' AND
	name = '$arr1[$i]'
HERE;
		mysql_query($sql);
	}	
}
for ($i = 1; $i<=$score2;$i++){
	if ($arr2[$i]!="AG"){
		$sql = <<<HERE
UPDATE players
SET
	$goal = $goal+1
WHERE
	team = '$team2' AND
	name = '$arr2[$i]'
HERE;
		mysql_query($sql);
	}
}

$i = 1;
$j = 1;
$arr3 = array();
$arr4 = array();
$arr5 = array();
$sql = "SELECT pID,$goal FROM players WHERE $goal>0  ORDER BY players.$goal DESC";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='pID'){
			$arr3[$i] = $val;
			$i++;
		}
		if ($col==$goal){
			$arr4[$j] = $val;
			$j++;
		}
	}
}
$arr5[1] = 1;
for ($i = 2; $i<=count($arr4); $i++){
	if ($arr4[$i]==$arr4[$i-1]){
		$arr5[$i] = $arr5[$i-1];
	}else{
		$arr5[$i] = $i;
	}
}
for ($i=1;$i<=count($arr4);$i++){
	$sql = <<<HERE
	UPDATE players
	SET
		$place = $arr5[$i]
	WHERE
		pID = $arr3[$i]
HERE;
	mysql_query($sql);
}
	

print <<<HERE
<br>
<h2><center><font  color = "#176310" face= "franklin gothic medium , Calibri, Arial">Результат успешно занесён в базу.</center></h2>

<script type = "text/javascript">
	setTimeout( 'location="
HERE;
print 'index';
print <<<HERE
.php";', 3000 );
	</script>
HERE;

}
?>