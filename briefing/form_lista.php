<?php
/**
 * Form lista
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * Tabela com briefings cadastrados
 */
 $titulo="Lista de Briefings";
 
include("../template/header.php");

 //exit('pagina lista 2');
?>

<br />
<div id="corpo" >
<?php
 require_once('../classes/briefing.php');
 $brief= new briefing();
 $briefings=$brief->form_listar();
 //$user= new usuarios();
  $user->pega_usuario_id(1);
  
 if(!$briefings){
	echo "Nenhum briefing cadastrado.";
 }
 else{
	 $i=0; 
	  ?>
<span id="title-page"><?php echo $titulo;?></span>
	<br />
	<br />
<a href="../briefing/form_create.php" class="bt">+ Criar novo Briefing</a>
<div id="paginacao" style="text-align: center;"> <?php echo $briefings['pagination'] ; ?> </div>
<div id="lista">
	
	 <table>
		 <thead>
			<tr align="center">
				<th width="50">Nº</th>
				<th>Titulo</th>
				<th>Nome do cliente</th>
				<th>Cadastrado por</th>
				<th>Data Cadastro</th>
				<th>Data alteração</th>
				<th>PDF</th>
				<th>Editar</th>
				<th>Excluir</th>
			</tr>
		 </thead>
		 <tbody>
		<?php
		foreach($briefings['lista'] as $briefing):
			//$i++; ?>
			<tr id="<?php echo $briefing['id'];?>">
				<td >
					<button value="<?php echo $briefing['id'];?>" class="exibe"> 
						<?php echo  str_pad($briefing['id'], 4, "0", STR_PAD_LEFT);?> 
					</button> 
				</td>
				<td><?php echo  $briefing['titulo'];?></td>
				<td> <?php echo $briefing['nome_cliente'];?> </td>
				<td> <?php 
						$userdata=$user->pega_usuario_id($briefing['usuario_id']);
						//var_dump($userdata);
						if($userdata){echo $userdata['nome'];} ?> </td>
				<td> <?php echo $brief->convert_data_bd_to_human($briefing['data_criado']) ;?> </td>
				<td> <?php echo $brief->convert_data_bd_to_human($briefing['ultima_alteracao']) ;?> </td>
				<td> <a href="print_briefing.php?id=<?php echo $briefing['id'];?>" target="_blank" class="bt">PDF</a></td>
				<td width="80"> <a class="bt" href="form_edita.php?id=<?php echo $briefing['id'];?>" > Editar</a> </td>
				<td width="80"> <button class="excluir" value="<?php echo $briefing['id'];?>" >Excluir</button></td>
			</tr>
		<?php 
		endforeach; ?>
		</tbody>
	</table>
	<div id="paginacao2" style="text-align: center;"> <? echo $briefings['pagination'] ; ?> </div>
	</div>
	<br>
	
	

	<div id="janela_exibe" style="display:none;" title="Visualização de Briefieng" ></div>
	<div id="janela_exclui" style="display:none;" title="Confirma Exclusão?" ></div>
<?php } ?>
</div>
<!--FIM corpo -->
<?php include("../template/footer.php"); ?>
 

