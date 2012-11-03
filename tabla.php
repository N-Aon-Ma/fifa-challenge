<?
	$title = "Лига А";
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
$tournir = 'leaguea';
$goals = $tournir.Goals;
$place = $tournir.Place;
$zag = array("№","Команда","Тренер","И","В","Н","П","ЗМ","ПМ","РМ","О-","О%","Очки");
$sql = "SELECT num,team,coach,i,v,n,p,zm,pm,rm,om,op,score FROM $tournir  ORDER BY $tournir.num ASC";
$result = mysql_query($sql, $db);
print '<center><h3>Таблица</h3></center>';

print "<table border = 2 cellspacing = 0 cellpadding = 3  width = 100%>";
print "<tr>";
$i=1;
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
		if ($col=='num'){
			print " <th>$val</th>";
			$i++;
		} else{	
			if ($col=='team'){
				$tt = $val;
				print "<td><img padding = 0px src = 'images/";
				print $val;
				print ".png' height = 30px align = center></td>";
				print " <td><p align = 'left'>$val</p></td>";
			} else{	
					if ($col!='score'){
						print " <td>$val</td>";
					} else {
						print " <th><b>$val</b></th>";
				}
			}	
		}	
	}
	print "</tr>";
}
print "</table><br> <center><h3>Последние сыгранные матчи</h3></center>";	

$sql = "SELECT rID, goals1, team1, score1, flag, score2,  goals2, team2, dt, screen1, screen2, screen3 FROM results WHERE tournir='$tournir'  ORDER BY results.rID DESC";
$result = mysql_query($sql, $db);
print "<table border = 0 width = 100% ";
$i=1;	
while ($row = mysql_fetch_assoc($result)){
	print "</tr>";
	foreach ($row as $col=>$val){
		switch ($col){
			case 'flag':
				print "<td valign = top>:</td>";
				break;
			case 'screen1':
				print '<td valign = top><a href = "';
				print $val;
				print '">Скрин1</a></td>';
				break;
			case 'screen2':
				print '<td valign = top><a href = "';
				print $val;
				print '">Скрин2</a></td>';
				break;
			case 'screen3':
				print '<td valign = top><a href = "';
				print $val;
				print '">Скрин3</a></td>';
				break;
			case 'score1':
				print " <td valign = top><p align='right'>$val</p></td>";
				break;
			case 'score2':
				print " <td valign = top>$val</td>";
				break;
			case 'goals1':
				$ms1 = unserialize($val);
				break;
			case 'team1':
				print " <td valign = top><p align='right'>$val";
				print "<font size = 1>";
				for ($i=0; $i<=count($ms1);$i++){
					print "$ms1[$i]<br>";
				}
				print "</p></font></td>";
				print "<td valign = top> <img src='images/$val.png' height = 20px align = left></td>";
				break;
			case 'rID':
				print " <td valign = top><p align='right'>$val</p></td>";
				break;
			case 'dt':
				print " <td valign = top><p align='center'>$val</p></td>";
				break;
			case 'goals2':
				$ms2 = unserialize($val);
				break;
			case 'team2':
				print "<td valign = top> <img src='images/$val.png' height = 20px align = right></td>";
				print " <td valign = top><p align='left'>$val";
				print "<font size = 1>";
				for ($i=0; $i<=count($ms2);$i++){
					print "$ms2[$i]<br>";
				}
				print "</p></font></td>";
				break;
			default:
				print "";
		}
	}
	print "</tr>";
}
print "</table>";	
print "</table>";




	include ("footer.php");
?>