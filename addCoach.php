<?php
include_once ("header.php");
if (isset($_POST['coach'])) { $coach = $_POST['coach']; if ($coach== '') { unset($coach);} }
if (isset($_POST['team'])) { $team = $_POST['team']; if ($team == '') { unset($team);} }

if (empty($coach)or empty($team)) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
{
exit ("Эта страница только для администрации"); //останавливаем выполнение сценариев
}
//конец процесса загрузки и присвоения переменной $avatar адреса загруженной авы
// файл bd.php должен быть в той же папке, что и все остальные, если это не так, то просто измените путь 


$sql = <<<HERE
UPDATE users
SET
	team = '$team'
WHERE
	origin = '$coach'
HERE;
mysql_query($sql);

$sql = <<<HERE
UPDATE teams
SET
	coach = '$coach'
WHERE
	tName = '$team'
HERE;
mysql_query($sql);

$sql = "SELECT leag,euro FROM teams  WHERE tName = '$team'";
$result = mysql_query($sql, $db);
$row = mysql_fetch_assoc($result);
if ($row[leag]!=""){
	$sql = <<<HERE
UPDATE $row[leag]
SET
	coach = '$coach'
WHERE
	team = '$team'
HERE;
mysql_query($sql);
}
if ($row[euro]!=""){
	$sql = <<<HERE
UPDATE $row[euro]
SET
	coach = '$coach'
WHERE
	team = '$team'
HERE;
mysql_query($sql);
}

include ("footer.php");
?>
<script type="text/javascript">
   document.location.href = "index.php";
</script>