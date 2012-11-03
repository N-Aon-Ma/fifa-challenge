<?php
$db = mysql_connect ("localhost","root","");
mysql_select_db ("fctw1",$db);
mysql_query("set names cp1251");
mysql_query("SET CHARACTER SET ‘utf8′");
$sql = "SELECT * FROM config WHERE 1";
$result = mysql_query($sql, $db);
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='limitin'){
			$limitin = $val;
		}
		if ($col=='limitout'){
			$limitout = $val;
		}
		if ($col=='game'){
			$game = $val;
		}
		if ($col=='roundl'){
			$roundl = $val;
		}
		if ($col=='rounde'){
			$rounde = $val;
		}
		if ($col=='open'){
			$open = $val;
		}
		if ($col=='prtransfers'){
			$prtransfers = $val;
		}
		if ($col=='pls'){
			$pls = $val;
		}
		if ($col=='minpls'){
			$minpls = $val;
		}
		if ($col=='kolTeams'){
			$kolTeams = $val;
		}
		if ($col=='season'){
			$season = $val;
		}
		if ($col=='sCount'){
			$sCount = $val;
		}
		if ($col=='tCount'){
			$tCount = $val;
		}
	}
}
//$limitin = 4; //количество игроков, которых можно приобрести в одно трансферное окно
//$limitout = 4;//соответственно - продать
//$game = true;//тру - можно играть, фолс - нельзя
//$roundl = 2;//круг в лигах
//$rounde = 2;//круг в еврокубках
//$open = false;//фолс-окно закрыто, тру-открыто (вообще)
//$prtransfers = false;// то же самое, но только для прямых трансферов (фолс - начало сезона, тру-середина)	
//$pls = 23;//количество игроков в первоначальной заявке
//$minpls = 20;//минимальное количество игроков в заявке
//$kolTeams = 32;//общее количество команд в карьере
//$season = 1;//какой идёт сезон - менять только после подсчёта бюджетов и сброса статистики

$config['smtp_username'] = 'fifa-challenge@mail.ru'; //Смените на имя своего почтового ящика.
$config['smtp_port'] = '25'; // Порт работы. Не меняйте, если не уверены.
$config['smtp_host'] = 'smtp.mail.ru'; //сервер для отправки почты
$config['smtp_password'] = 'fcmailrrruuu33kms'; //пароль
$config['smtp_charset'] = 'UTF-8'; //кодировка сообщений.
$config['smtp_from'] = 'fifa-challenge'; //Ваше имя - или имя Вашего сайта. Будет показывать при прочтении в поле "От кого"
 
 
function smtpmail($mail_to, $subject, $message, $headers='') {
        global $config;
        $SEND =   "Date: ".date("D, d M Y H:i:s") . " UT\r\n";
        $SEND .=   'Subject: =?'.$config['smtp_charset'].'?B?'.base64_encode($subject)."=?=\r\n";
        if ($headers) $SEND .= $headers."\r\n\r\n";
        else
        {
                $SEND .= "Reply-To: ".$config['smtp_username']."\r\n";
                $SEND .= "MIME-Version: 1.0\r\n";
                $SEND .= "Content-Type: text/plain; charset=\"".$config['smtp_charset']."\"\r\n";
                $SEND .= "Content-Transfer-Encoding: 8bit\r\n";
                $SEND .= "From: \"".$config['smtp_from']."\" <".$config['smtp_username'].">\r\n";
                $SEND .= "To: $mail_to <$mail_to>\r\n";
                $SEND .= "X-Priority: 3\r\n\r\n";
        }
        $SEND .=  $message."\r\n";
         if( !$socket = fsockopen($config['smtp_host'], $config['smtp_port'], $errno, $errstr, 30) ) {
              return false;
         }
 
            if (!server_parse($socket, "220", __LINE__)) return false;
 
            fputs($socket, "HELO " . $config['smtp_host'] . "\r\n");
            if (!server_parse($socket, "250", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, "AUTH LOGIN\r\n");
            if (!server_parse($socket, "334", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, base64_encode($config['smtp_username']) . "\r\n");
            if (!server_parse($socket, "334", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, base64_encode($config['smtp_password']) . "\r\n");
            if (!server_parse($socket, "235", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, "MAIL FROM: <".$config['smtp_username'].">\r\n");
            if (!server_parse($socket, "250", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, "RCPT TO: <" . $mail_to . ">\r\n");
 
            if (!server_parse($socket, "250", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, "DATA\r\n");
 
            if (!server_parse($socket, "354", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, $SEND."\r\n.\r\n");
 
            if (!server_parse($socket, "250", __LINE__)) {
               fclose($socket);
               return false;
            }
            fputs($socket, "QUIT\r\n");
            fclose($socket);
            return TRUE;
}
 
function server_parse($socket, $response, $line = __LINE__) {
        global $config;
    while (substr($server_response, 3, 1) != ' ') {
        if (!($server_response = fgets($socket, 256))) {
                  return false;
                }
    }
    if (!(substr($server_response, 0, 3) == $response)) {
                  return false;
        }
    return true;
}

?>