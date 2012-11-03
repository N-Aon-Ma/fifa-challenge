<?
	$title = "Расставление ТП";
	include ("header.php");
?>
<font  color = "#176310" face= "franklin gothic medium , Calibri, Arial">
<?
$number = $_POST["number"];
for ($i=1;$i<=$number;$i++){
	$tournir = $_POST["tr$i"];
	$team1 = $_POST["home$i"];
	$team2 = $_POST["away$i"];
	$res = $_POST["res$i"];
	if ($res==1||$res==3){
	if ($res==3){
		$tmp = $team1;
		$team1 = $team2;
		$team2 = $tmp;
	}
	if ($tournir=='leaguea'||$tournir=='leagueb'){
	$sql = "SELECT tID FROM $tournir  WHERE team = '$team1'";
	$result = mysql_query($sql, $db);
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			$t1ID = $val;
		}
	}
	$sql = "SELECT tID FROM $tournir  WHERE team = '$team2'";
	$result = mysql_query($sql, $db);
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			$t2ID = $val;
		}
	}
	$t1ID = 'm'.$t1ID;
	$t2ID = 'm'.$t2ID;
		$sql = "SELECT i,v,op,score,$t2ID FROM $tournir  WHERE team = '$team1'";
$result = mysql_query($sql, $db);
$arr = array();
mysql_fetch_field($result);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$arr[$col] = $val;
	}
}
$arr[i]+=1;
$arr[v]+=1;
$arr[score]+=3; 	
$arr[op] = $arr[score]/($arr[i]*3)*100;
$arr[$t2ID] += 1; 
$sql = <<<HERE
UPDATE $tournir
SET
	i = $arr[i],
	v = $arr[v],
	op = $arr[op],
	score = $arr[score],
	$t2ID = $arr[$t2ID]
WHERE
	team = '$team1'
HERE;
mysql_query($sql);


$sql = "SELECT i,p,om,op,score,$t1ID FROM $tournir  WHERE team = '$team2'";
$result = mysql_query($sql, $db);
$arr = array();
mysql_fetch_field($result);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$arr[$col] = $val;
	}
}
$arr[i]+=1;
$arr[p]+=1;
$arr[om]+=3; 	
$arr[op] = $arr[score]/($arr[i]*3)*100;
$arr[$t1ID] += 1; 
$sql = <<<HERE
UPDATE $tournir
SET
	i = $arr[i],
	p = $arr[p],
	op = $arr[op],
	om = $arr[om],
	$t1ID = $arr[$t1ID]
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
if ($tournir=='cup'){
	$stad = $_POST["stad$i"];
	$nstd = $stad/2;
	$sql = "SELECT num,shome,saway FROM cup WHERE stad = $stad AND tName = '$team1'";
	$result = mysql_query($sql, $db);
	$nm = mysql_fetch_assoc($result);
	$j = 1;
	$newn = 0;
	for ($ii = 1; $ii<= 47; $ii+=3){
		if ($nm[num]==$ii||$nm[num]==$ii-1||$nm[num]==$ii+1){
			$newn = $j;
		}
		$j++;
		if ($j%3==0&&$j>2){
			$j++;
		}
	}
	if (!$nm[shome]){
		$sql = <<<HERE
UPDATE cup
SET
	done = done+1,
	homezb = homezb+3,
	shome = 1
WHERE
	tName = '$team1' AND
	stad = $stad
HERE;
		mysql_query($sql);
		$sql = <<<HERE
UPDATE cup
SET
	done = done+1,
	awaypr = awaypr+3,
	saway = 1,
	lose = 1
WHERE
	tName = '$team2' AND
	stad = $stad
HERE;
		mysql_query($sql);
	}
	if (!$nm[saway]){
		$sql = <<<HERE
UPDATE cup
SET
	done = done+1,
	awayzb = awayzb+3,
	saway = 1
WHERE
	tName = '$team1' AND
	stad = $stad
HERE;
		mysql_query($sql);
		$sql = <<<HERE
UPDATE cup
SET
	done = done+1,
	homepr = homepr+3,
	shome = 1,
	lose = 1
WHERE
	tName = '$team2' AND
	stad = $stad
HERE;
		mysql_query($sql);
	}
		$sql = <<<HERE
UPDATE cup
SET
	tName = '$team1'
WHERE
	tName = '' AND
	stad = $nstd AND
	num = $newn
HERE;
		mysql_query($sql);
}
}		
if ($res==2){
	$sql = "SELECT tID FROM $tournir  WHERE team = '$team1'";
	$result = mysql_query($sql, $db);
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			$t1ID = $val;
		}
	}
	$sql = "SELECT tID FROM $tournir  WHERE team = '$team2'";
	$result = mysql_query($sql, $db);
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			$t2ID = $val;
		}
	}
	$t1ID = 'm'.$t1ID;
	$t2ID = 'm'.$t2ID;
	$sql = "SELECT i,n,op,om,score,$t2ID FROM $tournir  WHERE team = '$team1'";
$result = mysql_query($sql, $db);
$arr = array();
mysql_fetch_field($result);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$arr[$col] = $val;
	}
}
$arr[i]+=1;
$arr[n]+=1;
$arr[score]+=1; 
$arr[om]+=2;	
$arr[op] = $arr[score]/($arr[i]*3)*100;
$arr[$t2ID] += 1; 
$sql = <<<HERE
UPDATE $tournir
SET
	i = $arr[i],
	n = $arr[n],
	op = $arr[op],
	om = $arr[om],
	score = $arr[score],
	$t2ID = $arr[$t2ID]
WHERE
	team = '$team1'
HERE;
mysql_query($sql);


	$sql = "SELECT i,n,op,om,score,$t1ID FROM $tournir  WHERE team = '$team2'";
$result = mysql_query($sql, $db);
$arr = array();
mysql_fetch_field($result);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$arr[$col] = $val;
	}
}
$arr[i]+=1;
$arr[n]+=1;
$arr[score]+=1; 
$arr[om]+=2;	
$arr[op] = $arr[score]/($arr[i]*3)*100;
$arr[$t1ID] += 1; 
$sql = <<<HERE
UPDATE $tournir
SET
	i = $arr[i],
	n = $arr[n],
	op = $arr[op],
	om = $arr[om],
	score = $arr[score],
	$t1ID = $arr[$t1ID]
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


print <<<HERE
<br>
<h2><center><font  color = "#176310" face= "franklin gothic medium , Calibri, Arial">Результаты успешно занесены в базу.</center></h2>

<script type = "text/javascript">
	setTimeout( 'location="
HERE;
print 'index';
print <<<HERE
.php";', 3000 );
	</script>
HERE;
?>