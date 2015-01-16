<?php	// connect.php
	if(!defined('INCLUDE_CHECK')) die('У вас не прав запускать файл на выполнение');

	$dbh = new PDO('mysql:host='.$mysql['host'].';dbname='.$mysql['database'], $mysql['login'], $mysql['password']);
    //указываем, мы хотим использовать utf8
    //$dbh->exec('SET CHARACTER SET utf8');
?>