<?
	$title = "Лига B";
	include ("header.php");
?>
<style type="text/css">
   TH {

   }
   TABLE {
    border-collapse: collapse; /* Убираем двойные линии между ячейками */
   text-align: center;
   }
   
  </style> 
 <?
$tournir = 'leagueb';
$goals = $tournir.Goals;
$place = $tournir.Place;


 print '<h3><center>Бомбардиры</center></h3>';
$zag = array("№","Имя","Команда","Поз","Скилл","Голы");
$sql = "SELECT $place,name,team,position,skill,$goals FROM players WHERE $goals>0  ORDER BY players.$place";
$result = mysql_query($sql, $db);
print "<table border = 1 cellspacing = 0 cellpadding = 3  width = 100%>";
print "<tr>";
foreach ($zag as $value){
	if ($value == "Команда"){
		print "<th colspan = 2>$value</th>";
	}else {
	print " <th>$value</th>";
	}
}	
print "</tr>";
while ($row = mysql_fetch_assoc($result)){
	print "</tr>";
	foreach ($row as $col=>$val){
		if ($col==$place){
			print " <th>$val</th>";
		} else{	
			if ($col=='name'){
				print " <td>$val</td>";
			}else{
				if ($col=='team'){
					print "<td><img src = 'images/$val.png' height = 30px></td><td>$val</td>";
				}else{				
					if ($col!=$goals){
						print " <td>$val</td>";
					} else {
						print " <th><b>$val</b></th>";
					}
				}	
			}	
		}	
	}
	print "</tr>";
}
print "</table>";


	include ("footer.php");
?>