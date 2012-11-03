<?php
include ("header.php");
if (isset($_POST['name'])) { $name = $_POST['name']; if ($name== '') { unset($name);} }
if (isset($_POST['text'])) { $text = $_POST['text']; if ($text == '') { unset($text);} }

if (empty($name)or empty($text) or empty($_FILES['fupload']['name'])) //если пользователь не ввел логин или пароль, то выдаем ошибку и останавливаем скрипт
{
exit ("Вы ввели не всю информацию, вернитесь назад и заполните все поля!"); //останавливаем выполнение сценариев
}

$path_to_90_directory = 'files/';//папка, куда будет загружаться начальная картинка и ее сжатая копия

	

//конец процесса загрузки и присвоения переменной $avatar адреса загруженной авы
if(preg_match('/[.](JPG)|(jpg)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['fupload']['name']))//проверка формата исходного изображения
	 {	
	 	 	
		$filename = $_FILES['fupload']['name'];
		$source = $_FILES['fupload']['tmp_name'];	
		$target = $path_to_90_directory . $filename;
		move_uploaded_file($source, $target);//загрузка оригинала в папку $path_to_90_directory

	if(preg_match('/[.](GIF)|(gif)$/', $filename)) {
	$im = imagecreatefromgif($path_to_90_directory.$filename) ; //если оригинал был в формате gif, то создаем изображение в этом же формате. Необходимо для последующего сжатия
	}
	if(preg_match('/[.](PNG)|(png)$/', $filename)) {
	$im = imagecreatefrompng($path_to_90_directory.$filename) ;//если оригинал был в формате png, то создаем изображение в этом же формате. Необходимо для последующего сжатия
	}
	
	if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)) {
		$im = imagecreatefromjpeg($path_to_90_directory.$filename); //если оригинал был в формате jpg, то создаем изображение в этом же формате. Необходимо для последующего сжатия
	}
	

// Создание квадрата 90x90
// dest - результирующее изображение 
// w - ширина изображения 
// ratio - коэффициент пропорциональности 

$w = 240;  // квадратная 100x100. Можно поставить и другой размер.
$h = 135;
$ratio = 16/9;
// создаём исходное изображение на основе 
// исходного файла и определяем его размеры 
$w_src = imagesx($im); //вычисляем ширину
$h_src = imagesy($im); //вычисляем высоту изображения

         // создаём пустую квадратную картинку 
         // важно именно truecolor!, иначе будем иметь 8-битный результат 
         $dest = imagecreatetruecolor($w,$h); 

         // вырезаем квадратную серединку по x, если фото горизонтальное 
         if (($w_src/$h_src)>$ratio) 
         imagecopyresampled($dest, $im, 0, 0, ($w_src-$h_src*$ratio)/2, 0, $w, $h, $h_src*$ratio, $h_src); 

         // вырезаем квадратную верхушку по y, 
         // если фото вертикальное (хотя можно тоже серединку) 
         if (($w_src/$h_src)<$ratio) 
         imagecopyresampled($dest, $im, 0, 0, 0, ($h_src-$w_src/$ratio)/2, $w, $h, $w_src, $w_src/$ratio);
                      

         // квадратная картинка масштабируется без вырезок 
         if (($w_src/$h_src)==$ratio) 
         imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $h, $w_src, $h_src); 
		 

$date=time(); //вычисляем время в настоящий момент.
imagejpeg($dest, $path_to_90_directory.$date.".jpg");//сохраняем изображение формата jpg в нужную папку, именем будет текущее время. Сделано, чтобы у аватаров не было одинаковых имен.

//почему именно jpg? Он занимает очень мало места + уничтожается анимирование gif изображения, которое отвлекает пользователя. Не очень приятно читать его комментарий, когда краем глаза замечаешь какое-то движение.

$avatar = $path_to_90_directory.$date.".jpg";//заносим в переменную путь до аватара.

$delfull = $path_to_90_directory.$filename; 
unlink ($delfull);//удаляем оригинал загруженного изображения, он нам больше не нужен. Задачей было - получить миниатюру.
}
else 
         {
		 //в случае несоответствия формата, выдаем соответствующее сообщение
         
exit ("Аватар должен быть в формате <strong>JPG,GIF или PNG</strong>"); //останавливаем выполнение сценариев

	     }
//конец процесса загрузки и присвоения переменной $avatar адреса загруженной авы




// если такого нет, то сохраняем данные
$result2 = mysql_query ("INSERT INTO news (name,url_pict,body,putdate) VALUES('$name','$avatar','$text',NOW())");
// Проверяем, есть ли ошибки
if ($result2!='TRUE')
{

exit ("Ошибка! Новость не добавлена."); //останавливаем выполнение сценариев

     }
	echo 'Новость добавлена!';
	include ("footer.php");
?>
<script type="text/javascript">
   document.location.href = "index.php";
</script>