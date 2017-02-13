<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../css/theme.default.css" />
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/start/jquery-ui.css" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../js/jquery.tablesorter.min.js"></script>
	<script type="text/javascript" src="../js/jquery.tablesorter.widgets.min.js"></script> 
	<script type="text/javascript" type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.6/jquery.validate.js" ></script>
	<script type="text/javascript" src="../js/script.js"></script>
</head>
<body>
<form method="post" action="ajax_referencia.php" enctype="multipart/form-data" >
<table>
<tr id="tr_referencias_file">
	<td width="100">Arquivo: </td>
	
	<td> 
		<input type="hidden" id="ref_briefing_id" name="briefing_id" value="<?php echo $_GET['briefing_id'];?>">
		<input type="file" name="referencias" class="recomendacoes_referencias"  id="recomendacoes_referencias_file"> </td>
</tr>
<tr>
	<td id="linha_salvar_referencia" colspan="2">
		<br>
		<input name="referencia" class="bt" id="salvar_referencia_arq" style="width: 300px; height: 35px; " type="submit" value="Salvar refer&ecirc;ncia">
	</td>
</tr>
</table>



</form>
</body>
</html>
