<?php
/**
 * Edita usuario
 * @author		Daniel Soares Meurer
  * Recebe variavel array POST e chama metodo editar usuario passando POST como parametro
 */
if(isset($_POST['id'])){
	require_once("../classes/usuarios.php");
	$usuario = new usuarios();
	$retorno = $usuario->editar($_POST);
	//var_dump($retorno); exit(0);
	if(!$retorno){
		exit("Erro Fatal!");
	}
	else{
		include("form_edita.php");
	}
}
else{
	exit('Acesso não autorizado.');
}
?>
