<?php
$title = "Удалить сообщение";
include ("header.php");
session_start();//запускаем сессии

if (!empty($_SESSION['email']) and !empty($_SESSION['password']))
{
//если существует логин и пароль в сессиях, то проверяем, действительны ли они
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE email='$email' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //данные пользователя неверны. 
    exit("Вход на эту страницу разрешен только зарегистрированным пользователям!");
   }
}
else {
//Проверяем, зарегистрирован ли вошедший
exit("Вход на эту страницу разрешен только зарегистрированным пользователям!"); }
$id2 = $_SESSION['id']; //получаем идентификатор своей страницы


if (isset($_GET['id'])) { $id = $_GET['id'];}//получаем через GET запрос идентификатор сообщения, которое нужно удалить

$result = mysql_query("SELECT poluchatel FROM messages WHERE id='$id'",$db); 
$myrow = mysql_fetch_array($result); //нужно уточнить, кому сообщение отправлено
//ведь через GET запрос пользователь может ввести любой идентификатор и как следствие удалить сообщения, которые отправляли не ему.
$result = mysql_query("SELECT origin FROM users WHERE email='$email'",$db); 
$myrow1 = mysql_fetch_array($result);
if ($myrow1['origin'] == $myrow['poluchatel']) {//если сообщение отправляли данному пользователю, то разрешаем его удалить

$result = mysql_query ("DELETE FROM messages WHERE id = '$id' LIMIT 1");//удаляем сообщение
if ($result == 'true') {//если удалено - перенаправляем на страничку пользователя
echo "<html><head><meta http-equiv='Refresh' content='5; URL=all_messages.php'></head><body>Ваше сообщение удалено! Вы будете перемещены через 3 сек. Если не хотите ждать, то <a href='all_messages.php'>нажмите сюда.</a>";
}
else {//если не удалено, то перенаправляем, но выдаем сообщение о неудаче
echo "<html><head><meta http-equiv='Refresh' content='5; URL=all_messages.php'></head><body>Ошибка! Ваше сообщение не удалено. Вы будете перемещены через 3 сек. Если не хотите ждать, то <a href='all_messages.php'>нажмите сюда.</a>"; }

}
else {exit("Вы пытаетесь удалить сообщение, отправленное не вам!");} //если сообщение отправлено не этому пользователю. Значит, он попытался удалить его, введя в адресной строке какой-то другой идентификатор
include ("footer.php");
?>