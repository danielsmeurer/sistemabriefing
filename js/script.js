/**
 * Script
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * Principais Funçoes 
 */
$(document).ready(function(){

	
	$('#fecha').click(function(){
		//alert('wdded');
		$("#error").hide();
		$("#sucesso").hide();
	});
	
	$( ".datepicker" ).datepicker({
		dateFormat: 'dd/mm/yy',
		dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
		dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		nextText: 'Próximo',
		prevText: 'Anterior'
	});
	
	$("#add_cronograma_item").button().click(function(){
		$("#cronograma_form").show();
		$(this).hide();
		$("#hide_cronograma_item").show();
	});
	
	$("#hide_cronograma_item").button().click(function(){
		$("#cronograma_form").hide();
		$(this).hide();
		$("#add_cronograma_item").show();
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
	
	$("#salvar_atividade").click(function(){
		var atividade = $('#cronograma_atividade').val();
			inicio=		$('#cronograma_data_inicio').val();
			fim=		$('#cronograma_data_fim').val();
			briefing_id=$('#id').val();
		$.post( "ajax_cronograma.php", {  evento : 'criar' , briefing_id : briefing_id , atividade : atividade, inicio : inicio, fim : fim })
			 .done(function( data ) {
				 alert('Nova atividade foi salva.');
				$("#cronograma_lista").html(data);
				$('#cronograma_atividade').val('');
				$('#cronograma_data_inicio').val('');
				$('#cronograma_data_fim').val('');

		})
	});
	
	$("#salvar_referencia").click(function(){
		//alert('salvar ref'); 
		var caminho	=			$('#recomendacoes_referencias_url').val();
		tipo	=			'url';
		nome 	= 			$('#recomendacoes_referencias_nome').val();
		briefing_id =		$('#id').val();
	$.post( "ajax_referencia.php", {  caminho : caminho , briefing_id : briefing_id , tipo : tipo, nome : nome })
		 .done(function( data ) {
			 //$('#exibe_referencias').html(data);
			//alert('salvar ref 2'); 
			//$('#exibe_referencias').html(data);
			caminho	=	$('#recomendacoes_referencias_url').val('');
			nome 	= 	$('#recomendacoes_referencias_nome').val('');
			
			$.post( "referencias_lista.php", { briefing_id : briefing_id  })
				 .done(function( data ) {
					$('#exibe_referencias').html(data);	
			})
		})
		.fail(function() {
			alert( "error" );
		  })	
	});
	
	
	
	
	$('#file_upload_iframe').hover(
		function(){
			//alert('hover')
			briefing_id =		$('#id').val();
			$(this).contents().find('#salvar_referencia_arq').click(function(){
				$.post( "referencias_lista.php", { briefing_id : briefing_id  })
				 .done(function( data ) {
					$('#exibe_referencias').html(data);	
				})
			});
		}, function(){
			//alert('saiu');
			briefing_id =		$('#id').val();
			$(this).contents().find('#salvar_referencia_arq').click(function(){
				$.post( "referencias_lista.php", { briefing_id : briefing_id  })
				 .done(function( data ) {
					$('#exibe_referencias').html(data);	
				})
			});
			$.post( "referencias_lista.php", { briefing_id : briefing_id  })
				 .done(function( data ) {
					$('#exibe_referencias').html(data);	
			})
			
		}
	);
	
	
	$("#add_referencia_item").button().click(function(){
		$("#opcoes_referencias").show();
		$(this).hide();
		$("#hide_referencia_item").show();
	});
	
	$("#hide_referencia_item").button().click(function(){
		$("#opcoes_referencias").attr("checked",false).hide();
		$(this).hide();
		$("#add_referencia_item").show();
		$("#linha_salvar_referencia").hide();
		$("#tr_referencias_text").hide();
		$('#tr_referencias_file').hide();
		$("#recomendacoes_referencias_radios_url").attr("checked",false); 
		$("#recomendacoes_referencias_radios_file").attr("checked",false);
		
		
	});
	
	$('.recomendacoes_referencias_tipo').click(function(){
		var tipo = $(this).val();
		briefing_id = $('#id').val();
		if(tipo==1){
			//alert('url')
			$("#tr_referencias_text").show();
			$('#tr_referencias_file').hide(); 
			//$("#linha_salvar_referencia").show();
		}
		else if(tipo==2){
			//alert('file')
			$("#tr_referencias_file").show();
			$('#tr_referencias_text').hide();
			//$("#linha_salvar_referencia").show();
		}
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
	
	
	/*
	$('.edita_etapa').button().click(function(){
		var idedita = $(this).attr('id');
			resto= idedita.split('-');
			idCronograma= resto[1];
			briefing_id= $('#id').val();
		alert('effre');
		$.post( "ajax_cronograma.php", { cronograma: idCronograma , briefing : idBriefing, evento : 'edita' })
			 .done(function( data ) {
				 alert('chegou');
				$("#cronograma_lista").html(data);
		})
	});
	*/
	
	$('.salva_etapa').click(function(){
		var atividade =		$('#atividade').val();
			inicio =		$('#inicio').val();
			fim =			$('#fim').val();
			idsalva =		$(this).attr('id');
			resto=			idsalva.split('-');
			idCronograma=	resto[1];
			idBriefing=		$('#id').val();
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
	
	$('button').button();
	$('.bt').button();
	$('.bt-icon').button({
      icons: {
        primary: "ui-icon-gear",
        secondary: "ui-icon-triangle-1-s"
      },
      text: false
    });
	$('input:submit').button();
	
	
	
	$('.excluir').click(function(){
		var id=$(this).val();		
		$('#janela_exclui').html("Este item será excluído permanentemente. Você realmente deseja excluí-lo?");
		$( '#janela_exclui').attr('title','Confirmar exclusão?');
		//$('#janela').show();
		$( '#janela_exclui' ).dialog({
		  resizable: false,
		  height:230,
		  modal: true,
		  zebra: true,
		  buttons: {
			"Excluir": function() {
				$.post( "ajax_excluir_briefing.php", { id: id })
				  .done(function( data ) {
					$('#janela_exclui').html( data ).dialog({ buttons:false});
					//$('#'+id).hide();
					location.reload();
				 });
				
			},
			'Cancelar': function() {
			  $( this ).dialog( "close" );
			  
			}
		  }
		});
		
	});
	
	$('.exibe').click(function(){
		var id=$(this).val();
		$.post( "form_exibe.php", { id: id })
		  .done(function( data ) {
			  $( '#janela_exibe' )
			$('#janela_exibe').html( data ).dialog({width: 700,  height:600 });
			
			
		 });
	});
	/*Auto save */
		
	$("#titulo_briefing").change(function(){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			
		})
	}); 
	
	$("#nome_cliente").change(function(){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
			.done(function( data ) {	 }
		 );
	}); 
	
		
	$("#info_cliente").keypress(function(e){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			
		 }); 
		
	});
	
	$("#publico").keypress(function(e){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			 
		 }); 
		
	});
	
	$("#objetivo").keypress(function(e){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			 
		 }); 
		
	});
	
	$("#demanda").keypress(function(e){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			
		 }); 
		
	});	
	
	$("#demanda_formato").keypress(function(e){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			 
		 }); 
		
	});
	
	$("#demanda_materiais").keypress(function(e){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			 
		 }); 
		
	});
	
	$("#demanda_finalizacao").keypress(function(e){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			 
		 });
	});
	
	$("#demanda_local").keypress(function(e){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			 
		 });
	});
	
	$("#recomendacoes_ideia").keypress(function(e){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			 
		 });
	});
	
	$("#recomendacoes_referencias").keypress(function(e){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			 
		 });
	});
	
	$("#recomendacoes_objecoes").keypress(function(e){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			 
		 });
	});
	



	/*MUDA SENHA */
	$('#bt_troca_senha').click(function(){
		$('#bt_troca_senha').hide();
		$( '#bt_ocultar_troca_senha' ).show();
		$( '#alterar_senha' ).show();
		$( '#alterar_senha' ).html('<label for="new_senha">Nova senha:</label>	<input type="password" maxlength="10" name="new_senha"  id="new_senha" style="width: 160px; font-size: 20px; height: 20px;"  /> <br /><br /> <label for="conf_new_senha">Confirmar nova senha:</label> 	<input type="password" maxlength="10" name="conf_new_senha" id="conf_new_senha" style="width: 160px; height: 20px; font-size: 20px;"  <br />');
	});	 
	
	$('#bt_ocultar_troca_senha').click(function(){
		$( '#bt_troca_senha' ).show();
		$( '#alterar_senha' ).hide();
		$( '#alterar_senha' ).html('');
		$( '#bt_ocultar_troca_senha' ).hide();
	});

	/* FIM de muda Senha */

	/* FIM Auto save */
	
	$(function(){
		var briefing_id = $('#id').val();
		
		$.post( "referencias_lista.php", { briefing_id : briefing_id  })
			 .done(function( data ) {
				$('#exibe_referencias').html(data);	
		})
	
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
	
		$('.tablesorter').tablesorter();
	//validação
	//Peça
	
	$("#add_peca_item").button().click(function(){
		$("#peca_form").show();
		$(this).hide();
		$("#hide_peca_item").show();
	});
	
	$("#hide_peca_item").button().click(function(){
		$("#peca_form").hide();
		$(this).hide();
		$("#add_peca_item").show();
	});
	
	
	$("#demanda_pecas").keypress(function(e){
		var campo = $(this).attr("name");
		var valor = $(this).val();
		var id = $('#id').val();
		
		$.post( "ajax_editar.php", { id: id, campo : campo, valor:valor })
		 .done(function( data ) {
			 
		 }); 
		
	});
	
	$("#salvar_peca").click(function(){
		var peca_descricao		= $('#peca_descricao').val();
			peca_qtd			= $('#peca_qtd').val();
			peca_formato		= $('#peca_formato').val();
			peca_data_entrega	= $('#peca_data_entrega').val();
			peca_prioridade		= $('#peca_prioridade').val();
			briefing_id			= $('#id').val();
		$.post( "ajax_pecas.php", {  evento : 'criar' , briefing_id : briefing_id , peca_descricao : peca_descricao, peca_qtd : peca_qtd, peca_formato : peca_formato, peca_data_entrega : peca_data_entrega, peca_prioridade : peca_prioridade })
			 .done(function( data ) { 
				$("#pecas_lista").html(data);
				alert('Peça salva.');
				$('#peca_descricao').val('');
				$('#peca_qtd').val('');
				$('#peca_formato').val('');
				$('#peca_data_entrega').val('');
				$('#peca_prioridade').val('');
		})
	});
	
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
		 
		decisao = confirm("Deseja excluir esta peça?");
		
		if (decisao){
			$.post( "ajax_pecas.php", {  evento : 'excluir',  briefing_id : briefing_id, idPeca : idPeca })
				 .done(function( data ) {
					$("#pecas_lista").html(data);
					alert("Peça excluída com sucesso.");
			})
		} 
		
	});
	
	//$('#exibe_referencias').contents().find('.excluir_referencia').button();
	
	
	
});


