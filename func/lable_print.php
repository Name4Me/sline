<!-- lable_print.php -->
<?php
	define('INCLUDE_CHECK',true);

	require 'config.php';
	include 'connect.php';

	$dbh->prepare("SET CHARACTER SET utf8")->execute();

        $nazva = '';
        $tip = '';
        $rozmir = '';
        $rist = '';
        $id = '';
	//defined( '_VALID_' ) or die( 'Restricted access' );
	//if (isset($_POST['task'])) {
		if (isset($_GET['p1'])) $nazva = addslashes($_GET['p1']); // key
    	if (isset($_GET['p2'])) $tip = addslashes($_GET['p2']); // id
    	if (isset($_GET['p3'])) $rozmir = (int)$_GET['p3']; // id
    	if (isset($_GET['p4'])) $rist = (int)$_GET['p4']; // id
    	if (isset($_GET['p5'])) $kilkist = (int)$_GET['p5'];
    	if (isset($_GET['p6'])) $id = addslashes($_GET['p6']);
    	//$rr = $rozmir.'/'.$rist;

        if ($rist != '') {        	$rr = $rozmir.'/'.$rist;        	} else {        		$rr = $rozmir;        		};
       	$id = $id.$rozmir.$rist;
    	$nazva = iconv("UTF-8", "Windows-1251",  $nazva);
    	$tip = iconv("UTF-8", "Windows-1251",  $tip);
		//$nazva = 'Костюм';
		//$tip = 'Арістократ';
		//$rr = '50/4';

		$SqlStr = 'select getcina('.$dbh->quote('').','.$dbh->quote($id).','.$dbh->quote('r').') as cina';  // limit 10;
        $result = $dbh->query($SqlStr);
		$row = $result->fetch(PDO::FETCH_ASSOC);
		$price = $row['cina'];
       	//$id = '04128503';

		$TSCObj = new COM ("TSCActiveX.TSCLIB");
		$TSCObj->ActiveXopenport ("TTP-245");
		//$TSCObj->ActiveXdownloadpcx("G:\Program Files\Apache Software Foundation\Apache2.2\htdocs\UL.PCX","UL.PCX");
		//$TSCObj->ActiveXsetup("101.6", "63.5", "5", "8", "0", "0", "0");
		$TSCObj->ActiveXclearbuffer();
		//$TSCObj->ActiveXsendcommand("PUTPCX 10,200,\"UL.PCX\"");
		$TSCObj->ActiveXwindowsfont(260, 35, 22, 0, 2, 0, "courier new", $nazva);
		$TSCObj->ActiveXwindowsfont(50, 65, 35, 0, 2, 0, "courier new", $tip);
		//$TSCObj->ActiveXwindowsfont(50, 200, 35, 0, 2, 0, "courier new", $id);
		$TSCObj->ActiveXbarcode("50", "200", "CODA", "40", "0", "0", "2", "4", "A".$id."B");
		$TSCObj->ActiveXwindowsfont(150, 110, 60, 0, 2, 0, "courier new", $rr);
		$TSCObj->ActiveXwindowsfont(270, 200, 40, 0, 2, 0, "courier new", $price.'грн.');

		$TSCObj->ActiveXprintlabel("1",$kilkist);
		$TSCObj->ActiveXcloseport();
	//};
?>




