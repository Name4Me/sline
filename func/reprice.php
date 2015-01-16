<?php
	//reprice.php last update 16.05.2014 13:20
	define('INCLUDE_CHECK',true);
	require 'ucheck.php';
?>
<html>
<head>
    <title>Переоцінка</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />

    <!-- add the jQuery script -->
    <script type="text/javascript" src="../js/jquery-1.11.1.min.js"></script>


    <!-- add the jQWidgets framework -->
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxscrollbar.js"></script>
    <!-- add one or more widgets -->
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxcombobox.js"></script>
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="../jQWidgets/jqwidgets/jqxinput.js"></script>
    <script type="text/javascript" src="../jQwidgets/jqwidgets/jqxcheckbox.js"></script>

    <!-- add one of the jQWidgets styles -->
    <link rel="stylesheet" href="../jQWidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="../jQWidgets/jqwidgets/styles/jqx.summer.css" type="text/css" />
    <script type="text/javascript" src="../js/reprice.js"></script>
    <style type="text/css">
	button {padding: 0;}
	.myi{		padding-right:5;
		text-align:right;
	}
	.color_table th, #first_tr {background-color: lightblue;}
</style>


</head>
<?php

	require 'config.php';
	include 'connect.php'
?>

<body>
	<div id='content'>

    <Table CELLPADDING="0" border = 1 bordercolor = white id="tbl1">
    	<TR VALIGN="top">
	    	<TD rowspan = 14><div id='ListBox1'></div></TD>
		    <TD rowspan = 14><div id='ListBox2'></div></TD>
		    <TD rowspan = 14><div id='ListBox3'></div></TD>
	    </TR>


<?php
	$dbh->prepare("SET CHARACTER SET utf8")->execute();
	$result = $dbh->query('SHOW COLUMNS FROM prules');
	$i=1;
	while($col = $result->fetch(PDO::FETCH_ASSOC)){

    print('<TR VALIGN="top"><TD width = "70" height = "20">'.$col['Field'].
    '</TD><TD height = "20"><input id = \'input'.$i.
    '\' size = \'3\' class = myi /></TD>');
    if ($i==1)print('<TD width = "120" height = "20"><input type = "button" value = "Додати" id="Button1" /></TD><TD></TD>');
    if ($i==1)print('<TD width = "120" height = "20"><input type = "button" value = "Змінити" id="Button2" /></TD><TD><input type = "button" value = "АвтоП" id="Button5" /></TD>');
    if ($i==2)print('<TD width = "120" height = "20"><input type = "button" value = "Змінити ID" id="Button3" /></TD>');
    if ($i==2)print('<TD width = "120" height = "20"><input type = "button" value = "DNUR" id="Button4" /></TD>');
    if ($i==2)print('<TD width = "120" VALIGN="bottom"><div id=\'Сheckbox1\'>Show</div></TD><TD><input type = "button" value = "Авто ПП" id="Button6" /></TD>');
    if ($i==3)print('<TD width = "120" height = "20" colspan = "3"><input type = "button" value = "5" id="Button_t1" />');
    if ($i==3)print('&nbsp;&nbsp;<input type = "button" value = "43" id="Button_t2" />');
    if ($i==3)print('&nbsp;&nbsp;<input type = "button" value = "_" id="Button_t3" />');
    if ($i==3)print('&nbsp;&nbsp;<input type = "button" value = "_" id="Button_t4" /><TD>');
    if ($i==4)print('<TD width = "400" rowspan = "11" colspan = "4">
    	<Table class="color_table" style="border:1px solid black; border-collapse:collapse;"CELLPADDING="1" border = 1 bordercolor = black id="tbl2" width=100%>
    	<TR class = colors><TD></TD></TR>
    	</Table>
    	</TD>');
    print('</TR>');

    $i++;
    }

    $result = $dbh->query('SELECT COUNT(*) as c FROM prules p');
    $i = -1;
    $col = $result->fetch(PDO::FETCH_ASSOC);
    $i = $col['c'];
?>
    <TR VALIGN="top"><TD height = "300"><TD/></TR>
    <TR VALIGN="top"><TD><div id='log'><TD/></TR>
    </Table>

<?php
//	if ($i != -1) echo 'Prules info: '.$i;
?>


    </div>
</body>

</html>