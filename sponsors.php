<?
	if (isset($_GET['id'])) {$id =$_GET['id']; } //id "хозяина" странички
else
{ exit("Вы зашли на страницу без параметра!");} //если не указали id, то выдаем ошибку
	$name = $id;
	$title = $name;
	include "header.php";
?>


	
<style type="text/css">
   TD {
	valign: "top";
   }
   TABLE {
    border-collapse: collapse; /* Убираем двойные линии между ячейками */
   text-align: center;
   valign: top;
   }
   
  </style> 
<?
print "<h1><center>$name</center></h1>";
$sql = "SELECT osn FROM sponsors WHERE name = '$name'";
$result = mysql_query($sql, $db);
$osn = 0;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$osn = $val;
		$osn *=1000000;
	}
}
print <<<HERE
<table border = 0 align = 'center' valign = 'top' width = 100% cellpadding = 10px>
<tr><td colspan = 2>	
<table border = 1 cellpadding = 5 align = 'center' width = 100%>
<tr>
	<th>Единовременная выплата по окончании сезона:</th>
	<td> $osn</td>
</tr>
</table>
</td>
<tr>
<td>
<table border = 1 align = 'center' width = 100%>
<tr>
	<th colspan = 2>Лига</th>
</tr>
<tr>
	<th> Место </th>
	<th> Выплата </th>
</tr>
HERE;
$sql = "SELECT 1l,2l,3l,4l,5l,6l,7l,8l,9l,10l,11l,12l,13l,14l,15l,16l FROM sponsors WHERE name = '$name'";
$result = mysql_query($sql, $db);
$l = array();
$i = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$l[$i] = $val;
		$l[$i] *=1000000;
		$i++;
	}
}
for ($j = 1; $j < $i; $j++){
	print <<<HERE
	<tr>
		<td>$j</td>
		<td>$l[$j]</td>
	</tr>
HERE;
}
$sql = "SELECT 1bl,2bl,3bl,4bl,5bl,6bl,7bl,8bl,9bl,10bl,11bl,12bl,13bl,14bl,15bl FROM sponsors WHERE name = '$name'";
$result = mysql_query($sql, $db);
$l = array();
$i = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$l[$i] = $val;
		$l[$i] *=1000000;
		$i++;
	}
}
print <<<HERE
</table></td><td valign = "top"><table border = 1 align = 'center' width = 100%>
<tr>
	<th colspan = 2>Бомбардиры Лиги</th>
</tr>
<tr>
	<th> Место </th>
	<th> Выплата </th>
</tr>
HERE;
for ($j = 1; $j < $i; $j++){
	print <<<HERE
	<tr>
		<td>$j</td>
		<td>$l[$j]</td>
	</tr>
HERE;
}
print <<<HERE
</table></td></tr><tr><td valign = "top">

<table border = 1 align = 'center' width = 100%>
<tr>
	<th colspan = 2>Кубок</th>
</tr>
<tr>
	<th> Место </th>
	<th> Выплата </th>
</tr>
HERE;
$sql = "SELECT 1c,2c,3c,5c,9c,17c FROM sponsors WHERE name = '$name'";
$result = mysql_query($sql, $db);
$l = array();
$i = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$l[$i] = $val;
		$l[$i] *=1000000;
		$i++;
	}
}
print <<<HERE
<tr>
	<td> Победитель </td>
	<td> $l[1] </td>
</tr>
<tr>
	<td> Финалист </td>
	<td> $l[2] </td>
</tr>
<tr>
	<td> 1/2 финала </td>
	<td> $l[3] </td>
</tr>
<tr>
	<td> 1/4 финала </td>
	<td> $l[4] </td>
</tr>
<tr>
	<td> 1/8 финала </td>
	<td> $l[5] </td>
</tr>
<tr>
	<td > 1/16 финала </td>
	<td> $l[6] </td>
</tr></table></td><td>
HERE;

$sql = "SELECT 1bc,2bc,3bc,4bc,5bc,6bc,7bc,8bc,9bc,10bc FROM sponsors WHERE name = '$name'";
$result = mysql_query($sql, $db);
$l = array();
$i = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$l[$i] = $val;
		$l[$i] *=1000000;
		$i++;
	}
}
print <<<HERE
<table border = 1 align = 'center' width = 100%>
<tr>
	<th colspan = 2>Бомбардиры Кубка</th>
</tr>
<tr>
	<th> Место </th>
	<th> Выплата </th>
</tr>
HERE;
for ($j = 1; $j < $i; $j++){
	print <<<HERE
	<tr>
		<td>$j</td>
		<td>$l[$j]</td>
	</tr>
HERE;
}
print <<<HERE
</table></td></tr><tr><td valign = "top"><table border = 1 align = 'center' width = 100%>
<tr>
	<th colspan = 2>Лига Чемпионов</th>
</tr>
<tr>
	<th> Место </th>
	<th> Выплата </th>
</tr>
HERE;
$sql = "SELECT 1lch,2lch,3lch,5lch,13lch FROM sponsors WHERE name = '$name'";
$result = mysql_query($sql, $db);
$l = array();
$i = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$l[$i] = $val;
		$l[$i] *=1000000;
		$i++;
	}
}
print <<<HERE
<tr>
	<td> Победитель </td>
	<td> $l[1] </td>
</tr>
<tr>
	<td> Финалист </td>
	<td> $l[2] </td>
</tr>
<tr>
	<td> 1/2 финала </td>
	<td> $l[3] </td>
</tr>
<tr>
	<td> 1/4 финала </td>
	<td> $l[4] </td>
</tr>
<tr>
	<td> 4 место в группе </td>
	<td> $l[5] </td>
</tr>
</table></td><td>
HERE;

$sql = "SELECT 1blch,2blch,3blch,4blch,5blch,6blch,7blch,8blch,9blch,10blch FROM sponsors WHERE name = '$name'";
$result = mysql_query($sql, $db);
$l = array();
$i = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$l[$i] = $val;
		$l[$i] *=1000000;
		$i++;
	}
}
print <<<HERE
<table border = 1 align = 'center' width = 100%>
<tr>
	<th colspan = 2>Бомбардиры Лиги Чемпионов</th>
</tr>
<tr>
	<th> Место </th>
	<th> Выплата </th>
</tr>
HERE;
for ($j = 1; $j < $i; $j++){
	print <<<HERE
	<tr>
		<td>$j</td>
		<td>$l[$j]</td>
	</tr>
HERE;
}

print <<<HERE
</table></td></tr><tr><td valign = "top"><table border = 1 align = 'center' width = 100%>
<tr>
	<th colspan = 2>Лига Европы</th>
</tr>
<tr>
	<th> Место </th>
	<th> Выплата </th>
</tr>
HERE;
$sql = "SELECT 1le,2le,3le,5le,9le,13le,17le FROM sponsors WHERE name = '$name'";
$result = mysql_query($sql, $db);
$l = array();
$i = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$l[$i] = $val;
		$l[$i] *=1000000;
		$i++;
	}
}
print <<<HERE
<tr>
	<td> Победитель </td>
	<td> $l[1] </td>
</tr>
<tr>
	<td> Финалист </td>
	<td> $l[2] </td>
</tr>
<tr>
	<td> 1/2 финала </td>
	<td> $l[3] </td>
</tr>
<tr>
	<td> 1/4 финала </td>
	<td> $l[4] </td>
</tr>
<tr>
	<td> 2 место в группе </td>
	<td> $l[5] </td>
</tr>
<tr>
	<td> 3 место в группе </td>
	<td> $l[6] </td>
</tr>
<tr>
	<td> 4 место в группе </td>
	<td> $l[7] </td>
</tr></table></td><td>
HERE;

$sql = "SELECT 1ble,2ble,3ble,4ble,5ble,6ble,7ble,8ble,9ble,10ble FROM sponsors WHERE name = '$name'";
$result = mysql_query($sql, $db);
$l = array();
$i = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$l[$i] = $val;
		$l[$i] *=1000000;
		$i++;
	}
}
print <<<HERE
<table border = 1 align = 'center' width = 100%>
<tr>
	<th colspan = 2>Бомбардиры Лиги Европы</th>
</tr>
<tr>
	<th> Место </th>
	<th> Выплата </th>
</tr>
HERE;
for ($j = 1; $j < $i; $j++){
	print <<<HERE
	<tr>
		<td>$j</td>
		<td>$l[$j]</td>
	</tr>
HERE;
}
print <<<HERE
</table></td></tr><tr><td colspan = 2><table border = 1 align = 'center' width = 100%>
<tr>
	<th>Суперкубок Лиги</th>
	<th>Суперкубок Европы</th>
	<th>GOLDEN CUP</th>
<tr>	
HERE;
$sql = "SELECT scupl,scupe,gcup FROM sponsors WHERE name = '$name'";
$result = mysql_query($sql, $db);
$l = array();
$i = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		$l[$i] = $val;
		$l[$i] *=1000000;
		$i++;
	}
}
print <<<HERE
<tr>
	<td>$l[1]</td>
	<td>$l[2]</td>
	<td>$l[3]</td>
</tr></table></td></tr></table>
HERE;
	
include ("footer.php");
?>
