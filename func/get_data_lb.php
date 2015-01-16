<?php
    //if (!isset($_POST['myID'])) die('У вас не прав запускать файл на выполнение');
    //if (!isset($_POST['page'])) die('У вас не прав запускать файл на выполнение');

	define('INCLUDE_CHECK',true);
   	session_name('tzLogin');
	session_start();
	require 'config.php';
	include 'connect.php';
	//echo $_POST['myID'];


try {

    $id = '';
    $response = '';
    $SqlStr = '';
    $dbh->prepare("SET CHARACTER SET utf8")->execute();
    if (isset($_GET['key'])) $key = (int)$_GET['key']; // key
    if (isset($_POST['key'])) $key = (int)$_POST['key'];
    if (isset($_GET['p1'])) $p1 = $id = addslashes($_GET['p1']); // id
    if (isset($_POST['p1'])) $p1 = $id = addslashes($_POST['p1']); // id
    if (isset($_GET['p2'])) $p2 = $ft = addslashes($_GET['p2']); // ft
    if (isset($_POST['p2'])) $p2 = $ft = addslashes($_POST['p2']); // ft
    if (isset($_GET['p3'])) $p3 =  addslashes($_GET['p3']);
    if (isset($_POST['p3'])) $p3 =  addslashes($_POST['p3']);
    if (isset($_GET['p4'])) $p4 =  addslashes($_GET['p4']);
    if (isset($_GET['p5'])) $p5 =  addslashes($_GET['p5']);
    if (isset($_GET['p6'])) $p6 =  addslashes($_GET['p6']);
    if (isset($_GET['p7'])) $p7 =  addslashes($_GET['p7']);
    if (isset($_GET['p8'])) $p8 =  addslashes($_GET['p8']);
    if (isset($_GET['p9'])) $p9 =  addslashes($_GET['p9']);
    if (isset($_GET['p10'])) $p10 =  addslashes($_GET['p10']);
    if (isset($_GET['p11'])) $p11 =  addslashes($_GET['p11']);
    if (isset($_GET['p12'])) $p12 =  addslashes($_GET['p12']);
    if (isset($_GET['p13'])) $p13 =  addslashes($_GET['p13']);

   	switch ($key):
	   case 1: $SqlStr = 'SELECT distinct left(Tip,1) as f1 FROM types where ggid = '.$dbh->quote($id).'ORDER BY f1';  // limit 10;
	   break;
	   case 2: $SqlStr = 'SELECT Tip as f1,id FROM types where ggid = '.$dbh->quote($id).' ORDER BY f1';  // limit 10;
	   break;
	   case 3: $SqlStr = 'SELECT Tip as f1,id FROM types where ggid = '.$dbh->quote($id).' and tip like '.$dbh->quote($ft.'%%').' ORDER BY f1';  // limit 10;
	   break;
	   case 4: $SqlStr = 'SELECT rid FROM gg where id = '.$id;  // limit 10;
			$result = $dbh->query($SqlStr);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$rid=$row['rid'];
			if ($rid!='0') $SqlStr = 'SELECT rozmir as f1 FROM rozmir where rid = '.$dbh->quote($rid).'order by f1'; else $SqlStr = '';
	   break;

	   case 5:  $SqlStr = 'SELECT rtid FROM gg where id = '.$id;  // limit 10;
			$result = $dbh->query($SqlStr);
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$rid=$row['rtid'];
			if ($rid=='1') $SqlStr = 'SELECT rozmir as f1 FROM rozmir where rid = 0 order by f1'; else $SqlStr = '';
	   break;
	   case 6: $SqlStr = 'SELECT distinct misce as f1 FROM '.$mysql['sklad'].' ORDER BY f1';  // limit 10;
	   break;
	   case 7: $SqlStr = 'SELECT distinct Tip as f1 FROM '.$mysql['sklad'].' where id like '.$dbh->quote($id.'%%').' ORDER BY f1';  // limit 10;
	   break;
	   case 9: $SqlStr = 'SELECT * FROM rozmir ORDER BY rid,rozmir';  // limit 10;
	   break;
	   case 10: $SqlStr = 'SELECT pr as f1,id FROM types where ggid = '.$dbh->quote($id).' and id = '.$dbh->quote($ft);  // limit 10;
	   break;
	   case 11: $SqlStr = 'SELECT Rozmir,Rozmir1,Cina,BCina,BCina1,OCina,BOCina,BOCina1,ZCina,BZCina,BZCina1,ID FROM prules where id = '.$dbh->quote($id);  // limit 10;
	   break;
	   case 12: $SqlStr = 'SELECT GGID,Tip FROM types WHERE PR='.$dbh->quote($id).' order by GGID,Tip';  // limit 10;
	   break;
	   case 13: //Reprice add new prule
	   	$ts = $SqlStr = 'SELECT ID,0 as f1 FROM prules where Rozmir='.$p1.' and Rozmir1='.$p2.
	   		' and Cina='.$p3.' and BCina='.$p4.' and BCina1='.$p5.' and OCina='.$p6.
	   		' and BOCina='.$p7.' and BOCina1='.$p8.' and ZCina='.$p9.' and BZCina='.$p10.' and BZCina1='.$p11;
	   	//save2log($SqlStr);
	   	$result = $dbh->query($SqlStr);
	   	if ($result->rowCount()) {	   		$row = $result->fetch(PDO::FETCH_ASSOC);
	   		echo  (php2json($row));
	   		$SqlStr = '';
	   		return 0;
	   		}

	   	if (!$result->rowCount()) {        	$newid = myget1('select getNewPrID()');
        	$SqlStr = 'INSERT INTO prules (Rozmir,Rozmir1,Cina,BCina,BCina1,OCina,BOCina,BOCina1,ZCina,BZCina,BZCina1,ID) VALUES ('
        		.$p1.','.$p2.','.$p3.','.$p4.','.$p5.','.$p6.','.$p7.','.$p8.','.$p9.','.$p10.','.$p11.','.$newid.')';
        	//save2log($SqlStr);
        	$dbh->prepare($SqlStr)->execute();
            echo '{"ID":"'.$newid.'","f1":"1"}';
            $SqlStr = '';
            return 0;
	   	}

	   break;
	   case 14: //Reprice change prule
		   	$SqlStr = 'update prules set Rozmir='.$p1.' , Rozmir1='.$p2.
		   		' , Cina='.$p3.' , BCina='.$p4.' , BCina1='.$p5.' , OCina='.$p6.
		   		' , BOCina='.$p7.' , BOCina1='.$p8.' , ZCina='.$p9.' , BZCina='.$p10.' , BZCina1='.$p11.' where ID='.$p12;
		    $dbh->prepare($SqlStr)->execute();
		    reprice($dbh->quote($p12));
		    $SqlStr = 'SELECT Rozmir,Rozmir1,Cina,BCina,BCina1,OCina,BOCina,BOCina1,ZCina,BZCina,BZCina1,ID FROM prules where id = '.$dbh->quote($p12);
	   break;

	   case 15: //Reprice change PrID
		   	$SqlStr = 'update types set PR='.$p3.' where GGID='.$p1.' and ID ='.$p2;
		   	//save2log($SqlStr);
		    $dbh->prepare($SqlStr)->execute();
		    $SqlStr = 'UPDATE склад SET cina=getcina(Misce,ID,\'\') WHERE id like \''.$p1.$p2.'%\'';
		    //save2log($SqlStr);
	     	$dbh->prepare($SqlStr)->execute();
		    $SqlStr = '';
	   break;

	   case 16: //Vidacha
		   	//vidacha(imisce, iid, ik, iip, us, indata, fl))
		   	$dbh->prepare("SET CHARACTER SET cp1251")->execute();
		   	$SqlStr = 'Call Vidacha(\''.$_SESSION['misce'].'\',\''.$p1.'\','.$p2.',\''.$p3.'\',\''.$_SESSION['usr'].'\',now(),1)';  // limit 10;
		   	//save2log($SqlStr);
		   	$dbh->prepare($SqlStr)->execute();
		   	$SqlStr = 'SELECT ROW_COUNT()';
		   	$result = $dbh->query($SqlStr);
		   	$row = $result->fetch(PDO::FETCH_NUM);
		   	echo '['.$row[0].']';
	    	//if ( != -1) echo '[+]'; else
	        $SqlStr = '';
		   	Return 0;
	   break;

	   case 17: //Reprice delete nonuse rules
	   		$SqlStr = 'DELETE FROM prules WHERE (SELECT COUNT(*) FROM types t WHERE t.PR = prules.ID) = 0';
	    	$dbh->prepare($SqlStr)->execute();
    		$data = $dbh->errorInfo();
    		echo '[+]';//$response = $data[0].'/'.$data[1].'/'.$data[2];
    		//
    		$SqlStr = '';
		   	Return 0;
	   break;

	   case 18:
	   		$SqlStr = 'SELECT Nazva,Tip,Rozmir,Rist,Kilkist,ID,Cod FROM oper WHERE misce = \''.$p1.'\' and oper = \'Видача\' and data=NOW() and ip='.$p2.' order by Nazva,Tip,Rozmir,Rist';  // limit 10;
	   		//save2log($SqlStr);
	   		//Return 0;
	   break;

	   case 19:
            $SqlStr = 'SELECT GROUP_CONCAT(r.PR) FROM (SELECT  distinct t.PR, 0 as c FROM types t WHERE t.GGID=\''.$p1.'\') AS r GROUP BY r.c';
            $result = $dbh->query($SqlStr);
            $row = $result->fetch(PDO::FETCH_NUM);
            $pr = $row[0];

            $SqlStr = 'SELECT Rozmir,Rozmir1,Cina,BCina,BCina1,OCina,BOCina,BOCina1,ZCina,BZCina,BZCina1,ID,(SELECT COUNT(*) from types t1 WHERE t1.pr=p.id) AS Сnt FROM prules p where p.id in('.$pr.') order by ZCina, OCina, Cina';
            $result = $dbh->query($SqlStr);
            $i = 0;
	   		while($row = $result->fetch(PDO::FETCH_ASSOC)) {	    		$data[$i++]=$row;	    	}
	   break;

       case 20: //Reprice change prule
  	   		$SqlStr = 'SELECT distinct t.PR,  (SELECT COUNT(*) from types t1 WHERE t1.pr=t.PR) AS Сnt FROM types t WHERE t.GGID=\''.$p1.'\' ORDER BY t.PR, t.Tip';
	   		$result = $dbh->query($SqlStr);
	   		$i = 0;
	   		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	    		$data[$i++]=$row;
	    	}

            $i = 0;

            foreach ($data AS $value) {
            	$pid = $value['PR'];

            	$SqlStr = 'UPDATE prules p SET Cina = TRUNCATE(((OCina + GetMjn(\''.$p1.'\'))*GetKurs()),-1) WHERE ID = '.$pid.' and Cina < TRUNCATE(((OCina + GetMjn(\''.$p1.'\'))*GetKurs()),-1)';
                //save2log($SqlStr);
                $dbh->prepare($SqlStr)->execute();
	    		reprice($pid);
	    		//save2log($pid);
            	//if ($i != 0)$r .= ';'.$SqlStr;
            	//if ($i == 0)$r .= $SqlStr;
             	$i++;
	    	}
	    	unset($value);
	    	//$r = '}';
            echo '[{"Result":"Ok"}]';
            Return 0;
	   break;

       case 21: //Reprice change prule
            	$SqlStr = 'UPDATE prules p SET Cina = TRUNCATE(((OCina + GetMjn(\''.$p1.'\'))*GetKurs()),-1) WHERE ID = '.$p2.' and Cina < TRUNCATE(((OCina + GetMjn(\''.$p1.'\'))*GetKurs()),-1)';
                //save2log($SqlStr);
                $dbh->prepare($SqlStr)->execute();
	    		reprice($p2);
	    		//save2log($p2);
            	//if ($i != 0)$r .= ';'.$SqlStr;
            	//if ($i == 0)$r .= $SqlStr;
            echo '[{"Result":"Ok"}]';
            Return 0;
	   break;


       default: ;
   endswitch;

    if ($SqlStr !='') {
	    $result = $dbh->query($SqlStr);
        $data='';

	    $i = 0;
	 	while($row = $result->fetch(PDO::FETCH_ASSOC)) {	    $data[$i++]=$row;	    }
    //if($data = $result->fetch(PDO::FETCH_ASSOC))
    	echo  (php2json($data));
    	} else {          if  ($response !='') {          	echo '[$response]';
          	} else {          		echo '[]';          	};    	};

}

catch (PDOException $e) {
	echo 'Database error: '.$e->getMessage();
}

// рекурсивная функция формирования json-последовательности.
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

    function save2log($s) {

    	$fp = fopen('log.txt', 'a');
	   	fwrite($fp, '['.date('Y-m-d H:i:s').'] '.$s."\r\n");
	   	fclose($fp);

	}

 	function myget1($q) {
		require 'config.php';
		include 'connect.php';
		$dbh->prepare("SET CHARACTER SET utf8")->execute();
		$result = $dbh->query($q);
    	if (!$result->rowCount()) return -1;
    	$row = $result->fetch(PDO::FETCH_NUM);
    	return $row[0];
		}

 	function reprice($prid) {
		require 'config.php';
		include 'connect.php';
	    $dbh->prepare("SET CHARACTER SET utf8")->execute();
        $SqlStr = 'SELECT GGID,Tip FROM types WHERE PR='.$prid;
    	$result = $dbh->query($SqlStr);
    	if (!$result->rowCount()) return 0;
    	$data = '';
    	$i = 0;

    	while($row = $result->fetch(PDO::FETCH_ASSOC)) {
	    	$data[$i++]=$row;
	    }

	    foreach ($data AS $value) {
            $SqlStr = 'UPDATE склад SET cina=getcina(Misce,ID,\'\') WHERE left(id,2)= \''.$value['GGID'].'\' and tip = \''.$value['Tip'].'\'';
            $dbh->prepare($SqlStr)->execute();
	    	}
	    unset($value);
	    }