<?php
$title = "Отправка сообщения";
include ("header.php");
session_start(); //запускаем сессию. Обязательно в начале страницы

if (!empty($_SESSION['email']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сессиях, то проверяем, действительны ли они
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE email='$email' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //если логин или пароль не действителен
    exit("Вход на эту страницу разрешен только зарегистрированным пользователям!");
   }
}
else {
//Проверяем, зарегистрирован ли вошедший
exit("Вход на эту страницу разрешен только зарегистрированным пользователям!"); }
$result = mysql_query("SELECT origin FROM users WHERE email='$_SESSION[email]'",$db); 
$myrow = mysql_fetch_array($result);//Извлекаем все данные пользователя с данным id
if (isset($_POST['text'])) { $text = $_POST['text'];}//получаем текст сообщения
if (isset($_POST['poluchatel'])) { $poluchatel = $_POST['poluchatel'];}//логин получателя
$author = $myrow['origin'];//логин автора
$date = date("Y-m-d");//дата добавления

if (empty($author) or empty($text) or empty($poluchatel) or empty($date)) {//есть ли все необходимые данные? Если нет, то останавливаем
exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля");}

$text = stripslashes($text);//удаляем обратные слеши
$text = htmlspecialchars($text);//преобразование спецсимволов в их HTML эквиваленты


$result2 = mysql_query("INSERT INTO messages (author, poluchatel, date, text) VALUES ('$author','$poluchatel','$date','$text')",$db);//заносим в базу сообщение

echo "<meta http-equiv='Refresh' content='3; URL=all_messages.php'></head><body>Ваше сообщение отправлено! Вы будете перемещены через 3 сек. Если не хотите ждать, то <a href='all_messages.php'>нажмите сюда.</a>";//перенаправляем пользователя
include ("footer.php");
?>