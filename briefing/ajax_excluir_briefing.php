<?php 
/**
 * Ajax Excluir Briefing
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * Recebe array POST['id'] via ajax e chama metodo para exclusão de briefing  passando $POST recebido como parametro
 */
 
 require_once('../classes/briefing.php'); 
 $briefing= new briefing();

 if($briefing->ajax_excluir($_POST['id'])){
	echo 'Item excluido com sucesso.';
 }
 else{
	 echo 'Não foi possivel excluir o item seleciona.';
 }
 
 
