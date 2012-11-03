<?
	$title = "FIFA Challenge - Онлайн Карьера FIFA 13";
	include ("header.php");
	$pnumber = 5;
	$numchar = 300;
?>


<table border = 0 width = 100%><tr><td><h2><p align = left>НОВОСТИ</p></h2></td>

<?php
  // Выставляем уровень обработки ошибок (http://www.softtime.ru/info/articlephp.php?id_article=23)
  Error_Reporting(E_ALL & ~E_NOTICE); 

  // Этот файл выводит первые $pnumber новостей
  // Устанавлинваем соединение с базой данных
?>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<?php
  // Выясняем общее количество новостей в базе данных, для того чтобы
  // правильно отображать ссылки на последующие новости.
  $tot = mysql_query("SELECT count(*) FROM news WHERE putdate <= NOW()");
  if ($tot)
  {
    $total = mysql_result($tot,0);
    // Если в базе новостей меньше чем $pnumber
    // выводим их без вывода ссылки "Все новости".
    if($pnumber < $total) echo "<td align = right valign = top><a href=news.php>Все новости</a></td></tr></table>";
  else { echo '</tr></table>';}
  }
  else puterror("Ошибка при обращении к блоку новостей");
  // Запрашиваем все видимые новости, т.е. те, у которых в базе данных hide='show',
  // если это поле будет равно 'hide', новость не будет отображаться на странице
    // Определяем версию сервера
  $query = "SELECT VERSION()";
  $ver = mysql_query($query);
  if(!$ver) exit("Ошибка при определении версии MySQL-сервера");
  $version = mysql_result($ver, 0);
  list($major, $minor) = explode(".", $version);
  // Если версия выше 4.1 сообщаем серверу, что будем работать с
  // кодировкой cp1251
  $ver = $major.".".$minor;
  if((float)$ver >= 4.1)
  {
    mysql_query("SET NAMES 'cp1251'");
  }
  $query = "SELECT * FROM news 
            WHERE putdate <= NOW()
            ORDER BY putdate DESC
            LIMIT $pnumber";
  $new = mysql_query($query);
  if(mysql_num_rows($new) > 0)
  {

    while($news = mysql_fetch_array($new))
    {
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
?>


<?
	include ("footer.php");
?>