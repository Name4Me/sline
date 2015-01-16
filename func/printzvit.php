<?php
	//printzvit.php last update 16.05.2014 13:20
	define('INCLUDE_CHECK',true);
	session_name('tzLogin');
	session_start();

	if (!isset($_SESSION['usr'])) {
    	Return 0;
	}

	require 'config.php';
	include 'connect.php'
?>
<html>

<head>
  	<title>Відомість</title>

  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />

	<style type="text/css">
		body {
			margin: 0;
		}
		table{			border-spacing: 0;
			border-right-color: white;
			border-left-color: white;
		}
		td{ border-spacing: 0;
			padding: 0px;
			width: 1.9in;		}
		TR {			vertical-align: top;
			height: 958px;
		}
		.hdd {			vertical-align: top;
			height: 15px;

		}

		p, p1, p2, h1, h2, h3 {
		    font-family: Courier New;			line-height: 1em;
			word-spacing: -0.25em;
		}
		p {
			font-size:12;
			-webkit-margin-before: 0;
			-webkit-margin-after: 0;
		}
		p1 {
			font-size:12;
			-webkit-margin-before: 0;
			-webkit-margin-after: 0;
			-webkit-margin-start: 3.5em;
		}
		p2 {
			font-size:12;
			-webkit-margin-start: 11em;
		}
		h1 {
			font-size:16;
			-webkit-margin-before: 0;
			margin-bottom: 0px;
		}
		h2 {
			border-bottom:1px solid black;
			font-size:12;
			-webkit-margin-before: 0;
			-webkit-margin-after: 0;
		}
		h3 {
			font-size:10;
			-webkit-margin-before: 0;
			-webkit-margin-after: 0;
			font-weight: bold;
		}
	</style>
</head>

<body>
	<Table CELLPADDING="1" border = 2 bordercolor = red id="tbl1">
<?php
	// white red
	$pg = 1;
	$ttl = '<TR class="hdd"><TD colspan=3><H1>['.$_SESSION['misce'].']'.date('Y-m-d [H:i:s]').'</H1></TD><TD align = right>'.$pg.'</TD></TR><TR><TD>';
    echo $ttl;

	$dbh->prepare("SET CHARACTER SET utf8")->execute();
    $tk = 0;
	$i=0;
	$c=1;
	$l=3;
	$Nazva='';
	$result = $dbh->query('select distinct Nazva from '.$mysql['sklad'].' where misce ="'.$_SESSION['misce'].'" order by Nazva');
	while($row = $result->fetch(PDO::FETCH_ASSOC)) $Nazva[$i++]=$row;
	foreach ($Nazva AS $value) {
		$k = myget1('SELECT sum(kilkist) from '.$mysql['sklad'].' where misce = \''.$_SESSION['misce'].'\' and Nazva = \''.$value['Nazva'].'\'');
		echo '<h2>'.$value['Nazva'].' '.$k.' шт.</h2>';
		$l++;
		//$tk++;
		chek();
		$i=0;
		$Tip='';
		$result = $dbh->query('select distinct Tip from '.$mysql['sklad'].' where misce =\''.$_SESSION['misce'].'\' and Nazva = \''.$value['Nazva'].'\' order by Tip');
		while($row = $result->fetch(PDO::FETCH_ASSOC)) $Tip[$i++]=$row;
		foreach ($Tip AS $value1) {			$k = myget1('SELECT sum(kilkist) from '.$mysql['sklad'].' where misce = \''.$_SESSION['misce'].'\' and Nazva = \''.$value['Nazva'].'\' and Tip = \''.$value1['Tip'].'\'');
			$result = $dbh->query('select Rozmir,Rist,Kilkist,Cina from '.$mysql['sklad'].' where misce =\''.$_SESSION['misce'].'\' and Nazva = \''.$value['Nazva'].'\' and Tip = \''.$value1['Tip'].'\' order by Rozmir,Rist');
			$i=0;
            $cina='';
            $n = $result->rowCount();
			while($row = $result->fetch(PDO::FETCH_ASSOC)){
				$len = 0;
				if ($i==0) {
					$cina=$row['Cina'];
					$s = $value1['Tip'].' ('.$cina.')';
					if (($row['Rozmir'] == '') and ($row['Rist'] == '')) $s = $s.'/'.$k;
					echo '<h3>'.$s.'</h3>';//.' шт.('.
					$tk++;

					$l++;
					chek();

				}
				$s = '';
				if ($row['Rozmir'] != '') $s = $row['Rozmir'];
				if ($row['Rist'] != '') $s = $s.'/'.$row['Rist'];
				if ($s !='') $s =$s.' - '.$row['Kilkist'];
				if ($cina != $row['Cina']) $s = $s.' ('.$row['Cina'].')';
				if ($s !='') {					if ($n==($i+1)) echo '<p><p1>'.$s.'</p1>/'.$k.'</p>';
					if ($n!=($i+1)) echo '<p><p1>'.$s.'</p1></p>';
                    $l++;
					chek();
                }
				$i++;

			}


		}
	}

    function chek() {
    global $l, $c, $pg, $tk;
    	if ($tk >=18) {
			$l++;
			$tk=0;
		}

    	if ($l>=82){					$c++;
					$l=1;
					if ($c!=5) {echo '</TD><TD>';}
					if ($c==5) {						$pg++;
						$c=1;
						$tk=0;
						echo '</TD>';
						$ttl = '<TR class="hdd"><TD colspan=3><H1>['.$_SESSION['misce'].']'.date('Y-m-d [H:i:s]').'</H1></TD><TD align = right>'.$pg.'</TD></TR><TR><TD>';
    					echo $ttl;					}		}
    }


	//while($row = $result->fetch(PDO::FETCH_ASSOC)){	//	echo '<p><p1>'.$row['Rozmir'].'/'.$row['Rist'].'</p1></p>';
	//}

?>
		</TD>
	</TR></Table>
</body>

</html>
<?php


 	function myget1($q) {
		require 'config.php';
		include 'connect.php';
		$dbh->prepare("SET CHARACTER SET utf8")->execute();
		$result = $dbh->query($q);
    	if (!$result->rowCount()) return -1;
    	$row = $result->fetch(PDO::FETCH_NUM);
    	return $row[0];
		}

?>