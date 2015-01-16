<meta http-equiv="content-type" content="text/html; charset=utf8" />
<?php

	define('INCLUDE_CHECK',true);

	require 'config.php';
	include 'connect.php';
try {

    $id = '';
    $dbh->prepare("SET CHARACTER SET utf8")->execute();
    if (isset($_GET['key'])) $key = (int)$_GET['key']; // key
    if (isset($_GET['p1'])) $p1 = addslashes($_GET['p1']); // id
    if (isset($_GET['p2'])) $p2 = addslashes($_GET['p2']); // id
   	$SqlStr = 'SELECT ID as f1 FROM prules ORDER BY id';  // limit 10;


    if ($SqlStr !='') {
	    $result = $dbh->query($SqlStr);
        $data='';

	    $i = 0;
	 	while($row = $result->fetch(PDO::FETCH_ASSOC)) {	    $data[$i++]=$row;	    }
    //if($data = $result->fetch(PDO::FETCH_ASSOC))
    	echo  (php2json($data));
    	} else {    		echo '[]';    	};

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

?>