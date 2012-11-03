<?php
  Error_Reporting(E_ALL & ~E_NOTICE); 
	$title = "Новости";
	include ("header.php");
	$pnumber = 30;
	$numchar = 180;
?>
<style>
 .leftimg {
    float:left; /* Выравнивание по левому краю */
    margin: 0px 10px 5px 0px; /* Отступы вокруг картинки */
   }
   TABLE {
    border-collapse: collapse; /* Убираем двойные линии между ячейками */
   text-align: center;
   }
</style> 
          
<?php
  // Устанавлинваем соединение с базой данных

  // Проверяем параметр page, предотвращая SQL-инъекцию
  if(!preg_match("|^[\d]*$|",$_GET['page'])) puterror("Ошибка при обращении к блоку новостей");
  // Проверяем переменную $page, равную порядковому номеру первой новости на странице
  // Защита от инъекционных запросов
  if(!preg_match("|^[\d]*$|",$_GET['id_news'])) puterror("Ошибка при обращении к блоку новостей");

  // Запрашиваем новость id_news (она должна быть видимой hide='show')
  // Если скрипту передан первичный ключ выводимой новости отображаем только одну новость
  if(isset($_GET['id_news']))
  {
    $query = "SELECT * FROM news WHERE id_news=".$_GET['id_news'];
  }
  // если параметр id_news не установлен - выводим все новости
  else
  {
    $query = "SELECT *
              FROM news 
              WHERE putdate <= NOW()
              ORDER BY putdate DESC 
              LIMIT $pnumber";
  }
  $new = mysql_query($query);
  if (!$new) puterror("Ошибка при обращении к блоку новостей");
  if(mysql_num_rows($new) > 0)
  {
    while($news = mysql_fetch_array($new))
    {
	 if(isset($_GET['id_news'])){
	print <<<HERE
	<fieldset>
	<p><img src=$news[url_pict] alt=$news[name] class="leftimg">
	<h2><font size = 4><a href = news.php?id_news=$news[id_news]>$news[name]</a></h2></font>
	$news[body] <br>
	<p align = right>$news[putdate]</p>
	</p>
	</fieldset>
HERE;
	$sql = "SELECT COUNT(*) FROM news_comments WHERE news_id=".$_GET['id_news'];
	$temp = mysql_query($sql,$db);
	if ($temp) {
		$coms = mysql_result($temp,0);
	}
	if ($coms>0){
		$j=0;
		$sql = "SELECT id FROM news_comments WHERE news_id=".$_GET['id_news'];
		$result = mysql_query($sql, $db);
			while ($row = mysql_fetch_assoc($result)){
				foreach ($row as $col=>$val){
					$j++;
					$idis[$j] = $val;
				}
			}
		echo '<table border=0 width = 100% cellpadding = 3px>';
			for ($i=1; $i<=$coms;$i++){
			$sql = "SELECT * FROM news_comments WHERE id = $idis[$i]";
			$result = mysql_query($sql, $db);
			$comments = mysql_fetch_assoc($result);
			$query1 = "SELECT id,avatar,msgs FROM users WHERE origin='$comments[author]'"; 
			$ath1 = mysql_query($query1);
			$author1 = mysql_fetch_array($ath1);
			print <<<HERE
			<tr height = 20px background='images/name.png' ><td colspan=2></td></tr>
			<tr><td width = 5px><img src='$author1[avatar]' align = center hspace = 10></td>
			<td rowspan=2 valign = top align = left>$comments[message]</td></tr>
			<tr><td align = center><a href='page.php?id=$author1[id]'>$comments[author]</a></td></tr>
			<tr><td>Сообщений: $author1[msgs]</td>
			<td align = right><font color = #000>$comments[time]</font></td></tr>
HERE;
		}
		echo '</table>';	
	}
	if ($input){
		$nid = $_GET[id_news];
		print <<<HERE
		<form action='addCom.php' method='post'>
		<h2>Ваш комментарий:</h2>
		<textarea cols='90' rows='4' name='text'></textarea><br>
		<input type='hidden' name='id' value=$nid>
		<input type='hidden' name='author' value='$origin'>
		<input type='submit' name='submit' value='Отправить'>
		</form>
HERE;
	}
} else{
	    echo "<table border = 0 width = 100%><tr><td rowspan = 4 width = 240px>";
	echo "<img src =".$news['url_pict']."></td></tr>";
	echo "<tr><td><h2><a align = right href=news.php?id_news=".$news['id_news'].">".$news['name']."</a></h2></td></tr>";
		$pos = strpos(substr($news['body'],$numchar), " ");
		if(strlen($news['body'])>$numchar){ $srttmpend = "...";}
      else {$srttmpend = "";}
	        echo '<tr><td>'.substr($news['body'], 0, $numchar+$pos).$srttmpend.'</td></tr>';
		echo '<tr align = right valign = bottom><td>'.$news['putdate'].'</td></tr></table><br>';
   
}
	}
}	

	include ("footer.php");
?>