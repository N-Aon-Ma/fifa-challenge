<?
include("header.php");
$val1 = $_GET['pos'];
print <<<here
<h2><center>name</center></h2>

<form action="save_themes.php?pos=$val1" method="post" enctype="multipart/form-data">

  <br>
  <table border = 0>
  <tr>
    <td><label>Название *:</label></td>
    <td><input name="name" type="text" size="80" maxlength="100"></td>
  </tr>
<!-- В текстовое поле (name="login" type="text") пользователь вводит свой логин -->  
  
  
  
	<tr>
<td colspan = 2 align = center><input type="submit" name="submit" value="Добавить themes"> </td>
</tr>


</table>
<!-- Кнопочка (type="submit") отправляет данные на страничку save_user.php  -->  
</form>
here;

print "$val1";
$timestamp2 = time();
print "c ".date("Y-m-d H:i:s",$timestamp2) ;


print "<td><a href=themes.php?pos=$val1 class=dir>ВЕРНУТЬСЯ К themes</a></td>";
include ("footer.php");
?>

