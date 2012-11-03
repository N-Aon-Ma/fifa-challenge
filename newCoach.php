<?
	$title = "Управление тренерами";
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

$sql = "SELECT origin FROM users WHERE team = '' AND origin!='JeckA'";
$result = mysql_query ($sql, $db);
$i = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$coachs[$i] = $val;
		$i++;
	}
}
$sql = "SELECT tName FROM teams WHERE coach = ''";
$result = mysql_query ($sql, $db);
$j = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$teams[$j] = $val;
		$j++;
	}
}
$sql = "SELECT origin FROM users WHERE team != ''";
$result = mysql_query ($sql, $db);
$k = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$dcoachs[$k] = $val;
		$k++;
	}
}
	
?>
<h2><center>Назначить тренера</center></h2>
<form action = "addCoach.php" method = "POST"> 
<table>
<tr>
<td> Тренер </td>
<td><select name = "coach" id = "coach">
<? for ($i1 = 1; $i1<$i; $i1++){
	echo '<option value = "'.$coachs[$i1].'">'.$coachs[$i1].'</option>';
}
?>

</td>
<td>Команда</td>
<td><select name = "team" id = "team">
<? for ($j1 = 1; $j1<$j; $j1++){
	echo '<option value = "'.$teams[$j1].'">'.$teams[$j1].'</option>';
}
?>
</td><td><input type = "submit" value = "Назначить"> </td></tr></table></form>

<h2><center>Снять тренера</center></h2>
<form action = "delCoach.php" method = "POST">
<table>
<tr>
<td> Тренер </td>
<td><select name = "coach" id = "coach">
<? for ($k1 = 1; $k1<$k; $k1++){
	$sql = "SELECT team FROM users WHERE origin = '$dcoachs[$k1]'";
	$result = mysql_query ($sql, $db);
	while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$team = $val;
	}
}
	echo '<option value = "'.$dcoachs[$k1].'">'.$dcoachs[$k1].' - '.$team.'</option>';
}
?>

</td><td><input type = "submit" value = "Снять"></td></tr>
</table></form>

	
	

<?
	include ("footer.php");
?>