<?php
    //if (!isset($_POST['myID'])) die('У вас не прав запускать файл на выполнение');
    if (!isset($_POST['page'])) die('У вас не прав запускать файл на выполнение');

	define('INCLUDE_CHECK',true);

	require 'u_tovar.php';
	require 'config.php';
	include 'connect.php';
	//echo $_POST['myID'];


try {
    $_search = false; // Флаг поиска
	$rowsPerPage = 10; // Количество элементов на странице
	$curPage = 1; // Номер старинцы запроса
	$sortingField = 'id'; // Имя поля по которому будет вестись сортировка
	$sortingOrder = 'asc'; // Направление сортировки
	$filters = ''; // Фильтры для поиска
	$searchField = ''; // Фильтр по одному полю (имя)
	$searchString = ''; // Фильтр по одному полю (значение)
	$searchOper = ''; // Фильтр по одному полю (операция)
	$searchSql = ''; // Поисковой запрос
    $key = '';
    //читаем параметры
	if (isset($_POST['_search'])) $_search = (bool)$_POST['_search']; // Флаг поиска
	if (isset($_POST['rows'])) $rowsPerPage = (int)$_POST['rows']; // Количество элементов на странице
	if (isset($_POST['page'])) $curPage = (int)$_POST['page']; // Номер старинцы запроса
	if (isset($_POST['sidx'])) $sortingField = addslashes($_POST['sidx']); // Имя поля по которому будет вестись сортировка
	if (isset($_POST['sord'])) $sortingOrder = addslashes($_POST['sord']); // Направление сортировки
	if (isset($_POST['ss'])) $sortString = addslashes($_POST['ss']);
	if (isset($_POST['sm'])) $misce = addslashes($_POST['sm']);
	if (isset($_POST['p2'])) $p2 = (int)$_POST['p2'];
	//if (isset($_GET['key']))  $key = (int)$_GET['key'];
	//if (isset($_POST['userdata']))  $key = (int)$_POST['userdata'];

    $totalrows = isset($_POST['totalrows']) ? $_POST['totalrows']: false;
	if($totalrows) {
		$rowsPerPage = $totalrows;
	}



  //определяем команду (поиск или просто запрос на вывод данных)
  //если поиск, конструируем WHERE часть запроса


    $dbh->prepare("SET CHARACTER SET utf8")->execute();
   $qWhere = '';
   if ($sortString) {
       	$tovar = new WTovar($sortString);

       	$s = '';
       	if ($tovar->GID <> '') $s = aa($s).'id like '.$dbh->quote($tovar->GID.'%%');

        if ($tovar->Tip<>'') {        	if ($p2 == 1) $s = aa($s).'tip = '.$dbh->quote($tovar->Tip);
        	if ($p2 == 0) $s = aa($s).'tip like '.$dbh->quote($tovar->Tip.'%%');
        	}
        //if (($tovar->Tip<>'') && ($tovar->fl)) $s = aa($s).'tip = '.$dbh->quote($tovar->Tip);
        if ($tovar->Rozmir<>'') $s = aa($s).'rozmir like '.$dbh->quote($tovar->Rozmir.'%%');
        if ($tovar->Rist<>'') $s = aa($s).'rist = '.$tovar->Rist;

     	$qWhere = $s;
    };   	if ($misce) $qWhere = aa($qWhere).'misce = '.$dbh->quote($misce);
   	if ($qWhere) $qWhere =' WHERE '.$qWhere;

     //определяем количество записей в таблице
    $result = $dbh->query('SELECT COUNT(*) AS count FROM '.$mysql['sklad'].$qWhere);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $count = $row['count'];



   	if( $count >0 ) {
		$total_pages = ceil($count/$rowsPerPage);
	}
		else {
			$total_pages = 0;
		}

    //if ($curPage > $total_pages) $curPage=$total_pages;
    if ($curPage > $total_pages) return 0;
	if ($rowsPerPage<0) $rowsPerPage = 0;

    $firstRowIndex = $rowsPerPage*$curPage - $rowsPerPage; // do not put $limit*($page - 1)
	if ($firstRowIndex<0) $firstRowIndex = 0;

    //сохраняем номер текущей страницы, общее количество страниц и общее количество записей
    $response->page = $curPage;
    $response->total = $total_pages;
    $response->records = $count;





    $i=0;
    $SqlStr = 'SELECT misce,nazva,tip,rozmir,rist,kilkist,cina,id FROM '.$mysql['sklad'].' '.$qWhere.' ORDER BY '.$sortingField.' '.$sortingOrder.' LIMIT '.$firstRowIndex.', '.$rowsPerPage;
    //echo '>'.$SqlStr;
    $result = $dbh->query($SqlStr);

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $response->rows[$i]['id']=$row['id'];
        $response->rows[$i]['cell']=array($row['misce'], $row['nazva'], $row['tip'], $row['rozmir'],$row['rist'],$row['kilkist'],$row['cina'],$row['id']);
        //echo $row['surname'];
        $i++;
    }

    echo json_encode($response);
    //print_r ($response);
}

catch (PDOException $e) {
	echo 'Database error: '.$e->getMessage();
}

  	function aa($inStr) {		//       And add to string
    	if ($inStr <> '') $inStr .=' and ';
    	return $inStr;
	}
//?>

