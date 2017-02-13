
<?php

//var_dump($_POST, $_FILES); exit();

if(!isset($_POST['briefing_id'])  ){ exit('<h1>Acesso Negado</h1>');}
include("../classes/briefing.php");
$briefing =	new Briefing();
$lista_referencias = $briefing->get_referencias($_POST['briefing_id']);
if($lista_referencias){	?>
<table width="100%" class="tablesorter" id="tabela_referencias">
	<tr >
		<thead>
			<?php /*<td width="100">Titulo</td> */ ?>
			<th >Referência</th>
			<th align="center" width="70" >Excluír</th>
		</thead>
	</tr>
	
<?php
	foreach($lista_referencias as $referencia){
		echo "<tr>";
		//var_dump($referencia);
		//echo '<td> '.$referencia['nome'].'</td>';
		if($referencia['tipo'] == 'url'){
			echo '<td> <a href='.$referencia['caminho'].' target="_blank">'.$referencia['caminho'].'</a></td>';
		}
		else{
			echo '<td> <a href="'.$referencia['caminho'].'" target="_blank">'.$referencia['nome'].'</a>';
			if($briefing->is_image($referencia['nome'])){
				echo '<br><br><a href="'.$referencia['caminho'].'" target="_blank"><img src="'.$referencia['caminho'].'" height="220" ></a>';
			}
			
			echo '</td>';
		}
		//echo '<td>'.$referencia['tipo'].'</td>';
		
		//echo '<td><span class="edita_referencia bt"  id="edita_referencia-'.$referencia['id'].'"> Editar</span></td>';
		echo '<td><a  class="excluir_referencia bt" id="exclui_referencia-'.$referencia['id'].'"> Excluir</button> </a>';
		echo "</tr>";
	}?>
</table>
<?php } ?>

</div>

	
<?php // echo $briefing['recomendacoes_referencias']; ?>

<script >
	$(document).ready(function(){ 
	$('.bt').button();
	$('.excluir_referencia').click(function(){
		var idexcluir =		$(this).attr('id');
		resto= 				idexcluir.split('-');
		idReferencia= 		resto[1];
		briefing_id= 		$('#id').val();
		//alert(briefing_id);
		decisao = confirm("Deseja excluir esta referência?");
		if (decisao){
				//alert('Referencia excluida');
				$.post( "ajax_referencia.php", { evento : 'excluir' , id: idReferencia  }) 

				.done(function( data ) {
					//alert('Referencia excluida.');
					$.post( "referencias_lista.php", { briefing_id : briefing_id  })
					.done(function( data ) {
						//alert(data)
						$('#tabela_referencias').parent().html(data)
						 
						
					})
					.fail(function() {
						alert( "error" );
					 })
				}) 
				.fail(function() {
				alert( "error1" );
			  })
				
		}
	});
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
					sorter: false
				}, 
				2: { 
					sorter: false
				}
				
			} 
		});
	});	

})
</script>
