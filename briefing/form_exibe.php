<?php
/**
 * Form Exibe
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * Exibe dados de um briefing
 */
session_start();
if(empty($_SESSION)){ header('location: ../login/form_login.php');}

if(!isset($_POST['id']) or !$_POST['id'])
{
	echo  "Acesso não autorizado a está pagina.";
	exit(0);
}
	require_once('../classes/briefing.php'); 
	$brief= new briefing();
	$briefing=$brief->getBriefing($_POST['id']);
	$cronograma= $brief->get_cronograma($_POST['id']);
	
 ?>


<div  style="width:660px">
	<div id="titulo"> BRIEFING Nº <?php echo  str_pad($_POST['id'], 4, "0", STR_PAD_LEFT);?> - <? echo utf8_encode($briefing['titulo'])?> </div>
	<div class="sub-title">CLIENTE</div>
	<br />
	Nome do cliente: 
	<br />
	<div style="border-top:1px #9D9D9D solid; 
				border-bottom:1px #9D9D9D solid;
				border-left:1px #9D9D9D solid;
				border-right:1px #9D9D9D solid;
				padding: 5px 5px 5px 5px;"
	>
		<?php echo utf8_encode($briefing['nome_cliente']); ?>
	</div>
	<br />
	Informações do cliente: 
	<div style="border-top:1px #9D9D9D solid; 
				border-bottom:1px #9D9D9D solid;
				border-left:1px #9D9D9D solid;
				border-right:1px #9D9D9D solid;
				padding: 5px 5px 5px 5px;"
	>
		<?php echo utf8_encode(nl2br( $briefing['info_cliente'] )); ?>
	</div>
	<br />
		
	<div class="sub-title"> DEMANDA </div>
	
	<br />
	Descrição e conceito:
	<br>
	<div style="border-top:1px #9D9D9D solid; 
				border-bottom:1px #9D9D9D solid;
				border-left:1px #9D9D9D solid;
				border-right:1px #9D9D9D solid;
				padding: 5px 5px 5px 5px;"
	>
		<?php echo  utf8_encode(nl2br($briefing['demanda'])); ?>
	</div>
	<br />
	Objetivo de comunicação:
	<br />
	<div style="border-top:1px #9D9D9D solid; 
				border-bottom:1px #9D9D9D solid;
				border-left:1px #9D9D9D solid;
				border-right:1px #9D9D9D solid;
				padding: 5px 5px 5px 5px;"
	>
		<?php echo  utf8_encode(nl2br($briefing['objetivo'])); ?>
	</div>
	<br />
	Público-alvo:
	<br />	
	<div style="border-top:1px #9D9D9D solid; 
				border-bottom:1px #9D9D9D solid;
				border-left:1px #9D9D9D solid;
				border-right:1px #9D9D9D solid;
				padding: 5px 5px 5px 5px;"
	>
		<?php echo   utf8_encode(nl2br($briefing['publico'])); ?>
	</div>
	<br />
	
	
	<div class="sub-title">DADOS TÉCNICOS DA DEMANDA</div>
	<br />
	Peças:
	<br>
	<div id="pecas_lista">
				<?php
				$html="";
				$lista_peca = $brief->get_peca($_POST['id'] );
				//var_dump($lista_peca); exit();
				if($lista_peca){
					$i=0;
				foreach($lista_peca as $peca){
					$i++;
					if($i%2==0){$quadro_class='par';}else{$quadro_class='impar';}
					$html.="<div class='pecascadastradas {$quadro_class}' id='quadro_peca-{$peca['id']}' style='margin-bottom: 20px;  '>
					<table >
						<tr >
							<td colspan='4'width='940' id='linha_peca_descricacao-d{$peca['id']}'>
							Descrição: {$peca['peca_descricao']}<br>
							</td>
						</tr>
						<tr>
							<td width='50' id='linha_peca_qtd-{$peca['id']}'> Qtd: {$peca['peca_qtd']}</td>
							<td width='200' id='linha_peca_formato-{$peca['id']}' >Formato: {$peca['peca_formato']} </td>
							<td width='250' id='linha_peca_data-{$peca['id']}'>Data entrega: {$brief->convert_data_bd_to_human($peca['peca_data_entrega'])}</td>
							<td width='100' id='linha_peca_prioridade-{$peca['id']}'>Pioridade: {$peca['peca_prioridade']}</td>
							
						</tr>
					</table>
					</div>";
				}
				echo $html;
				}
	?>
	</div>
	
	
	
	
	
	<br>
	Materiais e acabamentos: 
	<div style="border-top:1px #9D9D9D solid; 
				border-bottom:1px #9D9D9D solid;
				border-left:1px #9D9D9D solid;
				border-right:1px #9D9D9D solid;
				padding: 5px 5px 5px 5px;"
	>
		<?php echo utf8_encode(nl2br($briefing['demanda_materiais'])); ?>
	</div>
	<br>
	Modo de finalização:
	<div style="border-top:1px #9D9D9D solid; 
				border-bottom:1px #9D9D9D solid;
				border-left:1px #9D9D9D solid;
				border-right:1px #9D9D9D solid;
				padding: 5px 5px 5px 5px;"
	>
		<?php echo utf8_encode(nl2br($briefing['demanda_finalizacao'])); ?>
	</div>
	<br>
	Local do arquivo:
	<div style="border-top:1px #9D9D9D solid; 
				border-bottom:1px #9D9D9D solid;
				border-left:1px #9D9D9D solid;
				border-right:1px #9D9D9D solid;
				padding: 5px 5px 5px 5px;"
	>
		<?php echo utf8_encode(nl2br($briefing['demanda_local'])); ?>
	</div>
		
	<br />
	
	
	
	<div class="sub-title">RECOMENDAÇÕES</div>
	<br />
	<br />
	
	<br />
	Referências:
	
	
	
	<table width="100%" class="tablesorter">
	<tr >
		<thead>
			<?php /*<td width="100">Titulo</td> */ ?>
			<th >Referência</th>

		</thead>
	</tr>
	
<?php
	$lista_referencias = $brief->get_referencias($_POST['id']);
if($lista_referencias){
	foreach($lista_referencias as $referencia){
		echo "<tr>";
		//var_dump($referencia);
		//echo '<td> '.$referencia['nome'].'</td>';
		if($referencia['tipo'] == 'url'){
			echo '<td> <a href='.$referencia['caminho'].' target="_blank">'.$referencia['caminho'].'</a></td>';
		}
		else{
			echo '<td> <a href="'.$referencia['caminho'].'" target="_blank">'.$referencia['nome'].'</a>';
			if($brief->is_image($referencia['nome'])){
				echo '<br><br><a href="'.$referencia['caminho'].'" target="_blank"><img src="'.$referencia['caminho'].'" height="220" ></a>';
			}
			
			echo '</td>';
		}
		//echo '<td>'.$referencia['tipo'].'</td>';
		
		//echo '<td><span class="edita_referencia bt"  id="edita_referencia-'.$referencia['id'].'"> Editar</span></td>';
		//echo '<td><a  class="excluir_referencia bt" id="exclui_referencia-'.$referencia['id'].'"> Excluir</button> </a>';
		echo "</tr>";
	}
}?>
</table>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<div style="border-top:1px #9D9D9D solid; 
				border-bottom:1px #9D9D9D solid;
				border-left:1px #9D9D9D solid;
				border-right:1px #9D9D9D solid;
				padding: 5px 5px 5px 5px;"
	>
		<?php echo utf8_encode(nl2br($briefing['recomendacoes_referencias'])); ?>
	</div>
	<br />
	Objeçoes:
	<div style="border-top:1px #9D9D9D solid; 
				border-bottom:1px #9D9D9D solid;
				border-left:1px #9D9D9D solid;
				border-right:1px #9D9D9D solid;
				padding: 5px 5px 5px 5px;"
	>
		<?php echo utf8_encode(nl2br($briefing['recomendacoes_objecoes'])); ?>
	</div>
	<br>
	<br />
	
<div id="cronograma_lista"  style="widht: 100%;">	
	<?php 
		$linha=0;
		if($cronograma):?> 
		<table style="widht: 100%;">
			<thead>
				<tr>
					<th width='450'>Atividade</th>
					<th align="center" width='60'>Inicio</th>
					<th align="center" width='60'>Fim</th>
				</tr>
			</thead>
			<?php foreach($cronograma as $etapa):
				$linha++;
				if($linha%2 == 0){$classe_linha='par';}else{$classe_linha='impar';}
			?>
			<tr id="linha-cronograma-<? echo $etapa['id'];?>" class="<?php echo $classe_linha;?>" >
				<td id="ativ-<? echo $etapa['id']; ?>"><? echo $etapa['atividade'];?></td>
				<td id="inicio-<? echo $etapa['id']; ?>" ><? echo $brief->convert_data_bd_to_human($etapa['inicio']);?></td>
				<td id="fim-<? echo $etapa['id']; ?>" ><? echo $brief->convert_data_bd_to_human($etapa['fim']);?></td>
			</tr>
			<? endforeach;?>
		</table>
		<? endif;?>
	</div>
</div>	
	
	<br />
</div> 
<script>
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


</script>
