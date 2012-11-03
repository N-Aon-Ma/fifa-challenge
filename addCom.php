<?php
$title = "Отправка комментария";
include ("header.php");
$text = $_POST['text'];
$author = $_POST['author'];
$id = $_POST['id'];
if (empty($text) or empty($author) or empty($id) or empty($origin)){
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="index.php";', 3000 );
	</script>
	<h3><center>Некорректный переход на страницу</h3></center>
HERE;
	include "footer.php";
	die();
}

$text = stripslashes($text);//удаляем обратные слеши
$text = htmlspecialchars($text);//преобразование спецсимволов в их HTML эквиваленты


$result2 = mysql_query("INSERT INTO news_comments (news_id, author, message) VALUES ($id,'$author','$text')",$db);//заносим в базу сообщение
$sql = "UPDATE users SET msgs=msgs+1 WHERE origin='$author'";
mysql_query($sql,$db);
print <<<HERE
	<script type = "text/javascript">
	setTimeout( 'location="news.php?id_news=$id";', 3000 );
	</script>
	<h3><center>Комментарий добавлен. Сейчас Вы будете перемещены</h3></center>
HERE;
include ("footer.php");
?>