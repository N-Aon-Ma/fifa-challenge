<?php
$title = "Забыли пароль?";
include ("header.php");
if (isset($_POST['email'])) { $email = $_POST['email']; if ($email == '') { unset($email);} } //заносим введенный пользователем e-mail, если он пустой, то уничтожаем переменную

if (isset($email)) {//если существуют необходимые переменные  
 
	
	$result = mysql_query("SELECT id FROM users WHERE email='$email' AND activation='1'",$db);//такой ли у пользователя е-мейл
	$myrow = mysql_fetch_array($result);
	if (empty($myrow['id']) or $myrow['id']=='') {
		//если активированного пользователя с таким логином и е-mail адресом нет
		exit ("Пользователя с таким адресом e-mail не обнаружено <a href='index.php'>Главная страница</a>");
		}
	//если пользователь с таким логином и е-мейлом найден, то необходимо сгенерировать для него случайный пароль, обновить его в базе и отправить на е-мейл
	$datenow = date('YmdHis');//извлекаем дату 
	$new_password = md5($datenow);// шифруем дату
	$new_password = substr($new_password, 2, 6);	//извлекаем из шифра 6 символов начиная со второго. Это и будет наш случайный пароль. Далее запишем его в базу, зашифровав точно так же, как и обычно.
	
$new_password_sh = strrev(md5($new_password))."b3p6f";//зашифровали
mysql_query("UPDATE users SET password='$new_password_sh' WHERE email='$email'",$db);// обновили в базе
	//формируем сообщение
	
	$message = "Здравствуйте, ".$email."! Мы сгенерировали для Вас пароль, теперь Вы сможете войти, используя его. После входа желательно его сменить. Пароль:\n".$new_password;//текст сообщения
	mail($email, "Восстановление пароля", $message, "Content-type:text/plane; Charset=windows-1251\r\n");//отправляем сообщение
	smtpmail($email, "Восстановление пароля", $message);//отправляем сообщение
	
	echo "<html><head><meta http-equiv='Refresh' content='5; URL=index.php'></head><body>На Ваш e-mail ".$email." отправлено письмо с паролем. Вы будете перемещены через 5 сек. Если не хотите ждать, то <a href='index.php'>нажмите сюда.</a></body></html>";//перенаправляем пользователя
	}


else {//если данные еще не введены


echo '
<h2>Забыли пароль?</h2>
<form action="#" method="post">
Введите Ваш e-mail: <br><input type="text" name="email"><br><br>
<input type="submit" name="submit" value="Отправить">
</form>
';

	

}
include ("footer.php");

?>