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
		table{
			border-spacing: 0;
			border-right-color: white;
			border-left-color: white;

		}
		td{ border-spacing: 0;
			padding: 0px;
			width: 1.9in;
		}
		TR {
			vertical-align: top;
			height: 958px;
		}
		.hdd {
			vertical-align: top;
			height: 15px;

		}

		p, p1, p2, h1, h2, h3 {
		    font-family: Courier New;
			line-height: 1em;
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
	<Table CELLPADDING="1" border = 2 bordercolor = red id="tbl1"><TR><TD>

<?php
	// white red

	$dbh->prepare("SET CHARACTER SET utf8")->execute();
    $tk = 0;
	$i=0;
	$c=1;
	$l=3;
	$Nazva='';
	$result = $dbh->query('select Tip, pr from types where GGiD =\'05\' order by Tip');
	while($row = $result->fetch(PDO::FETCH_ASSOC)) $Nazva[$i++]=$row;
	foreach ($Nazva AS $value) {

		echo '<h2>'.$value['Tip'].'</h2>';


	}


	//while($row = $result->fetch(PDO::FETCH_ASSOC)){
	//	echo '<p><p1>'.$row['Rozmir'].'/'.$row['Rist'].'</p1></p>';
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