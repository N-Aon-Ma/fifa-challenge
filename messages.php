<?php
	$title = "Сообщение";
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
$id = $_GET['id'];
if (empty($id)){
	echo 'Некорректный переход на страницу';
	include "footer.php";
	die();
}
$sql = "SELECT * FROM messages WHERE id=$id";
$result = mysql_query($sql,$db);
$messages = mysql_fetch_assoc($result);
if ($messages[poluchatel]!=$origin){
	echo "Это сообщение предназначено не вам";
	include "footer.php";
	die();
}
?>

<h2>Сообщение</h2>


<?php
$author = $messages['author'];
$result4 = mysql_query("SELECT avatar,id FROM users WHERE origin='$author'",$db); //извлекаем аватар автора
$myrow4 = mysql_fetch_array($result4);
$sql = "UPDATE messages SET new=0 WHERE id=$id";
mysql_query($sql);
if (!empty($myrow4['avatar'])) {//если такового нет, то выводим стандартный(может этого пользователя уже давно удалили)
$avatar = $myrow4['avatar'];
}
else {$avatar = "avatars/net-avatara.jpg";}
 printf("
  <table>
  <tr>
  <td><a href='page.php?id=%s'><img alt='аватар' src='%s'></a></td>
  
  <td>Автор: <a href='page.php?id=%s'>%s</a><br>
      Дата: %s<br>
	  Сообщение:<br>
	 %s<br>
	 <a href='drop_post.php?id=%s'>Удалить</a>
  
  </td>  
  </tr>
  </table><br>
  ",$myrow4['id'],$avatar,$myrow4['id'],$author,$messages['date'],$messages['text'],$messages['id']);
	print <<<HERE
<form action='post.php' method='post'>
<h2>Ответить:</h2>
<textarea cols='80' rows='4' name='text'></textarea><br>
<input type='hidden' name='poluchatel' value='$author'>
<input type='hidden' name='id' value='$myrow[id]'>
<input type='submit' name='submit' value='Отправить'>
</form>
HERE;

	include ("footer.php");
?>