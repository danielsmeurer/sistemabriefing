<?php
/**
 * Form create add
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * Sequencia de Formulario de criação de briefing
 */

if(!isset($_GET['id']) or !$_GET['id'])
{
	echo  "Acesso não autorizado a está pagina.";
	exit(0);
}

$titulo="Novo briefing 2/2";
include("../template/header.php");

	$brief= new briefing();
	$briefing=$brief->getBriefing($_GET['id']);
	$cronograma= $brief->get_cronograma($_GET['id']);
?>
<style>
input{
	color:#7F7F7F;
}

</style>
<br>

<div id="corpo">
	<div id="breadcrumb" >
		<a href="../usuarios/principal.php" > Início</a>
		> 
		<a href="../briefing/form_lista.php" > Briefing:Lista</a> 
		> Briefing:Criar
	</div>
	</br>
	<span id="title-page"><? echo $titulo;?></span>
	<br />
	<br />
	<form action="editar_briefing.php" method="post">
		<input id="id" type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
		<div id="titulo"> BRIEFING <?php echo  str_pad($briefing['id'], 4, "0", STR_PAD_LEFT);?> </div>
		<br />
		Titulo:
		<br />
		<input id="titulo_briefing" type="text" name="titulo" value="<?php echo $briefing['titulo']; ?>"/>
		<br /><br />
		<div class="sub-title">CLIENTE</div>
		<br />
		Nome do cliente: 
		<br />
		<input id="nome_cliente" type="text" name="nome_cliente" value="<?php echo $briefing['nome_cliente']; ?>"/>
		<br /><br />
		Informações do cliente: 
		<br />
		<textarea id="info_cliente" name="info_cliente"><?php echo $briefing['info_cliente']; ?> </textarea>
		<br />
		<br />
		<div class="sub-title">PÚBLICO-ALVO</div>
		<textarea id="publico" name="publico">
		<?php 	
			if($briefing['publico']==''){
				echo 'Informações do público-alvo...';
			}
			else{			
				echo $briefing['publico']; 
			}
		?>
		</textarea>
		<br />
		<br />
		<div class="sub-title">DEMANDA</div>
		<textarea id="demanda" name="demanda">
		<?php 	
			if($briefing['demanda']==''){
				echo 'Trabalho a ser desenvolvido para o cliente...';
			}
			else{			
				echo $briefing['demanda'];
			}
		?>
		
		</textarea>
		<br />
		<br />
		<div class="sub-title">DESCRIÇÃO DA DEMANDA</div>
		<br>
	Peças (Quais/quantas):
		<textarea id="'demanda_pecas'" name="'demanda_pecas'">
			<?php 	
			if($briefing['demanda_pecas']==''){?>
			- Quais e quantas peças.
			<?php
				}
				else{			
					echo $briefing['demanda_pecas'];
				}
			?>			
		</textarea>
		
		<br><br>
		Formatos/tamanhos:
		<textarea id="'demanda_formato'" name="'demanda_formato'">
			<?php 	
			if($briefing['demanda_formato']==''){?>
	- Formatos, tamanhos.
			<?php
				}
				else{			
					echo $briefing['demanda_formato'];
				}
			?>			
		</textarea>

		<br>
		<br>
		Materiais e acabamentos:
		<textarea id="'demanda_materiais'" name="demanda_materiais">
			<?php 	
			if($briefing['demanda_materiais']==''){?>

			- Tipos de materiais e acabamentos
			<?php
				}
				else{			
					echo $briefing['demanda_materiais'];
				}
			?>			
		</textarea>
		<br>
		<br>
		Modo de finalização:
		<textarea id="demanda_finalizacao" name="demanda_finalizacao">
			<?php 	
			if($briefing['demanda_finalizacao']==''){?>

	- Como deve ser finalizado (AI, CDR, PDF, INDD, com ou sem sangra).* 
	*Pedir informações à gráfica antes do começo do trabalho.
			<?php
				}
				else{			
					echo $briefing['demanda_finalizacao'];
				}
			?>			
		</textarea>
		
		<br>
		<br>
		Local do arquivo:
		<input id="demanda_local" type="text" name="demanda_local" value="<?php if($briefing['demanda_local']==''){ echo  '- Onde deve ser postado o arquivo.*. (*Pedir informações à gráfica antes do começo do trabalho. )'; }else{ echo $briefing['nome_cliente'];} ?>"/>
		
			
		
		<br />
		<br />
		<div class="sub-title">OBJETIVO DE COMUNICAÇÃO</div>
		<textarea id="objetivo" name="objetivo">
		<?php 	
			if($briefing['objetivo']==''){
		?>
	O que o cliente pretende com essa peça.
	Imagem que quer passar.
		<?php
		}
		else{			
			echo $briefing['objetivo'];
		}
		?>
		</textarea>
		
		<br />
		<br />
		
		
		<div class="sub-title">RECOMENDAÇÕES</div>
		<br>
		Ideia inicial:
		<textarea id="recomendacoes_ideia" name="recomendacoes_ideia">		
		<?php 	
			if($briefing['recomendacoes_ideia']==''){
		?>	
	- Ideia inicial (quando já existir).
		<?php	
			}
			else{			
				echo $briefing['recomendacoes_ideia'];
			}
		?>
		</textarea>
		<br />
		<br />
		Referências:
		<textarea id="recomendacoes_referencias" name="recomendacoes_referencias">
		
		<?php 	
			if($briefing['recomendacoes_referencias']==''){
		?>	
	- trabalhos feitos anteriormente para o cliente, referências externas.
		<?php	
			}
			else{			
				echo $briefing['recomendacoes_referencias'];
			}
		?>
		</textarea>
		<br />
		<br />
		
		Objeçoes:
		<textarea id="recomendacoes_objecoes" name="recomendacoes_objecoes">
		
		<?php 	
			if($briefing['recomendacoes_objecoes']==''){
		?>	

	- Objeções (limitações de verba, preferências do cliente, cores)
		<?php	
			}
			else{			
				echo $briefing['recomendacoes_objecoes'];
			}
		?>
		</textarea>
		<br />
		<br />
		<div class="sub-title">Cronograma</div>
		<div id="cronograma">
		<span id="add_cronograma_item" >Adicionar +</span >
		<span id="hide_cronograma_item" style="display: none;" >Ocultar -</span >
		<div id="cronograma_form"  style="display: none;">
			<br />
			Atividade: <input type="text" id="cronograma_atividade" name="cronograma_atividade" style="width: 250px; height: 20px;" />
			Data início: <input type="text" class="datepicker"  id="cronograma_data_inicio" name="cronograma_data_inicio" style="width: 80px; height: 20px; text-align: center;" />
			Data fim: <input type="text"  class="datepicker" id="cronograma_data_fim" name="cronograma_data_fim" style="width: 80px; height: 20px; text-align: center;" />
			<a class="bt" id="salvar_atividade">Salvar atividade</a>
		</div>
		<br />
		<div id="cronograma_lista">	
			<?php 
				if($cronograma):?> 
				<table >
					<thead>
						<tr>
							<th>Atividade</th>
							<th align="center" width='60'>Inicio</th>
							<th align="center" width='60'>Fim</th>
							<th align="center" width="60">Editar</th>
							<th align="center" width="60">Excluir</th>
						</tr>
					</thead>
					<? foreach($cronograma as $etapa):?>
					<tr id="linha-cronograma-<? echo $etapa['id'];?>" >
						<td id="ativ-<? echo $etapa['id']; ?>"><? echo $etapa['atividade'];?></td>
						<td id="inicio-<? echo $etapa['id']; ?>" ><? echo $brief->convert_data_bd_to_human($etapa['inicio']);?></td>
						<td id="fim-<? echo $etapa['id']; ?>" ><? echo $brief->convert_data_bd_to_human($etapa['fim']);?></td>
						<td><span class="edita_etapa"  id="edita-<? echo $etapa['id'];?>"> Editar</span></td>
						<td><span class="excluir_etapa"  id="exclui-<? echo $etapa['id'];?>"> Excluir</span> </td>
					</tr>
					<? endforeach;?>
				</table>
				<? endif;?>
			</div>
			</div>
			<br>
			<input type="submit" value="Salvar" class="bt" style="width: 150px;" />
			
	</form>			

	</div>
	
	
	
	
	
</div> <!--FIM corpo -->
<? include("../template/footer.php"); ?>
