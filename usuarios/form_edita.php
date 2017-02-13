<?
$titulo="Usuário: Editar";
include("../template/header.php");
$user = new usuarios();
//var_dump($_SESSION);
if(isset($_GET['id'])){
	$usuario = $user->pega_usuario_id($_GET['id']);
	if($_SESSION['tipo']!=='1'){
		//var_dump($usuario['login'], $_SESSION['login']);
		if($usuario['login']!==$_SESSION['login']){
			exit("Acesso não autorizado.");
		}
	}
}
else{
	$usuario = $user->pega_usuario_login($_SESSION['login']);
}

if(isset($_POST['nome'])){ 
//	var_dump($_POST); exit(0); 
}
?>
<br>

<div id="corpo">
	<div id="breadcrumb" >
		<a href="../briefing/form_lista.php" > Início - Briefing:Lista</a> > Usuario: Editar;
	</div>
	<br />
	<br />
	<? if(isset($retorno['erro'])and ($retorno['erro'])){?>
		<div id="error">
			<div style="float: left;"><img src="../img/error.png" /></div>
			<div>&nbsp;&nbsp;&nbsp;Erro no prenchimento dos campos do formulário. </div>
			&nbsp;&nbsp;&nbsp;Verifique se os campos foram preenchidos corretamente. 
			<div id='fecha'>X</div>
		</div>
		<br/>
	<?}?>
	<? if(isset($retorno['sucesso']) and ($retorno['sucesso'])){?>
		<div id="sucesso">
			<div style="float: left;"><img src="../img/sucesso.png" /></div>
			<div>&nbsp;&nbsp;&nbsp;Dados alterados com sucesso. </div>
			<div id='fecha'>X</div>
		</div>
		<br/>
	<?}?>
	<form action="editar_usuario.php" method="post" id="form_usuario">
		<input name="id" type="hidden" value="<? echo $usuario['id'];?>"/>
		<div id="titulo"><? echo $titulo;?> </div>
		<br />
		<label for="nome" >Nome: </label>
		<input type="text" name="nome"  id="nome" value="<? echo $usuario['nome']; ?>" />
		<? if(isset($retorno['erro']['nome'])){?>
		<br />
		<? echo "<span style='color: #B00000' >{$retorno['erro']['nome']}</span>"; ?>
		<?}?>
		<br />
		<br />
		<label for="login">Login:</label>
		<input type="text" name="login" id="login" value="<? echo $usuario['login']; ?>" />
		<? if(isset($retorno['erro']['login'])){?>
		<br />
		<? echo "<span style='color: #B00000' >{$retorno['erro']['login']}</span>"; ?>
		<?}?>
		<br />
		<br />
		<? if(isset($_POST['new_senha'])){
				$bt_troca_senha='style="display: none;"';
				$bt_ocultar_troca_senha='';
			}
			else{
				$bt_troca_senha='';
				$bt_ocultar_troca_senha='style="display: none;"';;
			}
		?>
		<a id="bt_troca_senha" href="#" class="bt"  <? echo $bt_troca_senha; ?> >Alterar Senha</a>
		
		<a id="bt_ocultar_troca_senha" href="#" class="bt"  <? echo $bt_ocultar_troca_senha; ?> >Ocultar troca de senha</a>
		<br/>
		<br/>
		<? if((isset($_POST['new_senha'])) and (!empty($_POST['new_senha']))){?>
			<div id="alterar_senha" style="width: 400px; ">
				<label for="new_senha">Nova senha:</label>
				<input type="password" maxlength="10" name="new_senha"  id="new_senha" style="width: 160px; font-size: 20px; height: 20px;"  /> 
				<? if(isset($retorno['erro']['new_senha'])){?>
				<br />
				<? echo "<span style='color: #B00000' >{$retorno['erro']['new_senha']}</span>"; ?>
				<?}?>
				<br />
				<br />
				<label for="conf_new_senha">Confirmar nova senha:</label>
				<input type="password" maxlength="10" name="conf_new_senha" id="conf_new_senha" style="width: 160px; height: 20px; font-size: 20px;" /> 
				<? if(isset($retorno['erro']['conf_new_senha'])){?>
				<br />
				<? echo "<span style='color: #B00000' >{$retorno['erro']['conf_new_senha']}</span>"; ?>
				<?}?>
				<br />
			</div> 
		<?}
		else{?>
			<div id="alterar_senha" style="width: 400px; display: none;"> </div> 
		<?}?>
		<br /> 
		<br /> 
		<input type="submit" value="Salvar" class="bt" style="width: 120px;" />
	</form>
</div> 
<!--FIM corpo -->

<?php include_once("../template/footer.php"); ?>
