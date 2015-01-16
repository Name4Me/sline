<?php
	define('INCLUDE_CHECK',true);

	require 'func/config.php';
	require 'func/connect.php';
	require 'func/functions.php';

	session_name('tzLogin');
	session_set_cookie_params(2*7*24*60*60); // Устанавливаем время жизни куки 2 недели
	session_start(); // Запуск сессии

if($_SESSION['id'] && !isset($_COOKIE['tzRemember']) && !$_SESSION['rememberMe']) {
	// Если вы вошли в систему, но куки tzRemember (рестарт браузера) отсутствует
	// и вы не отметили чекбокс 'Запомнить меня':
	$_SESSION = array();
	session_destroy();
	// Удалаяем сессию
}

//$user = new WUser($_SESSION['user_id']);
if (!isset($_SESSION['misce'])) $_SESSION['misce'] = 'x';

if(isset($_GET['logoff'])) logoff();
if(isset($_GET['up_misce'])) logoff();



if($_POST['submit']=='Войти')
{
	// Проверяем, что представлена форма Войти

	$err = array();
	// Запоминаем ошибки


	if(!$_POST['username'] || !$_POST['password'])
		$err[] = 'Все поля должны быть заполнены!';

	if(!count($err))
	{

		$_POST['username'] = addslashes($_POST['username']);
		$_POST['password'] = md5($_POST['password']);
		$_POST['rememberMe'] = (int)$_POST['rememberMe'];
        $dbh->prepare("SET CHARACTER SET utf8")->execute();
		// Получаем все ввденые данные
        $s="SELECT id,user FROM users WHERE user='".$_POST['username']."' AND md5pass='".$_POST['password']."'";
        $result = $dbh->query($s);
    	$row = $result->fetch(PDO::FETCH_ASSOC);

		if($row['user'])
		{
			// Если все в порядке - входим в систему

			$_SESSION['usr']=$row['user'];
			$_SESSION['id'] = $row['id'];
			$_SESSION['rememberMe'] = $_POST['rememberMe'];

			// Сохраняем некоторые данные сессии

			setcookie('tzRemember',$_POST['rememberMe']);
		}
		else $err[]='> Ошибочный пароль или/и имя пользователя!';  //md5($_POST['password']).
	}

	if($err)
	$_SESSION['msg']['login-err'] = implode('<br />',$err);
	// Сохраняем сообщение об ошибке сессии

	header("Location: index.php");
	exit;
}


$script = '';

if($_SESSION['msg'])
	{
	// Скрипт ниже показывает выскаьзывающую панель
	$script = '
	<script type="text/javascript">
		$(function(){
			$("div#panel").show();
			$("#toggle a").toggle();
		});
	</script>';
	}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>
<?php
	require 'head.php';
?>
</head>

<body>
<script type="text/javascript">
	$(function(){

		$('button').click(function(){
                  var i = $(this);
                  i.addClass('ui-state-active a');
                  setTimeout(function() {
				i.removeClass('ui-state-active a');
				//$('#tabs-3').load('../test.php');
			}, 500);
		});;


	});
</script>
  		<style type="text/css">
			/*demo page css*/
			body{ font: 62.5% "Trebuchet MS", sans-serif;}
			.demoHeaders { margin-top: 2em; }
			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
		</style>

<!-- Панель -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left"></div>


            <?php

			if(!$_SESSION['id']):

			?>

			<div class="left">
				<!-- Форма входа -->
				<form class="clearfix" action="" method="post">

                    <?php

						if($_SESSION['msg']['login-err'])
						{
							echo '<div class="err">'.$_SESSION['msg']['login-err'].'</div>';
							unset($_SESSION['msg']['login-err']);
						}
					?>

					<label class="grey" for="username">Имя пользователя:</label>
					<input class="field" type="text" name="username" id="username" value="" size="23" />
					<label class="grey" for="password">Пароль:</label>
					<input class="field" type="password" name="password" id="password" size="23" />
	            	<label><input name="rememberMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> &nbsp;Запомнить меня</label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Войти" class="bt_login" />
				</form>
			</div>
			<div class="left right"></div>


            <?php

			else:

			?>
            <Table><TR><TD>
            <div class="left">
            <p>SaveSnap Valik&nbsp <button id="saveSnapV" >SaveSnap Valik</button></p>
            <p>SaveSnap Legenda&nbsp <button id="saveSnapL" >SaveSnap Legenda</button></p>
            <p>SaveSnap Dixy&nbsp <button id="saveSnapD" >SaveSnap Dixy</button></p>
            <a href="registered.php">Перейти на страницу пользователя</a>
            <p>- или -</p>
            <a href="?logoff">Выйти из системы</a>

            </div>
            </TD>
            <TD>
            	<div class="left ">
	            	<p>Склад сохранить &nbsp <button id="ssave" >SmallSave</button></p>
	            	<p>Замовлення з Света Чернівці &nbsp <button id="az_sveta" >azSveta</button></p>
	            	<p>Очистити Валік &nbsp <button id="del_valik" >clearValik</button></p>
	            	<p>Очистити x &nbsp <button id="del_x" >clearX</button></p>
                </div>
            </TD>
            <TD>
            	<div class="left ">
	            	<p>Misce <div id='ComboBox1'></div></p>
                    <a href="func/reprice.php" target="_blank">Переоцінка</a>
                    |
                    <a href="func/printzvit.php" target="_blank">Роздруківка</a>
                    |
                    <a href="#" id="up_misce">update misce</a>
                </div>
            </TD>
            </TR>
            </Table>

            <div class="left right">
            </div>

            <?php
			endif;
			?>
		</div>
	</div>

    <!-- Закладка наверху -->
	<div class="tab">
		<ul class="login">

	    	<li class="left">&nbsp;</li>
	        <li class="title">

	        </li>
	    	<li class="right">&nbsp;</li>

	    	<li class="left"></li>
	    	<li >
	            <a href="func/vidacha.php" target="_blank">Видача</a>
	            |
	            <a href="func/search.php" target="_blank">Пошук</a>
	            |
	        	<a href="func/printzvit.php" target="_blank">Роздруківка</a>

	        </li>
	    	<li class="right"></li>

	    	<li class="left">&nbsp;</li>
			<li id="toggle">

				<a id="open" class="open" href="#"><?php echo $_SESSION['id']?'Открыть панель':'Вход';?></a>
				<a id="close" style="display: none;" class="close" href="#">Закрыть панель</a>
			</li>
	    	<li class="right">&nbsp;</li>



		</ul>



</div>


	<div class="pageContent">
	    <div id="main">
	         <div class="container">


        <!-- Tabs ------------------------------------------------------[End]-->


	        </div>
		</div>
	</div>

</body>
</html>
