<?php 
/**
 * Print Briefing
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * Recebe id de briefing via GET e chama metodo de criação de PDF
 */
include('../classes/briefing.php');
$briefing = new briefing();

$pdf=$briefing->gera_pdf($_GET['id']);
