<?php
/**
 * Ajax Cronograma 
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * resolve interações CRUD do cronogarama com variavel $_POST envida via ajax.
 */
if(!isset($_POST)){ 
	exit("<h1>Acesso não autorizado.</h1>");
}

require_once("../classes/briefing.php");
$briefing = new briefing();
if($_POST['evento']=='criar'){
	
	$briefing->adicionar_atividades_cronograma($_POST);
	
	$lista_cronograma = $briefing->get_cronograma($_POST['briefing_id'] );
	
	if($lista_cronograma){
	$table=	"<table >
				<thead>
					<tr>
						<th>Atividade</th>
						<th align='center' width='60'>Inicio</th>
						<th align='center' width='60'>Fim</th>
						<th align='center' width='60'>Editar</th>
						<th align='center' width='60'>Excluir</th>
					</tr>
				</thead>
				<tbody>";
		foreach($lista_cronograma as $etapa){
			$table	.="<tr id='linha-cronograma-{$etapa['id']}' >
						<td id='ativ-{$etapa['id']}'>{$etapa['atividade']}</td>
						<td id='inicio-{$etapa['id']}' >{$briefing->convert_data_bd_to_human($etapa['inicio'])}</td>
						<td id='fim-{$etapa['id']}' >{$briefing->convert_data_bd_to_human($etapa['fim'])}</td>
						<td><span class='edita_etapa'  id='edita-{$etapa['id']}'> Editar</span></td>
						<td><span class='excluir_etapa'  id='exclui-{$etapa['id']}'> Excluir</span> </td>
					</tr>";
		}
		$table	.="</tbody>
		</table>";
		echo $table;
	}
	
	
}
elseif($_POST['evento']=='edita'){
	$lista_cronograma = $briefing->get_cronograma($_POST['briefing'] );
	if($lista_cronograma){ 
		$table = "
			<table >
				<thead>
					<tr>
						<th>Atividade</th>
						<th align='center' width='60'>Inicio</th>
						<th align='center' width='60'>Fim</th>
						<th align='center' width='60'>Editar</th>
						<th align='center' width='60'>Excluir</th>
					</tr>
				</thead>
			<tbody>";

		foreach($lista_cronograma as $etapa){
		$atividade= $etapa['atividade'];
		$inicio = 	$briefing->convert_data_bd_to_human($etapa['inicio']);
		$fim = 		$briefing->convert_data_bd_to_human($etapa['fim']);
		$botão1=	"<span class='edita_etapa' id='edita-{$etapa['id']}'> Editar</span>";
		$botão2=	"<span class='excluir_etapa'  id='exclui-{$etapa['id']}'> Excluir</span>";
		if($etapa['id']==$_POST['cronograma']){
			$atividade= "<input id='atividade' name='atividade' type='text'  style='height:20px;'  value='{$etapa['atividade']}'/>";
			$inicio = 	"<input class='datepicker'  id='inicio' name='inicio' type='text' style='height:20px;' value='{$briefing->convert_data_bd_to_human($etapa['inicio'])}'/>";
			$fim = 		"<input class='datepicker'  id='fim' name='fim' type='text' style='height:20px;' value='{$briefing->convert_data_bd_to_human($etapa['fim'])}'/>";
			$botão1=	"<span name='salva' class='salva_etapa' id='salva-{$etapa['id']}'> Salvar</span>";
			$botão2=	"<span name='cancela' class='cancela_etapa'  id='cancela-{$etapa['id']}'> Cancelar</span>";
		}
		
		$table.="<tr id='linha-cronograma-{$etapa['id']}' >
			<td id='ativ-{$etapa['id']}'>{$atividade}</td>
			<td id='inicio-{$etapa['id']}' >{$inicio}</td>
			<td id='fim-{$etapa['id']}'> {$fim} </td>
			<td>{$botão1}</td>
			<td>{$botão2}</td>
		</tr>";
		}
	$table.='</tbody></table>';
	echo $table;
	} 	 
}
elseif($_POST['evento']=='salva'){
	
	$briefing->edita_cronograma($_POST);
	$lista_cronograma = $briefing->get_cronograma($_POST['briefing'] );
	
	if($lista_cronograma){
	$table=	"<table >
				<thead>
					<tr>
						<th>Atividade</th>
						<th align='center' width='60'>Inicio</th>
						<th align='center' width='60'>Fim</th>
						<th align='center' width='60'>Editar</th>
						<th align='center' width='60'>Excluir</th>
					</tr>
				</thead>
				<tbody>";
		foreach($lista_cronograma as $etapa){
			$table	.="<tr id='linha-cronograma-{$etapa['id']}' >
						<td id='ativ-{$etapa['id']}'>{$etapa['atividade']}</td>
						<td id='inicio-{$etapa['id']}' >{$briefing->convert_data_bd_to_human($etapa['inicio'])}</td>
						<td id='fim-{$etapa['id']}' >{$briefing->convert_data_bd_to_human($etapa['fim'])}</td>
						<td><span class='edita_etapa'  id='edita-{$etapa['id']}'> Editar</span></td>
						<td><span class='excluir_etapa'  id='exclui-{$etapa['id']}'> Excluir</span> </td>
					</tr>";
		}
		$table	.="</tbody>
		</table>";
		echo $table;
	}
	
}
elseif($_POST['evento']=='cancela'){
	$lista_cronograma = $briefing->get_cronograma($_POST['briefing'] );
	if($lista_cronograma){
	$table=	"<table >
				<thead>
					<tr>
						<th>Atividade</th>
						<th align='center' width='60'>Inicio</th>
						<th align='center' width='60'>Fim</th>
						<th align='center' width='60'>Editar</th>
						<th align='center' width='60'>Excluir</th>
					</tr>
				</thead>
				<tbody>";
		foreach($lista_cronograma as $etapa){
			$table	.="<tr id='linha-cronograma-{$etapa['id']}' >
						<td id='ativ-{$etapa['id']}'>{$etapa['atividade']}</td>
						<td id='inicio-{$etapa['id']}' >{$briefing->convert_data_bd_to_human($etapa['inicio'])}</td>
						<td id='fim-{$etapa['id']}' >{$briefing->convert_data_bd_to_human($etapa['fim'])}</td>
						<td><span class='edita_etapa'  id='edita-{$etapa['id']}'> Editar</span></td>
						<td><span class='excluir_etapa'  id='exclui-{$etapa['id']}'> Excluir</span> </td>
					</tr>";
		}
		$table	.="</tbody>
		</table>";
		echo $table;
	}
}
elseif($_POST['evento']=='excluir'){
	//var_dump($_POST); exit(0);
	$briefing->excluir_cronograma($_POST['cronograma']);
	$lista_cronograma = $briefing->get_cronograma($_POST['briefing'] );
	
	if($lista_cronograma){
	$table=	"<table  >
				<thead>
					<tr>
						<th>Atividade</th>
						<th align='center' width='60'>Inicio</th>
						<th align='center' width='60'>Fim</th>
						<th align='center' width='60'>Editar</th>
						<th align='center' width='60'>Excluir</th>
					</tr>
				</thead>
				<tbody>";
		foreach($lista_cronograma as $etapa){
			$table	.="<tr id='linha-cronograma-{$etapa['id']}' >
						<td id='ativ-{$etapa['id']}'>{$etapa['atividade']}</td>
						<td id='inicio-{$etapa['id']}' >{$briefing->convert_data_bd_to_human($etapa['inicio'])}</td>
						<td id='fim-{$etapa['id']}' >{$briefing->convert_data_bd_to_human($etapa['fim'])}</td>
						<td><span class='edita_etapa'  id='edita-{$etapa['id']}'> Editar</span></td>
						<td><span class='excluir_etapa'  id='exclui-{$etapa['id']}'> Excluir</span> </td>
					</tr>";
		}
		$table	.="</tbody>
		</table>";
		echo $table;
	}
}
 else{
	 exit(':(');
	 
 } ?>
 <script>
	$(function(){
		$('table').tablesorter({
			
			widgets        : ['zebra', 'columns'],
			usNumberFormat : false,
			sortReset      : true,
			sortRestart    : true, 
			useUI: true,
			
			
			 headers: { 
				0: { 
					sorter: 'numeric'
					
				}, 
				1: { 
					sorter: 'text'
				}, 
				2: { 
					sorter: 'text'
				}, 
				3: { 
					sorter:	  'text' 
				}, 
				4: { 
					sorter: 'date' 
				},
				5: { 
					sorter: 'date' 
				},
				6: { 
					sorter: false 
				},
				7: { 
					sorter: false 
				}
			} 
		});
	});	
 
	$('.edita_etapa').button().click(function(){
		var idedita = $(this).attr('id');
		resto= idedita.split('-');
		idCronograma= resto[1];
		idBriefing= $('#id').val();
		//alert('effre');
		$.post( "ajax_cronograma.php", { cronograma: idCronograma , briefing : idBriefing, evento : 'edita' })
			 .done(function( data ) {
				$("#cronograma_lista").html(data);
		})
	});
	
	$('.salva_etapa').click(function(){
		var atividade =		$('#atividade').val();
		inicio =			$('#inicio').val();
		fim =				$('#fim').val();
		idsalva = 			$(this).attr('id');
		resto= 				idsalva.split('-');
		idCronograma= 		resto[1];
		idBriefing= 		$('#id').val();
		$.post( "ajax_cronograma.php", {  evento : 'salva', atividade : atividade, inicio : inicio, fim: fim , briefing : idBriefing, cronograma : idCronograma })
			 .done(function( data ) {
				$("#cronograma_lista").html(data);
		})
	}).button();
	
	$('.cancela_etapa').button().click(function(){
		var idcancela = 	$(this).attr('id');
		resto= 				idcancela.split('-');
		idBriefing= 		$('#id').val();
		$.post( "ajax_cronograma.php", {  evento : 'cancela', briefing : idBriefing })
			 .done(function( data ) {
				$("#cronograma_lista").html(data);
		}) 
	});
	$('.excluir_etapa').button().click(function(){
	
		var idexcluir =		$(this).attr('id');
		resto= 				idexcluir.split('-');
		idCronograma= 		resto[1];
		idBriefing= 		$('#id').val();
		 
		decisao = confirm("Deseja excluir esta atividade?");
		
		if (decisao){
			$.post( "ajax_cronograma.php", {  evento : 'excluir',  briefing : idBriefing, cronograma : idCronograma })
				 .done(function( data ) {
					$("#cronograma_lista").html(data);
					alert ("Atividade excluída com sucesso.");
			})
		} 
		
	});
	
 
 </script>


