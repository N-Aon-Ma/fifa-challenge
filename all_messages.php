<?php
	$title = "Сообщения";
	include ("header.php");
// вся процедура работает на сессиях. Именно в ней хранятся данные пользователя, пока он находится на сайте. Очень важно запустить их в самом начале странички!!!
session_start();

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
?>
<h2><a href = 'all_users.php'>Отправить сообщение</a></h2><br>
<h2>Входящие сообщения</h2>


<?php

$tmp = mysql_query("SELECT * FROM messages WHERE poluchatel='$origin' ORDER BY id DESC",$db); 
$messages = mysql_fetch_array($tmp);//извлекаем сообщения пользователя, сортируем по идентификатору в обратном порядке, т.е. самые новые сообщения будут вверху

if (!empty($messages['id'])) {
print <<<HERE
<table border=0>
  <tr>
  <th width = 130px>Автор</th><th width = 100px>Дата</th><th>Сообщение</th>
  </tr>
HERE;
do //выводим все сообщения в цикле
  {
$author = $messages['author'];
$result4 = mysql_query("SELECT id FROM users WHERE origin='$author'",$db); //извлекаем аватар автора
$myrow4 = mysql_fetch_array($result4);
$dl = strlen($messages[text]);
$text = substr($messages[text],0,80);
$text = htmlspecialchars($text);
if ($dl>80){
	$text=$text.'...';
}
print <<<HERE
  <tr>
 
  <td><a href='page.php?id=$myrow4[id]'>$author</a></td>
  <td>$messages[date]</td>
  <td><a href = 'messages.php?id=$messages[id]'>$text</a></td>
  </tr>
HERE;
  }
  while($messages = mysql_fetch_array($tmp));
echo '</table>';
                    }
					else {
					//если сообщений не найдено
					echo "Сообщений нет";
					}


	include ("footer.php");
?>