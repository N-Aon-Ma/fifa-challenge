<?
	$title = "Рейтинг";
	include ("header.php");

$zag = array("№","Игрок","Команда","Рейтинг");
$sql = "SELECT origin,team,rating FROM users WHERE team!=''  ORDER BY users.rating DESC";
$result = mysql_query($sql, $db);
print "<table border = 1 cellspacing = 0 cellpadding = 3  width = 600px align = center>";
print "<tr>";
$i=1;
foreach ($zag as $value){
	if ($value == "Команда"){
		print "<th colspan = 2>$value</th>";
	}else {
	print " <th>$value</th>";
	}
} 
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='origin'){
			print "</tr><tr><th>$i</th>";
			print "<td>$val</td>";
			$i++;	
		} else{
			if ($col == 'team'){
				print "<td align = 'center' width = 45px><img padding = 0px src = 'images/$val.png' height = 30px align = center></td>";
				print " <td><p align = 'left'>$val</p></td>";
			} else{
				print "<td>$val</td>";
			}
		}
}
}
print "</tr>"; 
print "</table>";
	include ("footer.php");
?>