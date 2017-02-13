<?
/**
 * Index login
 * @author		Daniel Soares Meurer
 * Formulario com lista de usuarios
 */
session_start();
if(empty($_SESSION)){ 
	/*var_dump($_SESSION);
	exit('sem sessão');*/
	header('location: login/form_login.php');
}
else{
	/*var_dump($_SESSION);
	exit('com sessão'); */
	header('location: briefing/form_lista.php');
}

/*
<html>
<head>
	<title>.::Vento-Criação de Briefing::.</title>
	<meta type="charset" content="iso-8859-1" >
	<meta type="author" content="Daniel Meurer" >
	<link href="../css/style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/start/jquery-ui.css" />
	<link rel="stylesheet" href="../css/theme.default.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<script src="../js/script.js"></script>
<body>
<div id="corpo">
	<form action="criar_usuario.php" method="post">
		<div id="titulo"> NOVO USUÁRIO </div>
		
		<br />
		Nome: 
		<br />
		<input type="text" name="nome" />
		<br />
		<br />
		Login: 
		<br />
		<input type="text" name="login" />
		<br />
		<br />
		Senha: 
		<br />
		
		<br />
		<br />
		Senha: 
		<br />
		<input type="password" maxlength="10" name="senha"  style="width: 160px; font-size: 30px;" />
		<br />
		<br />
		<input type="submit" value="Salvar" class="bt" style="width: 120px;" />
		
	</form>
</div> <!--FIM corpo -->
</body>
</html>
*/
?>
