<?
	$title = "Регистрация";
	include ("header.php");
?>
<h2><center>Регистрация</center></h2>
<form action="save_user.php" method="post" enctype="multipart/form-data">
<!-- save_user.php - это адрес обработчика. То есть, после нажатия на кнопку "Зарегистрироваться", данные из полей отправятся на страничку save_user.php методом "post" -->
  <br>
  <table border = 0>
  <tr>
    <td><label>Ваш e-mail *:</label></td>
    <td><input name="email" type="text" size="15" maxlength="100"></td>
  </tr>
<!-- В текстовое поле (name="login" type="text") пользователь вводит свой логин -->  
  <tr>
   <td> <label>Ваш пароль *:</label></td>
    <td><input name="password" type="password" size="15" maxlength="15"></td>
  </tr>
<!-- В поле для паролей (name="password" type="password") пользователь вводит свой пароль -->   
  <tr>
   <td> <label>Origin ID *:</label></td>
    <td><input name="origin" type="text" size="15" maxlength="100"></td>
  </tr>
	<tr>
   <td> <label>ICQ :</label></td>
    <td><input name="icq" type="text" size="15" maxlength="100"></td>
  </tr>
  <tr>
   <td> <label>Вконтакте :</label></td>
   <td> <input name="vk" type="text" size="15" maxlength="100"></td>
  </tr>
  <tr>
	<td><label>Выберите аватар (jpg, gif, png): </label></td>
    <td><input type="FILE" name="fupload"></td>
	</tr>
  <tr>
  <td>Введите код с картинки *:<br><br>

<img src="code/my_codegen.php"></td>
<td><br><br><input type="text" name="code" size="15" maxlength="100"></td>
</tr>
<!-- В code/my_codegen.php генерируется код и рисуется изображение --> 
	<tr>
	<tr>
	<td colspan = 2 height = 15px></td>
	</tr>
<!-- В переменную fupload отправится изображение, которое выбрал пользователь. --> 



<td colspan = 2 align = center><input type="submit" name="submit" value="Зарегистрироваться"></td>
</tr></table>
<!-- Кнопочка (type="submit") отправляет данные на страничку save_user.php  -->  
</form>
Звездочками (*) обозначены поля, обязательные для заполнения.
<?
	include ("footer.php");
?>
