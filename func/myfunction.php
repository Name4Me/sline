<?php	// myfunction.php
	if (!isset($_POST['task'])) die('У вас не прав запускать файл на выполнение');
   	define('INCLUDE_CHECK',true);
   	session_name('tzLogin');
	session_start();

	require 'config.php';

	try {
		$dbh = new PDO('mysql:host='.$mysql['host'].';dbname='.$mysql['database'], $mysql['login'], $mysql['password']);
        if (isset($_POST['task'])) $task = addslashes($_POST['task']);
        if (isset($_POST['misce'])) $misce = addslashes($_POST['misce']);

        //Call vidacha(@im,@iid,@ik,0,'','',0);

		switch ($task) {
	     		case 'az_sveta': //Шевченко-97, Света Чернівці
				$q = "delete from zoper";
				$dbh->prepare($q)->execute();

				$q = "Call AzSveta()";
				$dbh->prepare($q)->execute();
	           	break;

	       	case 'del_valik':
				$dbh->prepare("SET CHARACTER SET utf8")->execute();
				$q = 'delete from '.$mysql['sklad'].' where misce =\'Валік\'';
				$dbh->prepare($q)->execute();
	   			break;

	        case 'SaveSnapV':
				$q = "Call SaveSnap(1)";
				$dbh->prepare($q)->execute();
				break;

	        case 'SaveSnapL':
				$q = "Call SaveSnap(5)";
				$dbh->prepare($q)->execute();
				break;
			case 'SaveSnapD':
				$q = "Call SaveSnap(8)";
				$dbh->prepare($q)->execute();
				break;

	       	case 'del_x':
				$dbh->prepare("SET CHARACTER SET utf8")->execute();
				$q = 'delete from '.$mysql['sklad'].' where misce =\'x\'';
				$dbh->prepare($q)->execute();
				break;

			case 'clr_types':
				$q = 'truncate types';
				$dbh->prepare($q)->execute();
				break;
			case 'misce': $_SESSION['misce'] = $misce;
				break;

			case 'up_misce':
				$q = 'select Misce,ID from misce order by Misce';
    			$result = $dbh->query($q);
    			$data = '';
    			$i = 0;
    			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$data[$i++]=$row;
				}
				$fp = fopen('../data/misce.txt', 'w');
	   			fwrite($fp,iconv("CP1251", "UTF-8", php2json($data)));
	   			fclose($fp);
				break;
	   	};

		$dbh = null;
	}

	catch (PDOException $e) {		echo 'Database error: '.$e->getMessage();
	}


	function php2json($obj){
		if(count($obj) == 0) return '[]';
		$is_obj = isset($obj[count($obj) - 1]) ? false : true;
		$str = $is_obj ? '{' : '[';
		foreach ($obj AS $key  => $value) {
		   $str .= $is_obj ? "\"" . addcslashes($key, "\n\r\t'\\/") . "\"" . ':' : '';
		   if (is_array($value))   $str .= php2json($value);
		   elseif (is_null($value))    $str .= 'null';
		   elseif (is_bool($value))    $str .= $value ? 'true' : 'false';
		   elseif (is_numeric($value)) $str .= "\"" .$value. "\"";
		   else                        $str .= "\"" . addcslashes($value, "\n\r\t'\\/") . "\"";
		   $str .= ',';
		   }
		return substr_replace($str, $is_obj ? '}' : ']', -1);
	}
?>

