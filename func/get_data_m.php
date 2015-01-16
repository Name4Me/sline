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
   	$SqlStr = 'SELECT Misce,ID FROM misce ORDER BY misce';  // limit 10;


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

include 'php2json.php';

