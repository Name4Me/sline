<?php // search.php
	define('INCLUDE_CHECK',true);
	session_start();
// Используйте $HTTP_SESSION_VARS с PHP 4.0.6 или ранее
if (!isset($_SESSION['count'])) {
    $_SESSION['count'] = 0;
} else {
    $_SESSION['count']++;
}
	require 'config.php';
	include 'connect.php';
	$dbh->prepare("SET CHARACTER SET utf8")->execute();
	$SqlStr = 'SELECT MAX(DATA) AS data FROM sklad';
	$result = $dbh->query($SqlStr);
	$row 	= $result->fetch(PDO::FETCH_NUM);
	$ldata = $row[0];
?>
    <head><title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />



	<link rel="stylesheet" type="text/css" href="../jQWidgets/jqwidgets/styles/jqx.base.css" />
    <link rel="stylesheet" type="text/css" href="../jQWidgets/jqwidgets/styles/jqx.summer.css" />
	<link rel="stylesheet" type="text/css" href="../css/ui.jqgrid.css" />
	<link rel="stylesheet" type="text/css" href="../css/ui-darkness/jquery-ui-1.8.20.custom.css" />

	<script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery.jqGrid.min.js"></script>
    <script type="text/javascript" src="../js/i18n/grid.locale-ru.js"></script>

	<!--




     <!-- add the jQWidgets framework -->
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxsplitter.js"></script>
    <!-- add one or more widgets -->
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxcheckbox.js"></script>
    <!-- add one of the jQWidgets styles -->
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxnumberinput.js"></script>



    <script type="text/javascript" src="../js/u_tovar.js"></script>
    <script type="text/javascript" src="../js/search.js"></script>
    </head>
    <body>
<?php
    echo "Update: ".$ldata;
?>
    <div id="splitter1">
            <div class="splitter-panel" id="panel1">
               <input type="button" value="Всі місця" id = 'Button1' />
               <div id = "ListBox1"></div>
            </div>
            <div class="splitter-panel">
            	<table CELLPADDING = 0 border = 0 bordercolor = red>
            		<tr VALIGN="top">
            			<td>
            				<input type="text" value="" id="search_s" SIZE="30" />
            				<table id="list"></table>
							<div id="pager" ></div>
				    	</td>
				    	<td>
				    		<div id = "ListBox2"></div>
				    	</td>
					</tr>
				</table>
			</div>
    </div>

		<div id='log' />
    </body>
</html>



