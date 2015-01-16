<?php	// ssave.php
if ((!isset($_POST['task'])) || (!$_POST['task'] == 'ssave')) die('У вас не прав запускать файл на выполнение');

	define('INCLUDE_CHECK',true);
	//require 'icheck.php';
	require 'config.php';
    unlink($savepach."gg.sav");
	unlink($savepach."sklad.sav");
	unlink($savepach."types.sav");
    unlink($savepach."prules.sav");
	try {
		$dbh = new PDO('mysql:host='.$mysql['host'].';dbname='.$mysql['database'], $mysql['login'], $mysql['password']);
		$dbh->prepare("SET CHARACTER SET utf8")->execute();
		$dbh->prepare("call ssave()")->execute();
		$dbh = null;
	}

	catch (PDOException $e) {
		echo 'Database error: '.$e->getMessage();
	}

	$zip = new ZipArchive;
	$fn = strftime("SS%d%m%y%H%M",time()).'.dat';
	$res = $zip->open($savepach.$fn, ZipArchive::CREATE);

	if ($res === TRUE) {
	    //$zip->addFile($savepach.'gg.sav','gg.sav');
	    $zip->addFile($savepach.'sklad.sav','sklad.sav');
	    $zip->addFile($savepach.'types.sav','types.sav');
	    $zip->addFile($savepach.'prules.sav','prules.sav');
	    $zip->close();
	    }
	rename($savepach.$fn, "e:/My Dropbox/DBS97/".$fn);
    unlink($savepach."gg.sav");
	unlink($savepach."sklad.sav");
   	unlink($savepach."types.sav");
   	unlink($savepach."prules.sav");

?>
