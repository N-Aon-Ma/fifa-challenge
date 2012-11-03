<?
	date_default_timezone_set('UTC');
	if ($open){
		if (date('G')>=12&&date('G')<18){
			if ($prtransfers){
				$transfers = 1;//какой период трансферов (в течение периода трансферов для аукциона): 0-окно закрыто, 1-середина сезона, 2-начало/конец сезона
			} else{
				$transfers = 2;
				}
			} else {
				$transfers = 0;
			}	
	} else {
		$transfers = 0;
	}
?>