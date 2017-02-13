<?php
/**
 * Ajax trocar senha
 * @author		Daniel Soares Meurer
  * Recebe variavel array POST e chama metodo para troca de senha passando POST como parametro
 */
if(isset($_POST['nome'])){
	require_once("../classes/usuarios.php");
	$usuario = new usuarios();
	$usuario->ajax_trocar_senha($_POST);
}
else{
	exit('Acesso não autorizado.');
}
?>
