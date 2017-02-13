<? 
/**
 * Form login
 * @author		Daniel Soares Meurer
 * Formulario de login
 */

session_start();
if(!empty($_SESSION['login'])){ header('location: ../index.php'); }

?>

<html>
<head>
	<title>.::Vento-Briefing Online Área de Login::.</title>
	<meta type="charset" content="iso-8859-1" >
	<meta type="author" content="Daniel Meurer" >
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/start/jquery-ui.css" />
	<link rel="stylesheet" href="../css/theme.default.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<script src="../js/script.js"></script>
<body>
	<br /><br /><br />
<div id="corpo" style="width: 400px; background: #F0F8FF; padding: 20px 20px 20px 20px; border-top: 1px solid #00aac9; border-left: 1px solid #00aac9; border-right: 1px solid #00aac9; border-bottom: 1px solid #00aac9;">
	<form action="logar.php" method="post">
		<div id="titulo"> Briefing Online </div>
		<br />
		<? if(isset($_GET['erro']) and ($_GET['erro'])){ echo '<span style="color: #D50000;">Login e/ou Senha incorreto(s)</span>';}; ?>
		<br />
		Login: 
		<br />
		<input type="text" name="login" />
		<br />
		<br />
		Senha: 
		<br />
		<br />
		<input type="password" maxlength="10" name="senha"  style="width: 160px; font-size: 30px;" />
		<br />
		<br />
		<input type="submit" value="Entrar" class="bt" style="width: 120px;" />
	</form>
</div> <!--FIM corpo -->
</body>
</html>
