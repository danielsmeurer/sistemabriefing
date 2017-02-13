<?php
/**
 * Form Create
 * @author		Daniel Soares Meurer
 * Formulario para criação de Briefing
 */
$titulo="Novo briefing 1/2";
include("../template/header.php");
?>

<br>
<div id="corpo">
	<div id="breadcrumb" >
		<a href="../usuarios/principal.php" > Início</a>
		> 
		<a href="../briefing/form_lista.php" > Briefing:Lista</a> 
		> Briefing:Criar
	</div>
	<br />
	<span id="title-page"> <? echo $titulo;?> </span>
	<br>	
	<form action="criar_briefing.php" method="post">
		<div id="titulo"> NOVO BRIEFING </div>
		<div class="sub-title">CLIENTE</div>
		<br />
		Titulo do briefing: 
		<br />
		<input type="text" name="titulo" />
		<br />
		<br />
		Nome do cliente: 
		<br />
		<input type="text" name="nome_cliente" />
		<br />
		<br />
		<input type="submit" value="Salvar" class="bt" style="width: 120px;" />
		
	</form>
</div> <!--FIM corpo -->
</body>
</html>
