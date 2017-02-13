<?php
/**
 * Ajax add Cronograma 
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * Recebe array POST chama metodo para adi��o ao cronograma passando $POST recebido como parametro
 */
if(!isset($_POST)){ 
	exit("<h1>Acesso n�o autorizado.</h1>");
}

require_once("../classes/briefing.php");
$briefing = new briefing();
if($_POST['evento']=='criar'){
	//var_dump($_POST); exit(0);
	$briefing->adicionar_atividades_cronograma($_POST);
	//echo '1<br>';
	//$lista_cronograma = $briefing->get_cronograma($_POST['briefing_id'] );
}
 ?>

