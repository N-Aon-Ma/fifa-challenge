<?
include("head.php");


<?php
$title = "�������� ���������";
include ("header.php");
session_start(); //��������� ������. ����������� � ������ ��������

if (!empty($_SESSION['email']) and !empty($_SESSION['password']))
{
//���� ���������� ����� � ������ � �������, �� ���������, ������������� �� ���
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$result2 = mysql_query("SELECT id FROM users WHERE email='$email' AND password='$password' AND activation='1'",$db); 
$myrow2 = mysql_fetch_array($result2); 
if (empty($myrow2['id']))
   {
   //���� ����� ��� ������ �� ������������
    exit("���� �� ��� �������� �������� ������ ������������������ �������������!");
   }
}
else {
//���������, ��������������� �� ��������
exit("���� �� ��� �������� �������� ������ ������������������ �������������!"); }
$result = mysql_query("SELECT origin FROM users WHERE email='$_SESSION[email]'",$db); 
$myrow = mysql_fetch_array($result);//��������� ��� ������ ������������ � ������ id
if (isset($_POST['text'])) { $text = $_POST['text'];}//�������� ����� ���������
if (isset($_POST['poluchatel'])) { $poluchatel = $_POST['poluchatel'];}//����� ����������
$author = $myrow['origin'];//����� ������
$date = date("Y-m-d");//���� ����������

if (empty($author) or empty($text) or empty($poluchatel) or empty($date)) {//���� �� ��� ����������� ������? ���� ���, �� �������������
exit ("�� ����� �� ��� ����������, ��������� ����� � ��������� ��� ����");}

$text = stripslashes($text);//������� �������� �����
$text = htmlspecialchars($text);//�������������� ������������ � �� HTML �����������


$result2 = mysql_query("INSERT INTO messages (author, poluchatel, date, text) VALUES ('$author','$poluchatel','$date','$text')",$db);//������� � ���� ���������

echo "<meta http-equiv='Refresh' content='3; URL=all_messages.php'></head><body>���� ��������� ����������! �� ������ ���������� ����� 3 ���. ���� �� ������ �����, �� <a href='all_messages.php'>������� ����.</a>";//�������������� ������������
include ("footer.php");
?>


?>