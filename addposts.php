<?
include("head.php");


<?php
$title = "ќтправка сообщени€";
include ("header.php");
session_start(); //запускаем сессию. ќб€зательно в начале страницы

if (!empty($_SESSION['email']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сесси€х, то провер€ем, действительны ли они
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE email='$email' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //если логин или пароль не действителен
    exit("¬ход на эту страницу разрешен только зарегистрированным пользовател€м!");
   }
}
else {
//ѕровер€ем, зарегистрирован ли вошедший
exit("¬ход на эту страницу разрешен только зарегистрированным пользовател€м!"); }
$result = mysql_query("SELECT origin FROM users WHERE email='$_SESSION[email]'",$db); 
$myrow = mysql_fetch_array($result);//»звлекаем все данные пользовател€ с данным id
if (isset($_POST['text'])) { $text = $_POST['text'];}//получаем текст сообщени€
if (isset($_POST['poluchatel'])) { $poluchatel = $_POST['poluchatel'];}//логин получател€
$author = $myrow['origin'];//логин автора
$date = date("Y-m-d");//дата добавлени€

if (empty($author) or empty($text) or empty($poluchatel) or empty($date)) {//есть ли все необходимые данные? ≈сли нет, то останавливаем
exit ("¬ы ввели не всю информацию, вернитесь назад и заполните все пол€");}

$text = stripslashes($text);//удал€ем обратные слеши
$text = htmlspecialchars($text);//преобразование спецсимволов в их HTML эквиваленты


$result2 = mysql_query("INSERT INTO messages (author, poluchatel, date, text) VALUES ('$author','$poluchatel','$date','$text')",$db);//заносим в базу сообщение

echo "<meta http-equiv='Refresh' content='3; URL=all_messages.php'></head><body>¬аше сообщение отправлено! ¬ы будете перемещены через 3 сек. ≈сли не хотите ждать, то <a href='all_messages.php'>нажмите сюда.</a>";//перенаправл€ем пользовател€
include ("footer.php");
?>


?>