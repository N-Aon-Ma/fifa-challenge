<?
include "bd.php";
if ($sCount!=4){
	$sql = "UPDATE config SET sCount=sCount+1 WHERE 1";
	mysql_query($sql,$db);
	die();
} else{
	$sql = "UPDATE config SET sCount=1 WHERE 1";
	mysql_query($sql,$db);
}
$sql = "SELECT tName,budget,dolg,sponsor,leag,kZarp,scupl,scupe,gcup,euro FROM teams WHERE 1 ORDER BY tID";
$result = mysql_query($sql, $db);
$teams = array();
$budgets = array();
$dolgs = array();
$sponsors = array();
$leags = array();
$kZarps = array();
$scupls = array();
$scupes = array();
$gcups = array();
$euros = array();
$i1 = 1;
$i2 = 1;
$i3 = 1;
$i4 = 1;
$i5 = 1;
$i6 = 1;
$i7 = 1;
$i8 = 1;
$i9 = 1;
$i10 = 1;
while ($row = mysql_fetch_assoc($result)){
	foreach ($row as $col=>$val){
		if ($col=='tName'){
			$teams[$i1] = $val;
			$i1++;
		}
		if ($col=='budget'){
			$budgets[$i2] = $val;
			$i2++;
		}
		if ($col=='dolg'){
			$dolgs[$i3] = $val;
			$i3++;
		}
		if ($col=='sponsor'){
			$sponsors[$i4] = $val;
			$i4++;
		}
		if ($col=='leag'){
			$leags[$i5] = $val;
			$i5++;
		}
		if ($col=='kZarp'){
			$kZarps[$i6] = $val;
			$i6++;
		}
		if ($col=='scupl'){
			$scupls[$i7] = $val;
			$i7++;
		}
		if ($col=='scupe'){
			$scupes[$i8] = $val;
			$i8++;
		}
		if ($col=='gcup'){
			$gcups[$i9] = $val;
			$i9++;
		}
		if ($col=='euro'){
			$euros[$i10] = $val;
			$i10++;
		}
	}
}
for ($i = 1; $i < $i1; $i++){
	$i11 = 1;
	$sql = "SELECT * FROM sponsors WHERE name = '$sponsors[$i]'";
	$result = mysql_query($sql, $db);
	$sps = array();
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			$sps[$i11] = $val;
			$i11++;
		}
	}
	$budgets[$i] += $sps[3]*1000000;
	$sql = "SELECT num FROM $leags[$i] WHERE team = '$teams[$i]'";
	$result = mysql_query($sql, $db);
	$ml = 0;
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			$ml = $val;
		}
	}
	$budgets[$i] += $sps[$ml+3]*1000000;
	$sql = "SELECT stad FROM cup WHERE tName = '$teams[$i]' ORDER BY cup.stad DESC";
	$result = mysql_query($sql, $db);
	$mc = 0;
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			$mc = $val;
		}
	}
	if ($mc==16){
		$x = 25;
	}
	if ($mc==8){
		$x = 24;
	}
	if ($mc==4){
		$x = 23;
	}
	if ($mc==2){
		$x = 22;
	}
	if ($mc==1){
		$sql = "SELECT finalzb,finalpr FROM cup WHERE stad = 1 AND tName = '$teams[$i]'";
		$result = mysql_query($sql, $db);
		$fz = 0;
		$fp = 0;
		while ($row = mysql_fetch_assoc($result)){
			foreach ($row as $col=>$val){
				if ($col == 'finalzb'){
					$fz = $val;
				}
				if ($col == 'finalpr'){
					$fp = $val;
				}
			}
		}
		if ($fz>$fp){
			$x = 20;
		} else{
			$x = 21;
		}
	}
	$budgets[$i] += $sps[$x]*1000000;
	if ($euros[$i]=='lch'){
		$sql = "SELECT num FROM lch WHERE team = '$teams[$i]'";
		$result = mysql_query($sql, $db);
		$mlch = 0;
		while ($row = mysql_fetch_assoc($result)){
			foreach ($row as $col=>$val){
				$mlch = $val;
			}
		}
		if ($mlch==4){
			$x = 30;
		}
		if ($mlch==3){
			$sql = "SELECT stad FROM lepo WHERE team = '$teams[$i]' ORDER BY lepo.stad DESC";
			$result = mysql_query($sql, $db);
			$sle = 0;
			while ($row = mysql_fetch_assoc($result)){
				foreach ($row as $col=>$val){
					$sle = $val;
				}
			}
			if ($sle == 4){
				$x = 34;
			}
			if ($sle == 2){
				$x = 33;
			}
			if ($sle == 1){
				$sql = "SELECT finalzb,finalpr FROM lepo WHERE stad = 1 AND tName = '$teams[$i]'";
				$result = mysql_query($sql, $db);
				$fz = 0;
				$fp = 0;
				while ($row = mysql_fetch_assoc($result)){
					foreach ($row as $col=>$val){
						if ($col == 'finalzb'){
							$fz = $val;
						}
						if ($col == 'finalpr'){
							$fp = $val;
						}
					}
				}
				if ($fz>$fp){
					$x = 31;
				} else{
					$x = 32;
				}
			}
		}
		if ($mlch == 2 || $mlch == 1){
			$sql = "SELECT stad FROM lchpo WHERE team = '$teams[$i]' ORDER BY lchpo.stad DESC";
			$result = mysql_query($sql, $db);
			$slch = 0;
			while ($row = mysql_fetch_assoc($result)){
				foreach ($row as $col=>$val){
					$slch = $val;
				}
			}
			if ($slch == 4){
				$x = 29;
			}
			if ($slch == 2){
				$x = 28;
			}
			if ($slch == 1){
				$sql = "SELECT finalzb,finalpr FROM lchpo WHERE stad = 1 AND tName = '$teams[$i]'";
				$result = mysql_query($sql, $db);
				$fz = 0;
				$fp = 0;
				while ($row = mysql_fetch_assoc($result)){
					foreach ($row as $col=>$val){
						if ($col == 'finalzb'){
							$fz = $val;
						}
						if ($col == 'finalpr'){
							$fp = $val;
						}
					}
				}
				if ($fz>$fp){
					$x = 26;
				} else{
					$x = 27;
				}
			}
		}
		$budgets[$i] += $sps[$x]*1000000;
	}
	if ($euros[$i]=='le'){
		$sql = "SELECT num FROM le WHERE team = '$teams[$i]'";
		$result = mysql_query($sql, $db);
		$mle = 0;
		while ($row = mysql_fetch_assoc($result)){
			foreach ($row as $col=>$val){
				$mle = $val;
			}
		}
		if ($mle == 4){
			$x = 37;
		}
		if ($mle == 3){
			$x = 36;
		}
		if ($mle == 2){
			$x = 35;
		}
		if ($mle == 1){
			$sql = "SELECT stad FROM lepo WHERE team = '$teams[$i]' ORDER BY lepo.stad DESC";
			$result = mysql_query($sql, $db);
			$stle = 0;
			while ($row = mysql_fetch_assoc($result)){
				foreach ($row as $col=>$val){
					$stle = $val;
				}
			}
			if ($stle == 4){
				$x = 34;
			}
			if ($stle == 2){
				$x = 33;
			}
			if ($stle == 1){
				$sql = "SELECT finalzb,finalpr FROM lepo WHERE stad = 1 AND tName = '$teams[$i]'";
				$result = mysql_query($sql, $db);
				$fz = 0;
				$fp = 0;
				while ($row = mysql_fetch_assoc($result)){
					foreach ($row as $col=>$val){
						if ($col == 'finalzb'){
							$fz = $val;
						}
						if ($col == 'finalpr'){
							$fp = $val;
						}
					}
				}
				if ($fz>$fp){
					$x = 31;
				} else{
					$x = 32;
				}
			}
		}
		$budget += $sps[$x];
	}
	if ($scupls[$i]){
		$sql = "SELECT zm,pm FROM scups WHERE team = '$teams[$i]' AND cup = 'scupl'";
		$result = mysql_query($sql, $db);
		$zm = 0;
		$pm = 0;
		while ($row = mysql_fetch_assoc($result)){
			foreach ($row as $col=>$val){
				if ($col == 'zm'){
					$zm = $val;
				}
				if ($col == 'pm'){
					$pm = $val;
				}
			}		
		}
		if ($zm>$pm){
			$budget += $sps[84];
		}
	}
	if ($scupes[$i]){
		$sql = "SELECT zm,pm FROM scups WHERE team = '$teams[$i]' AND cup = 'scupe'";
		$result = mysql_query($sql, $db);
		$zm = 0;
		$pm = 0;
		while ($row = mysql_fetch_assoc($result)){
			foreach ($row as $col=>$val){
				if ($col == 'zm'){
					$zm = $val;
				}
				if ($col == 'pm'){
					$pm = $val;
				}
			}		
		}
		if ($zm>$pm){
			$budget += $sps[83];
		}
	}
	if ($gcups[$i]){
		$sql = "SELECT zm,pm FROM scups WHERE team = '$teams[$i]' AND cup = 'gcup'";
		$result = mysql_query($sql, $db);
		$zm = 0;
		$pm = 0;
		while ($row = mysql_fetch_assoc($result)){
			foreach ($row as $col=>$val){
				if ($col == 'zm'){
					$zm = $val;
				}
				if ($col == 'pm'){
					$pm = $val;
				}
			}		
		}
		if ($zm>$pm){
			$budget += $sps[85];
		}
	}
	$sql = "SELECT leagueaPlace, leaguebPlace, cupPlace, lchPlace, lePlace FROM players WHERE team = '$teams[$i]'";
	$result = mysql_query($sql, $db);
	$lap = array();
	$lbp = array();
	$cp = array();
	$lchp = array();
	$lep = array();
	$j1 = 1;
	$j2 = 1;
	$j3 = 1;
	$j4 = 1;
	$j5 = 1;
	while ($row = mysql_fetch_assoc($result)){
		foreach ($row as $col=>$val){
			if ($col == 'leagueaPlace'){
				$lap[$j1] = $val;
				$j1++;
			}
			if ($col == 'leaguebPlace'){
				$lbp[$j2] = $val;
				$j2++;
			}
			if ($col == 'cupPlace'){
				$cp[$j3] = $val;
				$j3++;
			}
			if ($col == 'lchPlace'){
				$lchp[$j4] = $val;
				$j4++;
			}
			if ($col == 'lePlace'){
				$lep[$j5] = $val;
				$j5++;
			}
		}
	}
	for ($j = 1; $j < $j1; $j++){
		if ($lap[$j]>0&&$lap[$j]<16){
			$budgets[$i] += $sps[$lap[$j]+37]*1000000;
		}
		if ($lbp[$j]>0&&$lbp[$j]<16){
			$budgets[$i] += $sps[$lbp[$j]+37]*1000000;
		}
		if ($cp[$j]>0&&$cp[$j]<11){
			$budgets[$i] += $sps[$cp[$j]+52]*1000000;
		}
		if ($lchp[$j]>0&&$lchp[$j]<11){
			$budgets[$i] += $sps[$lchp[$j]+62]*1000000;
		}
		if ($lep[$j]>0&&$lep[$j]<11){
			$budgets[$i] += $sps[$lep[$j]+72]*1000000;
		}
	}	
	$budgets[$i] = $budgets[$i] - $kZarps[$i] + $dolgs[$i];
	$sql = <<<HERE
	UPDATE teams
	SET
		budget = $budgets[$i],
		dolg = 0
	WHERE
		tName = '$teams[$i]'
HERE;
	mysql_query($sql);
}
	$sql = "UPDATE config SET season=season+1 WHERE 1";
	mysql_query($sql,$db);
?>