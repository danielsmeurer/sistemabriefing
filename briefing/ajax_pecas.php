<?php
/**
 * Ajax Pe&ccedil;as
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * resolve intera&ccedil;ões CRUD de pe&ccedil;as com variavel $_POST envida via ajax.
 */
 //var_dump($_POST); exit();
?>

<?php
if(!isset($_POST)){ 
	exit("<h1>Acesso n&atilde;o autorizado.</h1>");
}
//var_dump($_POST);
require_once("../classes/briefing.php");
$briefing = new briefing();
$html="";
if($_POST['evento']=='criar'){
	//exit('criar');
	$briefing->adicionar_peca($_POST);
	$lista_peca = $briefing->get_peca($_POST['briefing_id'] );
	//var_dump($lista_peca); exit();
	if($lista_peca){
		$i=0;
		foreach($lista_peca as $peca){
			$i++;
			if($i%2==0){$quadro_class='par';}else{$quadro_class='impar';}
			$html.="<div class='pecascadastradas {$quadro_class}' style='margin-bottom: 20px; '>
			<table >
				<tr >
					<td colspan='4'width='940'>
					Descri&ccedil;&atilde;o: {$peca['peca_descricao']}<br>
					</td>
				</tr>
				<tr>
					<td width='50'> Qtd: {$peca['peca_qtd']}</td>
					<td width='200'>Formato: {$peca['peca_formato']} </td>
					<td width='250'>Data entrega: {$briefing->convert_data_bd_to_human($peca['peca_data_entrega'])}</td>
					<td width='100'>Pioridade: {$peca['peca_prioridade']}</td>
					
				</tr>
				<tr>
					<td colspan='4'width='940'>
						<a class='editar_peca' id='editar_peca-{$peca['id']}'>Editar</a>
						<a class='excluir_peca' id='excluir_peca-{$peca['id']}'>Excluir</a>
					</td>
				</tr>
			</table>
			</div>";
		}
	
		echo $html;
	}
}
elseif($_POST['evento']=='edita'){
	$lista_peca = $briefing->get_peca($_POST['briefing'] );
	//var_dump($lista_peca); exit();
	$i=0;
	if($lista_peca){
	foreach($lista_peca as $peca){
		$i++;
		if($i%2==0){$quadro_class='par';}else{$quadro_class='impar';}
		if($peca['id']==$_POST['idPeca']){
			$html .= "<div class='pecascadastradas {$quadro_class}' style='margin-bottom: 20px;'>
			<table >
				<tr >
					<td colspan='4'width='940'>
					Descri&ccedil;&atilde;o:  <input id='peca_edita_descricao' name='peca_edita_descricao' value={$peca['peca_descricao']}><br>
					</td>
				</tr>
				<tr>
					<td width='50'> Qtd: <input id='peca_edita_qtd' name='peca_edita_qtd' value='{$peca['peca_qtd']}'></td>
					<td width='50'>Formato: <input id='peca_edita_formato' name='peca_edita_formato' value='".$peca['peca_formato']."'> </td>
					<td width='50'>Data entrega: <input id='peca_edita_data' class='datepicker'  name='peca_edita_data' value='{$briefing->convert_data_bd_to_human($peca['peca_data_entrega'])}'></td>
					<td width='50'>Pioridade: <input id='peca_edita_prioridade' name='peca_edita_prioridade' value='{$peca['peca_prioridade']}'></td>
					
				</tr>
				<tr>
					<td colspan='4'width='940'>
							<a class='salva_peca_edita' id='salvar_peca-{$peca['id']}'>Salvar</a>
							<a class='cancela_peca_edita' id='cancelar_peca-{$peca['id']}'>Cancelar</a>
					</td>
					</td>
				</tr>
			</table>
			</div>";
		}
		else{
			$html.="<div class='pecascadastradas  {$quadro_class}' id='quadro_peca-{$peca['id']}' style='margin-bottom: 20px; '>
			<table >
				<tr >
					<td colspan='4'width='940' id='linha_peca_descricacao-d{$peca['id']}'>
					Descri&ccedil;&atilde;o: {$peca['peca_descricao']}<br>
					</td>
				</tr>
				<tr>
					<td width='50' id='linha_peca_qtd-{$peca['id']}'> Qtd: {$peca['peca_qtd']}</td>
					<td width='200' id='linha_peca_formato-{$peca['id']}' >Formato: {$peca['peca_formato']} </td>
					<td width='250' id='linha_peca_data-{$peca['id']}'>Data entrega: {$briefing->convert_data_bd_to_human($peca['peca_data_entrega'])}</td>
					<td width='100' id='linha_peca_prioridade-{$peca['id']}'>Pioridade: {$peca['peca_prioridade']}</td>
				</tr>
				<tr>
					<td colspan='4'width='940'>
					<a class='editar_peca' id='editar_peca-{$peca['id']}'>Editar</a>
					<a class='excluir_peca' id='excluir_peca-{$peca['id']}'>Excluir</a>
					</td>
				</tr>
			</table>
			</div>";
		}
	}
	echo $html;
	} 	
}
elseif($_POST['evento']=='salva'){
	$briefing->edita_peca($_POST);
	$lista_peca = $briefing->get_peca($_POST['briefing_id'] );
	
	if($lista_peca){
		$i=0;
		foreach($lista_peca as $peca){
			$i++;
			if($i%2==0){$quadro_class='par';}else{$quadro_class='impar';}
			$html.="<div class='pecascadastradas {$quadro_class}' style='margin-bottom: 20px;  '>
			<table >
				<tr >
					<td colspan='4'width='940'>
					Descri&ccedil;&atilde;o: {$peca['peca_descricao']}<br>
					</td>
				</tr>
				<tr>
					<td width='50'> Qtd: {$peca['peca_qtd']}</td>
					<td width='200'>Formato: {$peca['peca_formato']} </td>
					<td width='250'>Data entrega: {$briefing->convert_data_bd_to_human($peca['peca_data_entrega'])}</td>
					<td width='100'>Pioridade: {$peca['peca_prioridade']}</td>
					
				</tr>
				<tr>
					<td colspan='4'width='940'>
						<a class='editar_peca' id='editar_peca-{$peca['id']}'>Editar</a>
						<a class='excluir_peca' id='excluir_peca-{$peca['id']}'>Excluir</a>
					</td>
				</tr>
			</table>
			</div>";
		}
	
		echo $html;
	}
}
elseif($_POST['evento']=='cancela'){
	$lista_peca = $briefing->get_peca($_POST['briefing_id'] );
	
	if($lista_peca){
		$i=0;
		foreach($lista_peca as $peca){
			$i++;
			if($i%2==0){$quadro_class='par';}else{$quadro_class='impar';}
			$html.="<div class='pecascadastradas {$quadro_class}' style='margin-bottom: 20px;'>
			<table >
				<tr >
					<td colspan='4'width='940'>
					Descri&ccedil;&atilde;o: {$peca['peca_descricao']}<br>
					</td>
				</tr>
				<tr>
					<td width='50'> Qtd: {$peca['peca_qtd']}</td>
					<td width='200'>Formato: {$peca['peca_formato']} </td>
					<td width='250'>Data entrega: {$briefing->convert_data_bd_to_human($peca['peca_data_entrega'])}</td>
					<td width='100'>Pioridade: {$peca['peca_prioridade']}</td>
					
				</tr>
				<tr>
					<td colspan='4'width='940'>
						<a class='editar_peca' id='editar_peca-{$peca['id']}'>Editar</a>
						<a class='excluir_peca' id='excluir_peca-{$peca['id']}'>Excluir</a>
					</td>
				</tr>
			</table>
			</div>";
		}
	
		echo $html;
	}
}
elseif($_POST['evento']=='excluir'){
	//var_dump($_POST); exit(0);
	$briefing->excluir_peca($_POST['idPeca']);
	$lista_peca = $briefing->get_peca($_POST['briefing_id'] );
	
	if($lista_peca){
		$i=0;
		foreach($lista_peca as $peca){
			$i++;
			if($i%2==0){$quadro_class='par';}else{$quadro_class='impar';}
			$html.="<div class='pecascadastradas {$quadro_class}' style='margin-bottom: 20px;'>
			<table >
				<tr >
					<td colspan='4'width='940'>
					Descri&ccedil;&atilde;o: {$peca['peca_descricao']}<br>
					</td>
				</tr>
				<tr>
					<td width='50'> Qtd: {$peca['peca_qtd']}</td>
					<td width='200'>Formato: {$peca['peca_formato']} </td>
					<td width='250'>Data entrega: {$briefing->convert_data_bd_to_human($peca['peca_data_entrega'])}</td>
					<td width='100'>Pioridade: {$peca['peca_prioridade']}</td>
					
				</tr>
				<tr>
					<td colspan='4'width='940'>
						<a class='editar_peca' id='editar_peca-{$peca['id']}'>Editar</a>
						<a class='excluir_peca' id='excluir_peca-{$peca['id']}'>Excluir</a>
					</td>
				</tr>
			</table>
			</div>";
		}
	
		echo $html;
	}
	
}
 else{
	 exit(':(');
	 
 } ?>
 
<script>
	$('.editar_peca').button().click(function(){
		
		var idedita = $(this).attr('id');
			resto= idedita.split('-');
			idPeca= resto[1];
			idBriefing= $('#id').val();
		$.post( "ajax_pecas.php", { idPeca: idPeca , briefing : idBriefing, evento : 'edita' })
			 .done(function( data ) {
				$("#pecas_lista").html(data);
		})
	});
	
	$('.salva_peca_edita').click(function(){
		var peca_descricao		= $('#peca_edita_descricao').val();
			peca_qtd			= $('#peca_edita_qtd').val();
			peca_formato		= $('#peca_edita_formato').val();
			peca_data_entrega	= $('#peca_edita_data').val();
			peca_prioridade		= $('#peca_edita_prioridade').val();
			idsalva 			= $(this).attr('id');
			resto				= idsalva.split('-');
			idPeca				= resto[1];
			briefing_id			= $('#id').val();
			
		$.post( "ajax_pecas.php", {  evento : 'salva' , briefing_id : briefing_id , idPeca:idPeca, peca_descricao : peca_descricao, peca_qtd : peca_qtd, peca_formato : peca_formato, peca_data_entrega : peca_data_entrega, peca_prioridade : peca_prioridade })
			 .done(function( data ) {
				 $("#pecas_lista").html(data);
		})
	}).button();
	
	$('.cancela_peca_edita').button().click(function(){
		var idcancela = 	$(this).attr('id');
		resto= 				idcancela.split('-');
		briefing_id= 		$('#id').val();
		$.post( "ajax_pecas.php", {  evento : 'cancela', briefing_id : briefing_id })
			 .done(function( data ) {
				 $("#pecas_lista").html(data);
		}) 
	});
	
	$('.excluir_peca').button().click(function(){	
		var idexcluir =		$(this).attr('id');
		resto= 				idexcluir.split('-');
		idPeca= 		resto[1];
		briefing_id= 		$('#id').val();
		 
		decisao = confirm("Deseja excluir esta atividade?");
		
		if (decisao){
			$.post( "ajax_pecas.php", {  evento : 'excluir',  briefing_id : briefing_id, idPeca : idPeca })
				 .done(function( data ) {
					$("#pecas_lista").html(data);
					alert("<?php echo utf8_decode('Peça excluída com sucesso.'); ?>");
			})
		} 
		
	});



</script>

