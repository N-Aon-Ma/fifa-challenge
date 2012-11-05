<?
include("header.php");

?>
<h2><center>name</center></h2>

<form action="save_forums.php" method="post" >

  <br>
  <table border = 0>
  <tr>
    <td><label>Название*:</label></td>
    <td><input name="name" type="text" size="80" maxlength="100"></td>
  </tr>
<!-- В текстовое поле (name="login" type="text") пользователь вводит свой логин -->  
  <tr>
   <td> <label>discribe *:</label></td>
    <td><textarea name="description" type="textarea" rows = 10 cols = 62 maxlength="1000"></textarea></td>
  </tr>
  
  
	<tr>
<td colspan = 2 align = center><input type="submit" name="submit" value="Добавить Форум"> </td>
</tr>


</table>
<!-- Кнопочка (type="submit") отправляет данные на страничку save_user.php  -->  
</form>
<?



print "<td><a href=forum.php class=dir>ВЕРНУТЬСЯ К ФОРУМУ</a></td>";
include ("footer.php");
?>