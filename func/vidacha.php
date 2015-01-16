<?php
	define('INCLUDE_CHECK',true);
	session_name('tzLogin');
	session_start();
?>
<html>
<head>
    <title>Видача [<?php echo $_SESSION['misce']; ?>]</title>
	<?php require 'bhead.php';?>
	<script type="text/javascript" src="../js/vidacha.js"></script>
	<style type="text/css">
		.color_table th, #first_tr {background-color: lightblue;}
	</style>
</head>
<body>
    <Table CELLPADDING = 0 border = 1 bordercolor = white>
	    <TR VALIGN="top">
<?php for ($i = 1; $i <= 5; $i++) echo '<TD><div id="selection'.$i.'" /></TD>';?>
		    <TD />
		    <TD />
		    <TD><div  id='ip' style='font-size: large'/></TD >
	    </TR>
		    <TR VALIGN="top">
<?php for ($i = 1; $i <= 5; $i++) echo '<TD rowspan = 2><div id="ListBox'.$i.'" /></TD>';?>
		    <TD height = 20><div  id='myKilkist' style='font-size: large'/></TD>
		    <TD height = 20><input type="button" value="Провести" id='Button1' /></TD>
		    <TD />
    	</TR>
    	<TR VALIGN="top">
    		<TD colspan = 3><Table class="color_table" style="border:1px solid black; border-collapse:collapse;"CELLPADDING="1" CELLPADDING=0 border = 1 id="tbl2" width=100%></Table></TD>
    	</TR>
    </Table>
    <div id='log' />
    <input type="button" value="Check" id='Button2' />
</body>
</html>