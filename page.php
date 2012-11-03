<?php
	$title = "Страница пользователя";
	include ("header.php");
// вся процедура работает на сессиях. Именно в ней хранятся данные пользователя, пока он находится на сайте. Очень важно запустить их в самом начале странички!!!
session_start();

if (isset($_GET['id'])) {$id =$_GET['id']; } //id "хозяина" странички
else
{ exit("Вы зашил на страницу без параметра!");} //если не указали id, то выдаем ошибку
if (!preg_match("|^[\d]+$|", $id)) {
exit("<p>Неверный формат запроса! Проверьте URL</p>");//если id не число, то выдаем ошибку
}

if (!empty($_SESSION['email']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сессиях, то проверяем, действительны ли они
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE email='$email' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //Если не действительны (может мы удалили этого пользователя из базы за плохое поведение)
    exit("Вход на эту страницу разрешен только зарегистрированным пользователям!");
   }
}
else {
//Проверяем, зарегистрирован ли вошедший
exit("Вход на эту страницу разрешен только зарегистрированным пользователям!"); }
$result = mysql_query("SELECT * FROM users WHERE id='$id'",$db); 
$myrow = mysql_fetch_array($result);//Извлекаем все данные пользователя с данным id

if (empty($myrow['origin'])) { exit("Пользователя не существует! Возможно он был удален.");} //если такого не существует

?>

<h2>Пользователь "<?php echo $myrow['origin']; ?>"</h2>


<?php

if ($myrow['email'] == $email) {
//Если страничка принадлежит вошедшему, то предлагаем изменить данные и выводим личные сообщения

print <<<HERE
<table>
<tr>
<form action='update_user.php' method='post'>
<td>Изменить Origin ID:</td>
<td><input name='origin' type='text' value = $myrow[origin]></td>
<td><input type='submit' name='submit' value='изменить'></td>
</form>
</tr>
<tr>

<form action='update_user.php' method='post'>
<td>Изменить пароль:</td>
<td><input name='password' type='password'></td>
<td><input type='submit' name='submit' value='изменить'></td>
</form>
</tr>
<tr>

<form action='update_user.php' method='post' enctype='multipart/form-data'>
<td>Изменить аватар:</td>
<td><input type="FILE" name="fupload"></td>
<td><input type='submit' name='submit' value='изменить'></td>
</form>
</tr>
<tr>

<form action='update_user.php' method='post'>
<td>Изменить ICQ:</td>
<td><input name='icq' type='text' value = $myrow[icq]></td>
<td><input type='submit' name='submit' value='изменить'></td>
</form>
</tr>
<tr>

<form action='update_user.php' method='post'>
<td>Изменить Вконтакте:</td>
<td><input name='vk' type='text' value = $myrow[vk]></td>
<td><input type='submit' name='submit' value='изменить'></td>
</form>
</tr>
</table>
HERE;
echo '<h2>Оставшиеся матчи:</h2>';
if ($il){
if ($tur[leag]=='leaguea'){
	echo '<b>Лига А: </b>';
} else{
	echo '<b>Лига B: </b>';
}
$sql = "SELECT team,m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12,m13,m14,m15,m16 FROM $tur[leag] WHERE tID!=$tid";
$result = mysql_query($sql, $db);
$j = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='m16'){
			$lg[$j][$col]=$val;
			$j++;
		} else {
			$lg[$j][$col]=$val;
		}
	}
}
for ($i=1; $i<$j;$i++){
	if ($lg[$i]['m'.$tid]<$roundl){
	$rr = $lg[$i][team];
		print "<img height = 13px src = 'images/$rr.png'> $rr   &nbsp";
	}
}
}
if ($ik){
echo '<br>';
echo '<b>Кубок: </b>';
$sql = "SELECT tName,num,shome,saway,finalzb,finalpr FROM cup WHERE stad='$cube[stad]' AND tName!='' AND (num=$cube[num]+1 OR num=$cube[num]-1)";
$result = mysql_query($sql, $db);
$kop = mysql_fetch_assoc($result);
if ($result&& $kop[num]!=0){
if ($kop[stad]==1){
	if ($kop[finalzb]==0&&$kop[finalpr]==0){
		print "<img height = 13px src = 'images/$kop[tName].png'> $kop[tName]";
	}
} else{
$ma = 0;
if ($kop[shome]==0){
		$ma++;
	}
	if ($kop[saway]==0){
		$ma++;
	}
	if ($ma==1){
		print "<img height = 13px src = 'images/$kop[tName].png'> $kop[tName]";
	}
	if ($ma==2){
		print "<img height = 13px src = 'images/$kop[tName].png'> $kop[tName]x2";
	}
}
} else {
	echo 'нет соперника';
}
}
if ($ie){
echo '<br>';
if ($tur[euro]=='lch'){
	echo '<b>Лига Чемпионов: </b>';
} else{
	echo '<b>Лига Европы: </b>';
}
if ($eu[end]==0){
$sql = "SELECT team,m1,m2,m3,m4 FROM $tur[euro] WHERE tID!=$tide";
$result = mysql_query($sql, $db);
$j = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='m4'){
			$lg[$j][$col]=$val;
			$j++;
		} else {
			$lg[$j][$col]=$val;
		}
	}
}
for ($i=1; $i<$j;$i++){
	if ($lg[$i]['m'.$tide]<$rounde){
	$rr = $lg[$i][team];
	$om = $rounde-$lg[$i]['m'.$tide];
	if ($om<2){ 
		print "<img height = 13px src = 'images/$rr.png'> $rr   &nbsp";
	} else{
		print "<img height = 13px src = 'images/$rr.png'> $rrx2  &nbsp";
	}
	}
}
} else{
		if ($eu[num]<3&&$tur[euro]=='lch'){
		$sql = "SELECT `tName`,`num`,`stad`,`shome`, `saway`, `finalzb`, `finalpr` FROM lchpo WHERE tName != '$koma' AND done<2 AND stad=$cubee[stad] AND (num-$cubee[num]=1 OR $cubee[num]-num=1)";
$result = mysql_query($sql, $db);
if ($result){
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$cubee1[$col] = $val;
	}
}
if ($cubee1[stad]==1){
	if ($cubee1[finalzb]==0&&$cubee1[finalpr]==0){
		print "<img height = 13px src = 'images/$cubee1[tName].png'> $cubee1[tName] &nbsp";
	}
} else {
	$iigr = 0;
	if ($cubee1[shome]==0){
		$iigr++;
	}
	if ($cubee1[saway]==0){
		$iigr++;
	}
	if ($iigr>0){
		if ($iigr==1){
			print "<img height = 13px src = 'images/$cubee1[tName].png'> $cubee1[tName] &nbsp";
		}
		if ($iigr==2){
			print "<img height = 13px src = 'images/$cubee1[tName].png'> $cubee1[tName]x2 &nbsp";
		}
	}
}
	}
	} else{
		echo 'нет соперника';
	}
		if (($eu[num]==3&&$tur[euro]=='lch')||($eu[num]==1&&$tur[euro]=='le')){
		$sql = "SELECT `tName`,`num`,`stad`,`shome`, `saway`, `finalzb`, `finalpr` FROM lepo WHERE tName != '$koma' AND done<2 AND stad=$cubee[stad] AND (num-$cubee[num]=1 OR $cubee[num]-num=1)";
$result = mysql_query($sql, $db);
if ($result){
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$cubee1[$col] = $val;
	}
}
if ($cubee1[stad]==1){
	if ($cubee1[finalzb]==0&&$cubee1[finalpr]==0){
		print "<img height = 13px src = 'images/$cubee1[tName].png'> $cubee1[tName] &nbsp";
	}
} else {
	$iigr = 0;
	if ($cubee1[shome]==0){
		$iigr++;
	}
	if ($cubee1[saway]==0){
		$iigr++;
	}
	if ($iigr>0){
		if ($iigr==1){
			print "<img height = 13px src = 'images/$cubee1[tName].png'> $cubee1[tName] &nbsp";
		}
		if ($iigr==2){
			print "<img height = 13px src = 'images/$cubee1[tName].png'> $cubee1[tName]x2 &nbsp";
		}
	}
}
	}
	} else{
		echo 'нет соперника';
	}
}

}
if ($ise){
	$sql = "SELECT team FROM scups WHERE team != '$koma' AND cup = 'scupe'";
	$result = mysql_query($sql, $db);
	if ($result){
	while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
			$sope=$val;
	}
}
		echo '<b>Суперкубок Европы: </b>'; 
		print "<img height = 13px src = 'images/$sope.png'> $sope  &nbsp";
	}
}
if ($isl){
	$sql = "SELECT team FROM scups WHERE team != '$koma' AND cup = 'scupl'";
	$result = mysql_query($sql, $db);
	if ($result){
	while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
			$sopl=$val;
	}
}
		echo '<b>Суперкубок Лиги: </b>'; 
		print "<img height = 13px src = 'images/$sopl.png'> $sopl  &nbsp";
	}
}
if ($isg){
	$sql = "SELECT team FROM scups WHERE team != '$koma' AND cup = 'gcup'";
	$result = mysql_query($sql, $db);
	if ($result){
	while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
			$sopg=$val;
	}
}
		echo '<b>GOLDEN CUP: </b>'; 
		print "<img height = 13px src = 'images/$sopg.png'> $sopg  &nbsp";
	}
}



}

else
{
//если страничка чужая, то выводим только некторые данные и форму для отправки личных сообщений
print <<<HERE
<table cellpadding = 4>
<tr>
<td rowspan = 6><img alt='аватар' src='$myrow[avatar]'></td>
<td>Origin ID:</td>
<td>$myrow[origin]</td>
</tr>
<tr>
<td>Email:</td>
<td>$myrow[email]</td>
</tr>
HERE;
if ($myrow['icq']!=0){
	print "<tr><td>ICQ:</td><td>$myrow[icq]</td></tr>";
}
if ($myrow['vk']!=""){
	print "<tr><td>Вконтакте:</td><td><a href = '$myrow[vk]'>$myrow[vk]</a></td></tr>";
}
if ($myrow['team']!=""){
	print "<tr><td>Команда:</td><td>$myrow[team]</td></tr>";
}
print <<<HERE
	<tr><td>Рейтинг:</td><td>$myrow[rating]</td></tr></table>

HERE;



print <<<HERE
<form action='post.php' method='post'>
<h2>Отправить Ваше сообщение:</h2>
<textarea cols='80' rows='4' name='text'></textarea><br>
<input type='hidden' name='poluchatel' value='$myrow[origin]'>
<input type='submit' name='submit' value='Отправить'>
</form>
HERE;
}

	include ("footer.php");
?>