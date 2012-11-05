<?php
include ("header.php");

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


$title = "сообщения";
$val1 = $_GET['cqlpos'];
print  "$val1";
$soool = "SELECT name FROM forums WHERE pos=1  ";
$t = mysql_query($soool, $db);

while ($ry = mysql_fetch_assoc($t)){
	foreach ($ry as $col=>$vaul){
	//print "$vaul";
	
	
	}}



if($val2==NULL){
$val2 = $_GET['id_themes'];
};
$val2=$val2;
//print  "$val2";
//$zag = array("id","Тема","автор","время","pos");
$sql = "SELECT id,id_themes,pos,name,author,time,view FROM themes WHERE id_themes=$val2  ";
$themes = mysql_query($sql, $db);
print "<table border = 3 cellspacing = 1 cellpadding = 3  width = 720px align = center >";
print "<tr>";


/*
function isEmpty($table){
 $db=new PDO('$dsn', '$user', '$password');
 $req=$db->prepare("select table_rows from information_schema.tables where table_name=?");
 $req->execute(array($table));
 return $req->fetchColumn()?false:true;
}*/
//print "isEmpty($result)";
while ($row = mysql_fetch_assoc($themes)){
	foreach ($row as $col=>$val){
//	if($col=='id'){
	//$cqlid=$val;
//	print "</tr><tr>";
	//print "<td> $val</td>";}
	if($col=='pos'){$ps=$val;}
		if ($col=='name'){
		
						
print "<h6> <a href=forum.php class=dir style='color:black'>форум</a> > <a href=themes.php?pos=$ps class=dir style='color:black'>$vaul</a> > $val</h6>";
			$val =  substr($val, 0, 21);
			print " <td bgcolor=#B5B5B5 style='color:#1C1C1C' align='left' COLSPAN=3>$val</td>";
		//	print "<td><a>$val</a></td>";
			
			//	
			$i++;	
		} 
	/*	else{
		if(($col!='id_themes')&&($col!='view')&&($col!='id')){
			$val =  substr($val, 0, 21);
				print "<td>$val </td>";
			}
		if($col=='view'){
		$val++;
		 mysql_query("UPDATE themes SET view=$val WHERE id=$cqlid ");
		
		
		}	
		}*/
}}
//print "</tr></table>";

$val = $_GET['id_themes'];

$valy=$val;
//print "$val";
$zag = array("Сообщение","автор","время");
$sql = "SELECT author,time,id,id_themes,name FROM posts WHERE id_themes=$val2  ";

$themes = mysql_query($sql, $db);
//print "<table border = 1 cellspacing = 0 cellpadding = 3  width = 600px align = center>";
print "<tr>";
//while ($roli = mysql_fetch_assoc($themes)){
//$cqtlname=$roli["author"];}
//if(!empty($cqtlname)){
//foreach ($zag as $value){print " <th>$value</th>";} //}
/*while ($row = mysql_fetch_assoc($themes)){
	foreach ($row as $col=>$val){
	//if($col=='id_themes'){$ps=$val;}
			if ($col=='name'){
	
			print "</tr><tr>";
			

			//$val =  substr($val, 0, 21);
			print "<td COLSPAN=3 #FFFFFF><a>$val</a></td>";
			//	
			print "</tr>";
			print "<td bgcolor=#B5B5B5 style='color:#1C1C1C' COLSPAN=3> $avatar</td><tr>";
			$i++;	
		} else{
		if($col!='id_themes'){
			$val =  substr($val, 0, 21);
				print "<td>$val</td>";
			}
			
		}
}}
*/
while($row=mysql_fetch_assoc($themes)){
$cqlauthor=$row["author"];
$cqltime=$row["time"];
$cqlname=$row["name"];
echo "</tr><tr>";
echo "<td bgcolor=#E8E8E8>$cqlauthor</td>";
echo "<td bgcolor=#E8E8E8>$cqltime";
echo " $msgs</td>";

echo "<tr>";
echo "<td >тут будет ава </td>";
echo "<td  COLSPAN=3 >$cqlname <br> <br></td>";




}






//print "$valy";
print <<<here

<form  method="post" action="save_posts.php?id_themes=$valy">

  <br>
  <table border = 0>
  
<!-- В текстовое поле (name="login" type="text") пользователь вводит свой логин -->  
  <tr>
   <td> <label></label></td>
    <td><textarea name="name" type="textarea" rows = 8 cols = 75 maxlength="1000"></textarea></td>
  </tr>
  
  
	<tr>
<td colspan = 2 align = center><input type="submit" name="submit" value="Отправит сообщение"> </td>
</tr>


</table>
<!-- Кнопочка (type="submit") отправляет данные на страничку save_user.php  -->  
</form>
here;
$name = $_POST['name'];
if($name!=NULL){


$sql = "	 FROM posts  ";
$result = mysql_query($sql, $db);


//$description = $_POST['name'];

//$name = $_POST['name'];
//	$id_forums=12;
$sql = <<<HERE
INSERT INTO `posts`(
 `name`, `putfile`, `author`,'time','locked') VALUES (
`$name`, `$putfile`, `$author`,'$time','$locked')
HERE;
mysql_query($sql);



}


$yes=$_GET['description'];

print "</tr></table>";

include ("footer.php");

?>