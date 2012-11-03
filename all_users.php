<?php
// вся процедура работает на сессиях. Именно в ней хранятся данные пользователя, пока он находится на сайте. Очень важно запустить их в самом начале странички!!!
session_start();

	$title = "Список пользователей";
	include ("header.php");


// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 

if (!empty($_SESSION['email']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сессиях, то проверяем, действительны ли они
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE email='$email' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //если данные пользователя не верны
    exit("Вход на эту страницу разрешен только зарегистрированным пользователям");
   }
}
else {
//Проверяем, зарегистрирован ли вошедший
exit("Вход на эту страницу разрешен только зарегистрированным пользователям"); }
?>
<html>

<h2>Список пользователей</h2>


<?php

$result = mysql_query("SELECT origin,id FROM users ORDER BY origin",$db); //извлекаем логин и идентификатор пользователей
$myrow = mysql_fetch_array($result);
do
{
//выводим их в цикле
printf("<a href='page.php?id=%s'>%s</a><br>",$myrow['id'],$myrow['origin']);
}
while($myrow = mysql_fetch_array($result));


	include ("footer.php");
?>
