<? 
include("header.php");
print <<<here
<html>
<body>
<style type="text/css">
A {
color: #f00 /* Цвет ссылок */
}

A:visited {
color: #666 /* Цвет посещенных ссылок */
}

A:hover { 
text-decoration: none; /* Убираем обычное подчеркивание */
border-bottom: 1px dashed blue /* Добавляем пунктирную линию под текстом */
}
</style>
here;
//include("themes.php");
?>
<?
	

$zag = array("Форум/описание","темы","сообщения");
$sql = "SELECT pos,name,description,kol_themes,kol_posts FROM forums  ";
$result = mysql_query($sql, $db);
print "<table border = 3 cellspacing = 1 cellpadding = 3  width = 720px align = center >";
print "<tr>";
$i=1;
print "<h6>форум</h6>";
print "<font size=4 face=Arial color=#FF0000 ><center>ВЫ ПОПАЛИ НА ФОРУМ</center></font>";

?>

<?
//print "<tr>";
foreach ($zag as $value){	print " <th bgcolor=#B5B5B5 style='color:#1C1C1C' align='left' >$value</th>";} 
//print "</tr>";

//
/*
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
	if($col=='pos'){$ps=$val;}
		if ($col=='name'){
		
			print "</tr><tr>";
			             
			$val =  substr($val, 0, 21);
			print "<th><a href=themes.php?pos=$ps	class=dir>$val</a></th>";
			$i++;	
			
		} else{
		if($col=='description'){
			$val =  substr($val, 0, 21);
				print "<td>$val</td>";
			}
			}
		}
		if($col=='kol_themes'){
		
		print "<th>$val </th>";
		
		}
		if($col=='kol_posts'){
		
		print "<th>$val i</th>" ;
		}
}
*/
while ($row = mysql_fetch_assoc($result)){

//$sql = "SELECT id_themes,name,author,time,pos FROM themes WHERE pos=$row  ";




//print "next";
$cqlname =$row["name"];
$cqlpos =$row["pos"];
$soob=0;
$kol=0;
$ths = mysql_query("SELECT id,id_themes,kolposts FROM themes WHERE pos=$cqlpos ", $db);
while ($ry = mysql_fetch_assoc($ths)){
	foreach ($ry as $col=>$val){
	if($col=='kolposts'){
	$soob+=$val;
	
	
	}
	if($col=='id'){
	//	$thiis = mysql_query("SELECT id,id_themes FROM posts WHERE id_themes=$val ", $db);
	//	while ($ryf = mysql_fetch_assoc($thiis)){
	//	foreach ($ryf as $colo=>$valo){
	//     if($col=='id')$soob++;
	$kol++;}//}}
}
}
/*
$ths = mysql_query("SELECT id FROM posts WHERE pos=$cqlpos ", $db);
while ($ry = mysql_fetch_assoc($ths))
	foreach ($ry as $col=>$val)
$kol++;
*/

$cqldescription = $row["description"];
$cqlautor =$row["kol_themes"];
$cqltime =$row["kol_posts"];
$cqlname =  substr($cqlname, 0, 30);
$cqldescription =  substr($cqldescription, 0, 50);

echo "</tr><tr> <td style='color:#000080'     bgcolor=#E8E8E8><a href=themes.php?pos=$cqlpos	class=dir style='color:black'>$cqlname </a> ";
//echo strlen($cqlname);
echo "<br >$cqldescription</td> ";
echo " <td bgcolor=#E8E8E8  width=7% align='center' > $kol     </td>";

echo " <td bgcolor=#E8E8E8 width=9% align='center'> $soob   </td> ";


//echo "<td>$cqlid_themes</td> ";
}
/*
function isEmpty($table){
 $db=new PDO('$dsn', '$user', '$password');
 $req=$db->prepare("select table_rows from information_schema.tables where table_name=?");
 $req->execute(array($table));
 return $req->fetchColumn()?false:true;
}
print "isEmpty($result)";
*/
print "</tr>"; 
print "</table>";



print "<table border = 7 cellspacing = 0 cellpadding = 3  width = 300px align = center>";
print "<td align='center'><a href=addforums.php	class=dir color =red style='color:#003080' align='right'>ДОБАВИТЬ ФОРУМ</a></td>";
print "</table>";


// Добавляем запись в нашу таблицу customer
// т.е. делаем sql запрос




















	include ("footer.php");
?>

