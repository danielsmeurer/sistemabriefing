<?php 
session_start();
if(is_null($_SESSION['login'])){
	echo '<script language= "JavaScript"> location.href=" ../login/form_login.php" </script>';}

include("../loader.php"); 
//exit('header');
//$login = new Login();



$user = new usuarios();
/*var_dump($user);
exit('5');*/
//var_dump($_SESSION['login']);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>.::Vento Briefing - <?php echo $titulo;?>::.</title>
	<meta type="author" content="Daniel Meurer" >
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="../css/theme.default.css" />
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/start/jquery-ui.css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../js/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="../js/jquery.tablesorter.widgets.min.js"></script> 
	<script type="text/javascript" type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.6/jquery.validate.js" ></script>
	<script type="text/javascript" src="../js/script.js"></script>
</head>
<body>

<div id="header">
	<div id="header-box">
		<div id="logo">
		</div>
		<div id="nav-bar">
			<ul>
				<li><a href="../briefing/form_lista.php">Início</a></li>
				<?php
					if($_SESSION['tipo']==='1'){
						?>
					<li><a href="../usuarios/form_lista.php">Usuários</a></li>
				<?php 
				}
				?>
			</ul>
		</div>
		<div id="header-right">
			
			<ul id="conf-user">
				<li>
					<?php echo $_SESSION['login']; ?>
				</li>
				<li>
					<a href="#" class="bt-icon" style="height: 20px; width: 50px;" ></a>
					<ul>
						<li>
							<div id="user-block">
								<?php echo $_SESSION['nome_usuario'];?>
								<br />
								<?php echo $_SESSION['login'];?>
								<br>
								<a href="../usuarios/form_edita.php">Editar Perfil</a>
								<br>
								<a href="../login/sair.php">Sair</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>





