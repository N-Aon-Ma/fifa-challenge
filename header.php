<? 
	session_start();
	require_once 'online.php';
$input = false;
include_once ("bd.php");// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

if (isset($_COOKIE['auto']) and isset($_COOKIE['email']) and isset($_COOKIE['password']))
{//если есть необходимые переменные
	if ($_COOKIE['auto'] == 'yes') { // если пользователь желает входить автоматически, то запускаем сессии
		  $_SESSION['password']=strrev(md5($_COOKIE['password']))."b3p6f"; //в куках пароль был не зашифрованный, а в сессиях обычно храним зашифрованный
		  $_SESSION['email']=$_COOKIE['email'];//сессия с логином
		  $_SESSION['id']=$_COOKIE['id'];//идентификатор пользователя
		}	
	}

if (!empty($_SESSION['email']) and !empty($_SESSION['password']))
{
//если существет логин и пароль в сессиях, то проверяем их и извлекаем аватар
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$result = mysql_query("SELECT id,avatar FROM users WHERE email='$email' AND password='$password' AND activation='1'",$db); 
$myrow = mysql_fetch_array($result);
//извлекаем нужные данные о пользователе
}
?>
<html>
	<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<META NAME="description" CONTENT="Онлайн Карьера FIFA 13">
<META NAME="keywords" CONTENT="FIFA, онлайн, карьера, турниры, фифа">
	<link rel="stylesheet" href="general.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="model.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="login.css" type="text/css" media="screen" />
  <title> <? echo "$title";?></title>
<link href="dropdown.css" media="screen" rel="stylesheet" type="text/css" />
<link href="default.advanced.css" media="screen" rel="stylesheet" type="text/css" />
<link href="model.css" media="screen" rel="stylesheet" type="text/css" />
 <link href="images/favicon.ico" rel="shortcut icon" type="image/x-icon" /> 
 </head>
 
<body style="background-image:url(images/back.jpg)">
<?
if ( (stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0'))||(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0'))||(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0'))||(stristr($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.0')) ) 
{
	echo '<p valign = center><br><br><br><h1>Этот сайт не поддерживает "браузер" Internet Explorer. Будь человеком, скачай нормальный браузер:)</h1></p>';
	die ();
}
?>
  <div id="container1">
   <div id="header" >
	<div id="register" >
   	<script src="jquery.min.js"></script>
	<script>
		  $(document).ready(function(){
				$('#login-trigger').click(function(){
					$(this).next('#login-content').slideToggle();
					$(this).toggleClass('active');					
					
					if ($(this).hasClass('active')) $(this).find('span').html('&#x25B2;')
						else $(this).find('span').html('&#x25BC;')
					})
		  });
	</script>
  <?php
if (!isset($myrow['avatar']) or $myrow['avatar']=='') {
echo '<header class="cf">
<nav>
	<ul>
		<li id="login">
			<a id="login-trigger" href="#">
				Войти <span>&#x25BC;</span>
			</a>
			<div id="login-content">
				<form action="testreg.php" method="post">
					<fieldset id="inputs">
						<input id="email" type="email" name="email" placeholder="Ваш e-mail адрес" required>   
						<input id="password" type="password" name="password" placeholder="Ваш пароль" required>
						<font size = 1><a href = send_pass.php>Забыли пароль?</a></font>
					</fieldset>
					<fieldset id="actions">
						<input type="submit" id="submit" value="Войти">
						<label><input type="checkbox" checked="checked" id="autovhod" name = "autovhod"> <font color = black>Запомнить меня</font></label>
					</fieldset>
				</form>
			</div>                     
		</li>
		<li id="signup">
			<a href="reg.php">Регистрация</a>
		</li>
	</ul>
</nav>
</header>';
}

else
{
$input = true;
//при удачном входе пользователю выдается все, что расположено ниже между звездочками.
//************************************************************************************
$sql = "SELECT origin,id,team FROM users WHERE email = '$_SESSION[email]'";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
if ($col=='origin'){		
$origin = $val;
}
if ($col=='id'){		
$pid = $val;
}
if ($col=='team'){		
$koma = $val;
}
	}
}
if ($koma!=''){
$sql = "SELECT leag,scupe,scupl,gcup,euro FROM teams WHERE coach = '$origin'";
$result = mysql_query($sql, $db);
$tur = mysql_fetch_assoc($result);
$km = 0;
$sql = "SELECT tID FROM $tur[leag] WHERE coach = '$origin'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$tid = $val;
	}
}
$sql = "SELECT m1,m2,m3,m4,m5,m6,m7,m8,m9,m10,m11,m12,m13,m14,m15,m16 FROM $tur[leag] WHERE coach = '$origin'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($val<$roundl&&$col!='m'.$tid){
			$km++;
			$il = true;
		}
	}
}
$sql = "SELECT num,stad,shome,saway,finalzb,finalpr FROM cup WHERE tName = '$koma' AND done < 2";
$result = mysql_query($sql, $db);
$cube = mysql_fetch_assoc($result);
if ($result&&$cube[num]!=0){
if ($cube[stad]==1){
	if ($cube[finalzb]==0&&$cube[finalpr]==0){
		$km++;
		$ik = true;
	}
} else {
	if (!$cube[shome]){
		$km++;
		$ik = true;
	}
	if (!$cube[saway]){
		$km++;
		$ik = true;
	}
}
}
if ($tur[euro]!=''){
$sql = "SELECT tID FROM $tur[euro] WHERE coach = '$origin'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$tide = $val;
	}
}
$sql = "SELECT num,m1,m2,m3,m4,end FROM $tur[euro] WHERE team = '$koma'";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$eu[$col] = $val;
	}
}
if ($eu[end]==0){
	if ($eu[m1]<$rounde&&$tide!=1){
		$om = $rounde-$eu[m1];
		$km += $om;
		$ie = true;
	}
	if ($eu[m2]<$rounde&&$tide!=1){
		$om = $rounde-$eu[m2];
		$km += $om;
		$ie = true;
	}
	if ($eu[m3]<$rounde&&$tide!=1){
		$om = $rounde-$eu[m3];
		$km += $om;
		$ie = true;
	}
	if ($eu[m4]<$rounde&&$tide!=1){
		$om = $rounde-$eu[m4];
		$km += $om;
		$ie = true;
	}
} else{
	if (($eu[num]<3&&$tur[euro]=='lch')||($eu[num]==1&&$tur[euro]=='le')){
		$sql = "SELECT `num`,`stad`,`shome`, `saway`, `finalzb`, `finalpr` FROM lchpo WHERE tName = '$koma' AND done<2";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$cubee[$col] = $val;
	}
}
if ($cubee[stad]==1){
	if ($cubee[finalzb]==0&&$cubee[finalpr]==0){
		$km++;
		$ie = true;
	}
} else {
	if ($cubee[shome]==0){
		$km++;
		$ie = true;
	}
	if ($cubee[saway]==0){
		$km++;
		$ie = true;
	}
}
	}
		if ($eu[num]==3&&$tur[euro]=='lch'){
		$sql = "SELECT `num`,`stad`,`shome`, `saway`, `finalzb`, `finalpr` FROM lepo WHERE tName = '$koma' AND done<2";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$cubee[$col] = $val;
	}
}
if ($cubee[stad]==1){
	if ($cubee[finalzb]==0&&$cubee[finalpr]==0){
		$km++;
		$ie = true;
	}
} else {
	if ($cubee[shome]==0){
		$km++;
		$ie = true;
	}
	if ($cubee[saway]==0){
		$km++;
		$ie = true;
	}
}
	}
	
	
}
}


if ($tur[scupe]==true){
	$sql = "SELECT syg FROM scups WHERE team = '$koma' AND cup = 'scupe'";
	$result = mysql_query($sql, $db);
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			if ($col=='syg'&&$val==false){
				$km++;
				$ise = true;
			}
		}
	}
}
if ($tur[scupl]==true){
	$sql = "SELECT syg FROM scups WHERE team = '$koma' AND cup = 'scupl'";
	$result = mysql_query($sql, $db);
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			if ($col=='syg'&&$val==false){
				$km++;
				$isl = true;
			}
		}
	}
}
if ($tur[gcup]==true){
	$sql = "SELECT syg FROM scups WHERE team = '$koma' AND cup = 'gcup'";
	$result = mysql_query($sql, $db);
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			if ($col=='syg'&&$val==false){
				$km++;
				$isg = true;
			}
		}
	}
}



}
print <<<HERE
<br><img alt='$_SESSION[email]' src='$myrow[avatar]' align = left hspace = 10>
<!-- Выше отображается аватар. Его адрес содержит переменная $myrow[avatar] -->
<a href='page.php?id=$pid'>$origin</a>
HERE;
$sql = "SELECT COUNT(*) FROM messages WHERE poluchatel='$origin' AND new=1";
$nom = mysql_query($sql);
if ($nom) $nom1 = mysql_result($nom,0);
if ($nom1==0){
echo "<br><a href='all_messages.php'>Сообщения</a><br>";
} else {
	echo "<b><br><a href='all_messages.php'>Сообщения("."$nom1".")</a><br></b>";
}
print <<<HERE
<a href='page.php?id=$pid'>Осталось игр: $km</a>
<br><br>



<header class="cf">
<nav>
	<ul>
		<li id="exit">
			<a href="exit.php">Выход</a>
		</li>
	</ul>
</nav>
</header>



<!-- Между оператором  "print <<<HERE" выводится html код с нужными переменными из php -->
<br>
<!-- выше ссылка на выход из аккаунта -->
<!-- Именно здесь можно добавлять формы для отправки комментариев и прочего... -->

HERE;
//************************************************************************************
//при удачном входе пользователю выдается все, что расположено ВЫШЕ между звездочками.
}

$admin = false;
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
if ($group=='admin')
   {
   //Если не действительны, то закрываем доступ
    $admin = true;
   }
}
?> 
   
   
   </div>
   </div>
   <div id = "menu">
 <ul class="dropdown dropdown-horizontal">
	<li><a href="index.php" class="dir">Главная</a>
	</li>
	<li><a href="reglament.php" class="dir">Правила</a>
		<ul>
			<li><a href="reglament.php">Регламент</a></li>
			<li><a href="faq.php">FAQ</a></li>
		</ul>	
	</li>
	<li><a href="input.php" class="dir">Внести результат</a></li>
	<li><a href="tabla.php" class="dir">Лига А</a>
		<ul>
			<li><a href="tabla.php">Таблица</a></li>
			<li><a href="bomba.php">Бомбардиры</a></li>
<?
$sql = "SELECT team FROM leaguea WHERE 1";
$result = mysql_query ($sql, $db);
if(!$result) exit("Ошибка - ".mysql_error().", ".$result);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		echo '<li><a href = "teams.php?id='.$val.'">'.$val.'</a></li>';
	}
} 
?>			
		</ul>
	</li>
	<li><a href="tablb.php" class="dir">Лига В</a>
		<ul>
			<li><a href="tablb.php">Таблица </a></li>
			<li><a href="bombb.php">Бомбардиры</a></li>
<?
$sql = "SELECT team FROM leagueb WHERE 1";
$result = mysql_query ($sql, $db);
if(!$result) exit("Ошибка - ".mysql_error().", ".$result);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		echo '<li><a href = "teams.php?id='.$val.'">'.$val.'</a></li>';
	}
} 
?>
		</ul>
	</li>
		<li><a href="cup.php" class="dir">Кубок</a>
		<ul>
			<li><a href="cup.php">Турнирная сетка</a></li>
			<li><a href="bombcup.php">Бомбардиры</a></li>
		</ul>
	</li>
		<li><a href="./" class="dir">Трансферы</a>
		<ul>
			<li><a href="auction.php">Аукцион</a></li>
			<li><a href="transfers.php">Трансферный стол</a></li>
		</ul>
	</li>
	<li><a href="./" class="dir">Спонсоры</a>
		<ul>
<?
$sql = "SELECT name FROM sponsors WHERE 1";
$result = mysql_query ($sql, $db);
if(!$result) exit("Ошибка - ".mysql_error().", ".$result);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		echo '<li><a href = "sponsors.php?id='.$val.'">'.$val.'</a></li>';
	}
} 
?>
		</ul>
	</li>
	<li><a href="rating.php" class="dir">Рейтинг</a>
	</li>
	<li><a href="about.php" class="dir">О сайте</a></li>
<?
if ($admin){
	echo '<li><a href="./" class="dir">Админ-бар</a>
		<ul>
			<li><a href="addnews.php">Добавить новость</a></li>
			<li><a href="newCoach.php">Управление тренерами</a></li>
			<li><a href="tp.php">Поставить ТП/ТН</a></li>
		</ul>
	</li>';
}
?>	
</ul>  
   </div>
   <div id="sidebar">
   <div id="container">
<div class="content">
		<h1><center>Чат</center></h1>
			<div id="loading"><img src="images/loading.gif" alt="Загрузка..." /></div>
			<p>
		
	<br>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="shoutbox.js"></script>
	<script type="text/javascript" src="jquery.timers.js"></script>
	<?
		if ($input){
		print <<< HERE
		<form method="post" id="form">
		<table>
			<tr>
				<td><label>Сообщение</label></td>
				<td><input class="text" id="message" type="text" MAXLENGTH="255" /></td>
				<input type = hidden id="nick"  value = '$origin' />
			</tr>
			<tr>
				<td></td>
				<td><input id="send" type="submit" value="Отправить" /></td>
			</tr>
		</table>
		</form>
HERE;
		}
		
  $query = "SELECT * FROM session"; 
  $ath = mysql_query($query); 
  if(!$ath) exit("<p>Ошибка в запросе к таблице сессий</p>"); 
  // Если хоть кто-то есть - выводим таблицу 
  echo '<h3>Кто онлайн</h3>';
  if(mysql_num_rows($ath)>0) 
  { 
	$guests = 0;
	$pols = 0;
	$i = 0;
        $dl = 0;
    while($author = mysql_fetch_array($ath)) 
    { 
		
      // Если посетитель не зарегистрирован 
      // выводим вместо его имени - "аноним" 
      if(empty($author['user'])) $guests++; 
      else {
  $query1 = "SELECT id FROM users WHERE origin='$author[user]'"; 
  $ath1 = mysql_query($query1);
$author1 = mysql_fetch_array($ath1);
			if ($i) {echo ',&nbsp';}
$dl += strlen($author['user']);
if ($dl>35){ $dl = 0;
echo "<br><a href='page.php?id=$author1[id]'>".$author['user']."</a>";}else
			{echo "<a href='page.php?id=$author1[id]'>".$author['user']."</a>"; }
			$i = 1;
			$pols++;
		} 
    } 
	if ($pols!=0){ echo '<br><br>';	 }
	echo 'Пользователей:'.$pols.'<br> Гостей: '.$guests;
  } else{
	echo 'Никого нет онлайн';
  }
		
		
	?>	
		</div>
		</div>
   </div>
   <div id="content1">