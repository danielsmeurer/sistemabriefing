<?php
/**
 * Ajax Editar
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * Recebe array POST via ajax e chama metodo para edição campo do briefing  passando $POST recebido como parametro
 */
 require_once('../classes/briefing.php'); 
 $briefing= new briefing();
 $briefing->ajax_edita($_POST['id'],$_POST['campo'],utf8_decode($_POST['valor']));
 

