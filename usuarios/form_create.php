<?
$titulo="Novo Usuário";
include("../template/header.php");

	$usuario = $user->pega_usuario_login($_SESSION['login']);
	
	if($_SESSION['tipo']!=='1'){
		exit("Acesso não autorizado.");
	}
//var_dump($_SESSION);
?>

<div id="corpo">
	<div id="breadcrumb" >
		<a href="../briefing/form_lista.php" > Início - Briefing:Lista</a> 	> Briefing:Criar
	</div>
	<br />
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

	<form action="criar_usuario.php" method="post">
		<div id="titulo"> NOVO USUÁRIO </div>
		
		<br />
		Nome: 
		<br />
		<input type="text" name="nome" value="<? if(isset($_SESSION['values']['nome'])){ echo $_SESSION['values']['nome'];}?>" />
		<? if(isset($_SESSION['msg']['error']['nome'])){
			echo '<span style="color:#D20000;">'.$_SESSION['msg']['error']['nome'].'</span>';
		}?>
		<br />
		<br />
		Login: 
		<br />
		<input type="text" name="login" value="<? if(isset($_SESSION['values']['login'])){ echo $_SESSION['values']['login'];}?>" />
		<? if(isset($_SESSION['msg']['error']['login'])){
			echo '<span style="color:#D20000;">'.$_SESSION['msg']['error']['login'].'</span>';
		}?>
		<br />
		<br />
		<label for="email">E-mail</label>
		<br />
		<input type="text" name="email" maxlength="100" value="<? if(isset($_SESSION['values']['email'])){ echo $_SESSION['values']['email'];}?>"/>
		<? if(isset($_SESSION['msg']['error']['email'])){
			echo '<span style="color:#D20000;">'.$_SESSION['msg']['error']['email'].'</span>';
		}?>
		<br />
		<br />
		Senha: 
		<br />
		<input type="password" maxlength="30" name="senha" id="senha" style="width: 160px; font-size: 30px;"  value="<? if(isset($_SESSION['values']['senha'])){ echo $_SESSION['values']['senha'];}?>" /> 
		<? if(isset($_SESSION['msg']['error']['senha'])){
			echo '<span style="color:#D20000;">'.$_SESSION['msg']['error']['senha'].'</span>';
		}?>
		<br /><br />
		<label for="conf_new_senha">Confirmar nova senha:</label>
		<br />
		<input type="password" maxlength="30" name="conf_senha" id="conf_senha" style="width: 160px; font-size: 30px;"  value="<? if(isset($_SESSION['values']['conf_senha'])){ echo $_SESSION['values']['conf_senha'];}?>" /> 
		<? if(isset($_SESSION['msg']['error']['conf_senha'])){?>
		<br />
		<br />
		<? echo "<span style='color: #B00000' >{$_SESSION['msg']['error']['conf_senha']}</span>"; ?>
		<?}?>
		<br />
		<br />
		<input type="submit" value="Salvar" class="bt" style="width: 120px;" />
	</form>
	<?	unset($_SESSION['msg']);
		unset($_SESSION['values']);
	?>
</div> <!--FIM corpo -->
<?php require_once("../template/footer.php"); ?>
