<?

include("header.php");
print <<<here

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




$val = $_GET['pos'];
$val1=$val;


$soool = "SELECT name FROM forums WHERE pos=$val  ";
$t = mysql_query($soool, $db);

while ($ry = mysql_fetch_assoc($t)){
	foreach ($ry as $col=>$vaul){
	//print "$vaul";
	
	
	}}
print "<h6> <a href=forum.php class=dir style='color:black'>форум</a> > <a href=themes.php?pos=$val class=dir style='color:black'>$vaul</a></h6>";
//print "<h6><a href=forums.php	class=dir color =red>форум</a></h6>";


	

//print  "$val";
$zag = array("Темы","сообщений","просмотров","последнее сообщение");
$sql = "SELECT id,id_themes,name,author,time,pos,view FROM themes WHERE pos=$val  ";
$themes = mysql_query($sql, $db);




print "<table border = 3 cellspacing = 1 cellpadding = 3  width = 720px align = center >";
print "<tr>";
$i=1;
//echo "<center> темы </center>";
foreach ($zag as $value){ if($value=="Темы"){	print " <th bgcolor=#B5B5B5 style='color:#1C1C1C' align='left' >$value</th>";} else {print " <th bgcolor=#B5B5B5 style='color:#1C1C1C' align='center' >$value</th>";}}
/*
function isEmpty($table){
 $db=new PDO('$dsn', '$user', '$password');
 $req=$db->prepare("select table_rows from information_schema.tables where table_name=?");
 $req->execute(array($table));
 return $req->fetchColumn()?false:true;
}
print "isEmpty($result)";
*/
while ($row = mysql_fetch_assoc($themes)){
$authorposts=0;

	 $timeposts=0;
$soob=0;	
$cqlid =$row["id"];
$cqlid_themes = $row["id_themes"];
$cqlname =$row["name"];
$cqlpos =$row["pos"];



		$ths = mysql_query("SELECT id,id_themes FROM posts WHERE id_themes=$cqlid_themes ", $db);
		while ($ryf = mysql_fetch_assoc($ths)){
		foreach ($ryf as $col=>$val){
	     if($col=='id')$soob++;}}
		 //----------------------------------------------------
		 
		 
		 mysql_query("UPDATE themes SET kolposts=$soob WHERE id=$cqlid ");
		 
		 
		 
		 
		 
	 //----------------------------------------------------

	 
	 
     $posit = mysql_query("SELECT author,time,id FROM posts WHERE id_themes=$cqlid_themes  ", $db);
	 while($pol= mysql_fetch_assoc($posit)){
	 foreach ($pol as $coj=>$man){
	 
	 if($coj=='author'){
	 
	 $authorposts=$man;}
	 if($coj=='time')
	 $timeposts=$man;
	 }}
	 
	 
	 
	 
	 
	 
	 
	 
	 
echo "</tr><tr> <td style='color:#000080'     bgcolor=#E8E8E8><a href=post_forums.php?id_themes=$cqlid_themes	class=dir style='color:black'>$cqlname</a></td> ";
$cqlautor =$row["author"];
//echo " <td>$cqlautor</td> ";
$cqltime =$row["time"];


//$cqlpos =$row["pos"];

$cqlview=$row["view"];

//echo "<td>$cqlpos</td> ";
echo " <td width=7% bgcolor=#E8E8E8 align='center'>$soob</td>";
echo "<td width=7% bgcolor=#E8E8E8 align='center'> $cqlview  </td>";

if($timeposts!=NULL){
echo "<td width=28% bgcolor=#E8E8E8 align='center'>от $authorposts ";
echo " <br> $timeposts</td> ";}else
{echo "<td width=28% bgcolor=#E8E8E8 ROWSPAN=1 align='center'>-</td> ";
}}
//echo "<td>$cqlid</td>";

//echo "<td>$cqlid_themes</td> ";



print "</tr></table>";
print "<table border = 7 cellspacing = 0 cellpadding = 3  width = 300px align = center>";
print "<td align='center'><a href=addthemes.php?pos=$val1	class=dir color =red style='color:#003080'>ДОБАВИТЬ тему</a></td>";
print "</table>";

include ("footer.php");



?>