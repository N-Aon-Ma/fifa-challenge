<?php
include_once ("bd.php");
function getContent($db, $num){
	$res = @mysql_query("SELECT date, user, message FROM shoutbox ORDER BY date DESC LIMIT ".$num, $db);
	if(!$res)
		die("Error: ".mysql_error());
	else
		return $res;
}
function insertMessage($user, $message){
	$query = sprintf("INSERT INTO shoutbox(user, message) VALUES('%s', '%s');", mysql_real_escape_string(strip_tags($user)), mysql_real_escape_string(strip_tags($message)));
	$res = @mysql_query($query);
	if(!$res)
		die("Error: ".mysql_error());
	else
		return $res;
}

/******************************
	MANAGE REQUESTS
/******************************/
if(!$_POST['action']){

	header ("Location: index.php"); 
}
else{
	switch($_POST['action']){
		case "update":
			$res = getContent($db, 15);
			while($row = mysql_fetch_array($res)){
				$resultat .= "<p><strong>".$row['user']."</strong><img src=\"images/bullet.gif\" alt=\"-\" />".$row['message']." <span class=\"date\">".$row['date']."</span></p>";
			}
			echo $resultat;
			break;
		case "insert":
			echo insertMessage($_POST['nick'], $_POST['message']);
			break;
	}
	mysql_close($db);
}


?>