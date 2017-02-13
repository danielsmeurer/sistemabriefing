<?php 
/**
 * Excluir Briefing
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * Recebe array GET e chama metodo para exclusão de briefing
 */
 require_once('../classes/briefing.php'); 
 $briefing= new briefing();
 $exclui=$briefing->excluir($_GET['id']);
 
 
