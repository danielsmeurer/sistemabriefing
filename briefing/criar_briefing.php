<?php 
/**
 * Criar Briefing
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * Chama metodo para criação de Briefing
 */

 require_once('../classes/briefing.php'); 
 $briefing= new briefing();
 $id=$briefing->create();
 if($id){
	header('location: form_create_add.php?id='.$id );
 }
 
 
