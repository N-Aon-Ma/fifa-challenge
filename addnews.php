<?
	$title = "Добавить новость";
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
?>
<h2><center>Добавление новости</center></h2>
<form action="save_news.php" method="post" enctype="multipart/form-data">
<!-- save_user.php - это адрес обработчика. То есть, после нажатия на кнопку "Зарегистрироваться", данные из полей отправятся на страничку save_user.php методом "post" -->
  <br>
  <table border = 0>
  <tr>
    <td><label>Название новости *:</label></td>
    <td><input name="name" type="text" size="80" maxlength="100"></td>
  </tr>
<!-- В текстовое поле (name="login" type="text") пользователь вводит свой логин -->  
  <tr>
   <td> <label>Текст *:</label></td>
    <td><textarea name="text" type="textarea" rows = 10 cols = 62 maxlength="1000"></textarea></td>
  </tr>
<!-- В поле для паролей (name="password" type="password") пользователь вводит свой пароль -->   
  <tr>
	<td><label>Изображение *: </label></td>
    <td><input type="FILE" name="fupload"></td>
	</tr>
	<tr>
<td colspan = 2 align = center><input type="submit" name="submit" value="Добавить новость"></td>
</tr></table>
<!-- Кнопочка (type="submit") отправляет данные на страничку save_user.php  -->  
</form>
Звездочками (*) обозначены поля, обязательные для заполнения.	
	
	

<?
	include ("footer.php");
?>