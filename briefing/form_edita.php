
<?php
/**
 * Excluir Briefing
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * formulário de edição de briefing
 */
$titulo="BRIEFING - Edição";
include("../template/header.php");

if(!isset($_GET['id']) or !$_GET['id'])
{
	echo  "Acesso não autorizado a está pagina.";
	exit(0);
}
	$brief= new briefing();
	$briefing=$brief->getBriefing($_GET['id']);
	$cronograma= $brief->get_cronograma($_GET['id']);
?>

<div id="corpo">
	<div id="breadcrumb" >
		<a href="../briefing/form_lista.php" > Início - Briefing:lista</a> > Editar
	</div>
	
	<br />
	<span id="title-page"><? echo $titulo;?></span>
	<br>
	<? if(isset($_SESSION['msg']['error'])){?>
	<div id="error">
		<div style="float: left;"><img src="../img/error.png" /></div>
		<div><? echo $_SESSION['msg']['error']['main'];?> </div>
		<div id='fecha'>X</div>
	</div>
	<?	}
	if(isset($_SESSION['msg']['sucesso'])){?>
	<div id="sucesso">
		<div style="float: left;"><img src="../img/sucesso.png" /></div>
		<div><? echo $_SESSION['msg']['sucesso'];?> </div>
		<div id='fecha'>X</div>
	</div>
	<?}?>
	
	<br />
	<form action="editar_briefing.php" method="post" enctype='multipart/form-data'>
		<input id="id" type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
		<div id="titulo"> BRIEFING <?php echo  str_pad($briefing['id'], 4, "0", STR_PAD_LEFT);?> </div>
		<br />
		*Titulo:
		<br />
		<input id="titulo_briefing" type="text" name="titulo" value="<?php echo $briefing['titulo']; ?>"/>
		<br>
		<? if(isset($_SESSION['msg']['error']['titulo'])){
			echo '<span style="color:#D20000;">'.$_SESSION['msg']['error']['titulo'].'</span>';
		}?>
		<br /><br />
		<div class="sub-title">CLIENTE</div>
		<br />
		*Nome do cliente: 
		<br />
		<input id="nome_cliente" type="text" name="nome_cliente" value="<?php echo $briefing['nome_cliente']; ?>"/>
		<br />
		<? if(isset($_SESSION['msg']['error']['nome_cliente'])){
			echo '<span style="color:#D20000;">'.$_SESSION['msg']['error']['nome_cliente'].'</span>';
		}?>
		<br /><br />
		Informações do cliente: 
		<br />
		<textarea id="info_cliente" name="info_cliente">
<?php echo $briefing['info_cliente']; ?>
		</textarea>
		<br />
		<br />
		<div class="sub-title">DEMANDA</div>
		Descrição e conceito:
		<textarea id="demanda" name="demanda">
<?php echo $briefing['demanda']; ?>
		</textarea>
		<br>
		Objetivo de comunicação:
		<br>
		<textarea id="objetivo" name="objetivo">
<?php echo $briefing['objetivo']; ?>
		</textarea>
		<br>
		Público-alvo:
		<br>
		<textarea id="publico" name="publico">
<?php echo $briefing['publico']; ?>
		</textarea>
		<br />
		<br />			
		<div class="sub-title">DADOS TÉCNICOS DA DEMANDA</div>
		<br>
	Peças:
		<div id="pecas" style="background: #F4F4F4;
    padding: 20px 5px 5px 5px;
    border-width: 1px;
    border-style: solid;
    border-color: #9E9E9E">
			<span id="add_peca_item" >Adicionar +</span >
			<span id="hide_peca_item" style="display: none;" >Ocultar -</span >
			
			<div id="peca_form"  style="display: none;">
				<br />
				Descrição: 
				<input type="text" id="peca_descricao" name="peca_descricao" style="width: 80%; height: 20px;" />
				<br><br>
				<br>Quantidade: 
				<input type="text" id="peca_qtd" name="peca_qtd" style="width: 50px; height: 20px;" />
				
				Formato:
				<input type="text" id="peca_formato" name="peca_formato" style="width: 150px; height: 20px;" />
				
				Data de entrega: <input type="text" class="datepicker"  id="peca_data_entrega" name="peca_data_entrega" style="width: 80px; height: 20px; text-align: center;" />

				Prioridade:<input type="text" id="peca_prioridade" name="peca_prioridade" style="width: 30px; height: 20px; text-align: center;" />
				<br><br>
				<a class="bt" id="salvar_peca">Salvar peça</a>
				
			</div>
			<br><br>
			<div id="pecas_lista">
				<?php
				$html="";
				$lista_peca = $brief->get_peca($_GET['id'] );
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
							Descrição: ".utf8_decode($peca['peca_descricao'])."<br>
							</td>
						</tr>
						<tr>
							<td width='50' id='linha_peca_qtd-{$peca['id']}'> Qtd: {$peca['peca_qtd']}</td>
							<td width='200' id='linha_peca_formato-{$peca['id']}' >Formato: ".utf8_decode($peca['peca_formato'])." </td>
							<td width='250' id='linha_peca_data-{$peca['id']}'>Data entrega: {$brief->convert_data_bd_to_human($peca['peca_data_entrega'])}</td>
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
				echo $html;
				}
	?>
			
			</div>
		</div>
		

	


		<br>
		<br>
		Materiais e acabamentos:
		<textarea id="demanda_materiais" name="demanda_materiais">
			<?php echo $briefing['demanda_materiais'];?>
		</textarea>
		<br>
		<br>
		Modo de finalização:
		<textarea id="demanda_finalizacao" name="demanda_finalizacao">
			<?php echo $briefing['demanda_finalizacao'];?>
		</textarea>
		
		<br>
		<br>
		Local do arquivo:
		<input id="demanda_local" type="text" name="demanda_local" value="<?php if($briefing['demanda_local']==''){ echo  '- Onde deve ser postado o arquivo.*. (*Pedir informações à gráfica antes do começo do trabalho. )'; }else{ echo $briefing['demanda_local'];} ?>"/>
		<br />
		<br />
	<div class="sub-title">RECOMENDAÇÕES</div>
		<br>
		Referências:
		<div id="referencias">
		<a id="add_referencia_item" >Adicionar +</a >
		<a id="hide_referencia_item"  style="display: none;">Ocultar -</a >
		<br><br>
		
		<br><br><br>
		<table width= '100%' id="opcoes_referencia">
			<tr id="opcoes_referencias">
				<td width="100"> Fonte: </td>
				<td >
					Url <input name="recomendacoes_referencias_fonte" class="recomendacoes_referencias_tipo" id="recomendacoes_referencias_radios_url" type="radio" value="1" style="width: 20px; height: 20px;  ">    
					Arquivo <input name="recomendacoes_referencias_fonte" class="recomendacoes_referencias_tipo" id="recomendacoes_referencias_radios_file" type="radio" value="2" style="width: 20px; height: 20px;  ">
					
				</td>
			</tr>
			
			<tr id="tr_referencias_text">
				<td colspan="2">
					<table width="100%">
						<tr><td colspan="2" height="10"></td></tr>
						<tr>
							<td width = "70">Nome :</td>
							<td><input type="text" name="recomendacoes_nome" id="recomendacoes_referencias_nome"><br><br></td>
						</tr>
						<tr>
							<td>Url :</td>
							<td><input type="text" name="recomendacoes_referencias" class="recomendacoes_referencias" id="recomendacoes_referencias_url"></td>
						</tr>
						<tr>
							<td>
							<a  class="bt" id="salvar_referencia" >Salvar</a></td>
							<td></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2"  id="tr_referencias_file" >
					<br>
					<iframe id="file_upload_iframe" src="form_referencia_file.php?briefing_id=<?php echo $_GET['id'];?>" style="width:700px; border: 0px !important;"></iframe>
				</td>
			</tr>
		</table>
		<div id="exibe_referencias">
			
		<?php // echo $briefing['recomendacoes_referencias']; ?>
		</div>
		</div>
		
		<br />
		<br />
		
		Objeçoes:
		<textarea id="recomendacoes_objecoes" name="recomendacoes_objecoes">
		<?php echo $briefing['recomendacoes_objecoes']; ?>
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
				<table style="widht: 100%;">
					<thead>
						<tr>
							<th>Atividade</th>
							<th align="center" width="60">Inicio</th>
							<th align="center" width="60">Fim</th>
							<th align="center" width="60">Editar</th>
							<th align="center" width="60">Excluir</th>
						</tr>
					</thead>
					<? foreach($cronograma as $etapa):?>
					<tr id="linha-cronograma-<? echo $etapa['id'];?>" >
						<td id="ativ-<? echo $etapa['id']; ?>"><? echo utf8_decode($etapa['atividade']);?></td>
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
		<br />
		<br />
		<input type="submit" value="Salvar" class="bt" style="width: 150px;" />
	</form>			
</div> <!--FIM corpo -->
<div id="dialog_mensagem" ></div>
<? include('../template/footer.php'); ?>
<? unset($_SESSION['msg']); ?>


