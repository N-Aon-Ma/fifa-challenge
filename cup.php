<?
	$title = "Кубок";
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
$tn1 = array();
$hz1 = array();
$az1 = array();
$sh1 = array();
$sa1 = array();
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$sql = "SELECT tName,homezb,homepr,awayzb,awaypr,shome,saway FROM cup WHERE stad = 16 ORDER BY cup.num ASC";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if($col=='tName'){
			$tn1[$i1] = $val;
			$i1++;
		}
		if($col=='homezb'){
			$hz1[$i2] = $val;
			$i2++;
		}
		if($col=='awayzb'){
			$az1[$i3] = $val;
			$i3++;
		}
		if($col=='shome'){
			$sh1[$i4] = $val;
			$i4++;
		}
		if($col=='saway'){
			$sa1[$i5] = $val;
			$i5++;
		}
	}
}
for ($i = 1; $i<=count($sh1); $i++){
	if ($sh1[$i]==0){
		$hz1[$i] = "";
	}
}
for ($i = 1; $i<=count($sa1); $i++){
	if ($sa1[$i]==0){
		$az1[$i] = "";
	}
}

$tn2 = array();
$hz2 = array();
$az2 = array();
$sh2 = array();
$sa2 = array();
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$sql = "SELECT tName,homezb,homepr,awayzb,awaypr,shome,saway FROM cup WHERE stad = 8 ORDER BY cup.num ASC";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if($col=='tName'){
			$tn2[$i1] = $val;
			$i1++;
		}
		if($col=='homezb'){
			$hz2[$i2] = $val;
			$i2++;
		}
		if($col=='awayzb'){
			$az2[$i3] = $val;
			$i3++;
		}
		if($col=='shome'){
			$sh2[$i4] = $val;
			$i4++;
		}
		if($col=='saway'){
			$sa2[$i5] = $val;
			$i5++;
		}
	}
}
for ($i = 1; $i<=count($sh2); $i++){
	if ($sh2[$i]==0){
		$hz2[$i] = "";
	}
}
for ($i = 1; $i<=count($sa2); $i++){
	if ($sa2[$i]==0){
		$az2[$i] = "";
	}
}

$tn3 = array();
$hz3 = array();
$az3 = array();
$sh3 = array();
$sa3 = array();
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$sql = "SELECT tName,homezb,homepr,awayzb,awaypr,shome,saway FROM cup WHERE stad = 4 ORDER BY cup.num ASC";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if($col=='tName'){
			$tn3[$i1] = $val;
			$i1++;
		}
		if($col=='homezb'){
			$hz3[$i2] = $val;
			$i2++;
		}
		if($col=='awayzb'){
			$az3[$i3] = $val;
			$i3++;
		}
		if($col=='shome'){
			$sh3[$i4] = $val;
			$i4++;
		}
		if($col=='saway'){
			$sa3[$i5] = $val;
			$i5++;
		}
	}
}
for ($i = 1; $i<=count($sh3); $i++){
	if ($sh3[$i]==0){
		$hz3[$i] = "";
	}
}
for ($i = 1; $i<=count($sa3); $i++){
	if ($sa3[$i]==0){
		$az3[$i] = "";
	}
}

$tn4 = array();
$hz4 = array();
$az4 = array();
$sh4 = array();
$sa4 = array();
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$sql = "SELECT tName,homezb,homepr,awayzb,awaypr,shome,saway FROM cup WHERE stad = 2 ORDER BY cup.num ASC";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if($col=='tName'){
			$tn4[$i1] = $val;
			$i1++;
		}
		if($col=='homezb'){
			$hz4[$i2] = $val;
			$i2++;
		}
		if($col=='awayzb'){
			$az4[$i3] = $val;
			$i3++;
		}
		if($col=='shome'){
			$sh4[$i4] = $val;
			$i4++;
		}
		if($col=='saway'){
			$sa4[$i5] = $val;
			$i5++;
		}
	}
}
for ($i = 1; $i<=count($sh4); $i++){
	if ($sh4[$i]==0){
		$hz4[$i] = "";
	}
}
for ($i = 1; $i<=count($sa4); $i++){
	if ($sa4[$i]==0){
		$az4[$i] = "";
	}
}

$tn5 = array();
$hz5 = array();
$az5 = array();
$sh5 = array();
$sa5 = array();
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$sql = "SELECT tName,finalzb,finalpr,shome,saway FROM cup WHERE stad = 1 ORDER BY cup.num ASC";
$result = mysql_query ($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if($col=='tName'){
			$tn5[$i1] = $val;
			$i1++;
		}
		if($col=='finalzb'){
			$hz5[$i2] = $val;
			$i2++;
		}
		if($col=='finalpr'){
			$az5[$i3] = $val;
			$i3++;
		}
		if($col=='shome'){
			$sh5[$i4] = $val;
			$i4++;
		}
		if($col=='saway'){
			$sa5[$i5] = $val;
			$i5++;
		}
	}
}
for ($i = 1; $i<=count($sh5); $i++){
	if ($sh5[$i]==0){
		$hz5[$i] = "";
	}
}
for ($i = 1; $i<=count($sa5); $i++){
	if ($sa5[$i]==0){
		$az5[$i] = "";
	}
}

$tournir = 'cup';
$goals = $tournir.Goals;
$place = $tournir.Place;
print '<center><h3>Турнирная сетка</h3></center>';
print <<<HERE
<table border = 1 width = 100%>
<tr>
	<th colspan = 3>1/16</th>
	<th colspan = 3>1/8</th>
	<th colspan = 3>1/4</th>
	<th colspan = 3>1/2</th>
	<th colspan = 2>Финал</th>
</tr>
<tr>
	<td>$tn1[1]</td><td>$hz1[1]</td><td>$az1[1]</td>	
	<td rowspan = 2 valign = bottom>$tn2[1]</td><td rowspan = 2 valign = bottom>$hz2[1]</td><td rowspan = 2 valign = bottom>$az2[1]</td>	
	<td rowspan = 4 valign = bottom>$tn3[1]</td><td rowspan = 4 valign = bottom>$hz3[1]</td><td rowspan = 4 valign = bottom>$az3[1]</td>	
	<td rowspan = 8 valign = bottom>$tn4[1]</td><td rowspan = 8 valign = bottom>$hz4[1]</td><td rowspan = 8 valign = bottom>$az4[1]</td>	
	<td rowspan = 16 valign = bottom>$tn5[1]</td><td rowspan = 16 valign = bottom>$hz5[1]</td>	
</tr>
<tr>
	<td>$tn1[2]</td><td>$az1[2]</td><td>$hz1[2]</td>
</tr>
<tr>
	<td>$tn1[3]</td><td>$hz1[3]</td><td>$az1[3]</td>
	<td rowspan = 2 valign = top>$tn2[2]</td><td rowspan = 2 valign = top>$az2[2]</td><td rowspan = 2 valign = top>$hz2[2]</td>
</tr>
<tr>
	<td>$tn1[4]</td><td>$az1[4]</td><td>$hz1[4]</td>
</tr>
<tr>
	<td>$tn1[5]</td><td>$hz1[5]</td><td>$az1[5]</td>
	<td rowspan = 2 valign = bottom>$tn2[3]</td><td rowspan = 2 valign = bottom>$hz2[3]</td><td rowspan = 2 valign = bottom>$az2[3]</td>	
	<td rowspan = 4 valign = top>$tn3[2]</td><td rowspan = 4 valign = top>$az3[2]</td><td rowspan = 4 valign = top>$hz3[2]</td>
</tr>
<tr>
	<td>$tn1[6]</td><td>$az1[6]</td><td>$hz1[6]</td>
</tr>
<tr>
	<td>$tn1[7]</td><td>$hz1[7]</td><td>$az1[7]</td>
	<td rowspan = 2 valign = top>$tn2[4]</td><td rowspan = 2 valign = top>$az2[4]</td><td rowspan = 2 valign = top>$hz2[4]</td>
</tr>
<tr>
	<td>$tn1[8]</td><td>$az1[8]</td><td>$hz1[8]</td>
</tr>
<tr>
	<td>$tn1[9]</td><td>$hz1[9]</td><td>$az1[9]</td>
	<td rowspan = 2 valign = bottom>$tn2[5]</td><td rowspan = 2 valign = bottom>$hz2[5]</td><td rowspan = 2 valign = bottom>$az2[5]</td>	
	<td rowspan = 4 valign = bottom>$tn3[3]</td><td rowspan = 4 valign = bottom>$hz3[3]</td><td rowspan = 4 valign = bottom>$az3[3]</td>
	<td rowspan = 8 valign = top>$tn4[2]</td><td rowspan = 8 valign = top>$hz4[2]</td><td rowspan = 8 valign = top>$az4[2]</td>	
</tr>
<tr>
	<td>$tn1[10]</td><td>$az1[10]</td><td>$hz1[10]</td>
</tr>
<tr>
	<td>$tn1[11]</td><td>$hz1[11]</td><td>$az1[11]</td>
	<td rowspan = 2 valign = top>$tn2[6]</td><td rowspan = 2 valign = top>$az2[6]</td><td rowspan = 2 valign = top>$hz2[6]</td>
</tr>
<tr>
	<td>$tn1[12]</td><td>$az1[12]</td><td>$hz1[12]</td>
</tr>
<tr>
	<td>$tn1[13]</td><td>$hz1[13]</td><td>$az1[13]</td>
	<td rowspan = 2 valign = bottom>$tn2[7]</td><td rowspan = 2 valign = bottom>$hz2[7]</td><td rowspan = 2 valign = bottom>$az2[7]</td>	
	<td rowspan = 4 valign = top>$tn3[4]</td><td rowspan = 4 valign = top>$az3[4]</td><td rowspan = 4 valign = top>$hz3[4]</td>
</tr>
<tr>
	<td>$tn1[14]</td><td>$az1[14]</td><td>$hz1[14]</td>
</tr>
<tr>
	<td>$tn1[15]</td><td>$hz1[15]</td><td>$az1[15]</td>
	<td rowspan = 2 valign = top>$tn2[8]</td><td rowspan = 2 valign = top>$az2[8]</td><td rowspan = 2 valign = top>$hz2[8]</td>
</tr>
<tr>
	<td>$tn1[16]</td><td>$az1[16]</td><td>$hz1[16]</td>
</tr>
<tr>
	<td>$tn1[17]</td><td>$hz1[17]</td><td>$az1[17]</td>
	<td rowspan = 2 valign = bottom>$tn2[9]</td><td rowspan = 2 valign = bottom>$hz2[9]</td><td rowspan = 2 valign = bottom>$az2[9]</td>
	<td rowspan = 4 valign = bottom>$tn3[5]</td><td rowspan = 4 valign = bottom>$hz3[5]</td><td rowspan = 4 valign = bottom>$az3[5]</td>
	<td rowspan = 8 valign = bottom>$tn4[3]</td><td rowspan = 8 valign = bottom>$hz4[3]</td><td rowspan = 8 valign = bottom>$az4[3]</td>	
	<td rowspan = 16 valign = top>$tn5[2]</td><td rowspan = 16 valign = top>$hz5[2]</td>
</tr>
<tr>
	<td>$tn1[18]</td><td>$az1[18]</td><td>$hz1[18]</td>
</tr>
<tr>
	<td>$tn1[19]</td><td>$hz1[19]</td><td>$az1[19]</td>
	<td rowspan = 2 valign = top>$tn2[10]</td><td rowspan = 2 valign = top>$az2[10]</td><td rowspan = 2 valign = top>$hz2[10]</td>
</tr>
<tr>
	<td>$tn1[20]</td><td>$az1[20]</td><td>$hz1[20]</td>
</tr>
<tr>
	<td>$tn1[21]</td><td>$hz1[21]</td><td>$az1[21]</td>
	<td rowspan = 2 valign = bottom>$tn2[11]</td><td rowspan = 2 valign = bottom>$hz2[11]</td><td rowspan = 2 valign = bottom>$az2[11]</td>
	<td rowspan = 4 valign = top>$tn3[6]</td><td rowspan = 4 valign = top>$az3[6]</td><td rowspan = 4 valign = top>$hz3[6]</td>
</tr>
<tr>
	<td>$tn1[22]</td><td>$az1[22]</td><td>$hz1[22]</td>
</tr>
<tr>
	<td>$tn1[23]</td><td>$hz1[23]</td><td>$az1[23]</td>
	<td rowspan = 2 valign = top>$tn2[12]</td><td rowspan = 2 valign = top>$az2[12]</td><td rowspan = 2 valign = top>$hz2[12]</td>
</tr>
<tr>
	<td>$tn1[24]</td><td>$az1[24]</td><td>$hz1[24]</td>
</tr>
<tr>
	<td>$tn1[25]</td><td>$hz1[25]</td><td>$az1[25]</td>
	<td rowspan = 2 valign = bottom>$tn2[13]</td><td rowspan = 2 valign = bottom>$hz2[13]</td><td rowspan = 2 valign = bottom>$az2[13]</td>
	<td rowspan = 4 valign = bottom>$tn3[7]</td><td rowspan = 4 valign = bottom>$hz3[7]</td><td rowspan = 4 valign = bottom>$az3[7]</td>
	<td rowspan = 8 valign = top>$tn4[4]</td><td rowspan = 8 valign = top>$hz4[4]</td><td rowspan = 8 valign = top>$az4[4]</td>	
</tr>
<tr>
	<td>$tn1[26]</td><td>$az1[26]</td><td>$hz1[26]</td>
</tr>
<tr>
	<td>$tn1[27]</td><td>$hz1[27]</td><td>$az1[27]</td>
	<td rowspan = 2 valign = top>$tn2[14]</td><td rowspan = 2 valign = top>$az2[14]</td><td rowspan = 2 valign = top>$hz2[14]</td>
</tr>
<tr>
	<td>$tn1[28]</td><td>$az1[28]</td><td>$hz1[28]</td>
</tr>
<tr>
	<td>$tn1[29]</td><td>$hz1[29]</td><td>$az1[29]</td>
	<td rowspan = 2 valign = bottom>$tn2[15]</td><td rowspan = 2 valign = bottom>$hz2[15]</td><td rowspan = 2 valign = bottom>$az2[15]</td>
	<td rowspan = 4 valign = top>$tn3[8]</td><td rowspan = 4 valign = top>$az3[8]</td><td rowspan = 4 valign = top>$hz3[8]</td>
</tr>
<tr>
	<td>$tn1[30]</td><td>$az1[30]</td><td>$hz1[30]</td>
</tr>
<tr>
	<td>$tn1[31]</td><td>$hz1[31]</td><td>$az1[31]</td>
	<td rowspan = 2 valign = top>$tn2[16]</td><td rowspan = 2 valign = top>$az2[16]</td><td rowspan = 2 valign = top>$hz2[16]</td>
</tr>
<tr>
	<td>$tn1[32]</td><td>$az1[32]</td><td>$hz1[32]</td>
</tr>
</table> <br> <center><h3>Последние сыгранные матчи</h3></center>
HERE;
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