<?php
session_start();
if (empty($_SESSION['email']) or empty($_SESSION['password'])) 
{
//если не существует сессии с логином и паролем, значит на этот файл попал невошедший пользователь. Ему тут не место. Выдаем сообщение об ошибке, останавливаем скрипт
exit ("Доступ на эту страницу разрешен только зарегистрированным пользователям. Если вы зарегистрированы, то войдите на сайт под своим E-mail и паролем<br><a href='../head/index.php'>Главная страница</a>");
}

unset($_SESSION['password']);
unset($_SESSION['email']); 
unset($_SESSION['id']);// уничтожаем переменные в сессиях

setcookie("auto", "", time()+9999999);//очищаем автоматический вход
exit("<html><head><meta http-equiv='Refresh' content='0; URL=index.php'></head></html>");
// отправляем пользователя на главную страницу.
?>