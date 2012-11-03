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