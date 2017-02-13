<?php
/**
 * Form lista
 * @author		Daniel Soares Meurer
 * Formulario com lista de usuarios
 */
include("../template/header.php");
if(empty($_SESSION)){ header('location: ../login/form_login.php');}

if($_SESSION['tipo']!=='1'){
	exit("Acesso não autorizado.");
}
?>

<div id="corpo" >
<span id="title-page">Lista de Usuários</span>
<br>
<br>
<?	
require_once("../classes/usuarios.php");

$class_usuarios= new usuarios();
$usuarios=$class_usuarios->listar();
if($_SESSION['tipo']!=='1'){
	exit('wdededde');
}
?>
<a class="bt" href="form_create.php">+ Novo usuário</a>

<div id="lista">
	 <table>
		<thead>
			<tr align="center">
				<th >Nome</th>
				<th >Login</th>
				<th width="50">Editar</th>
				<th width="50">Excluir</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			if($usuarios){
			if(is_array($usuarios)){
			foreach($usuarios as $key => $usuario){ ?>
			<tr>
				<td><?php echo $usuario['nome']; ?></td>
				<td><?php echo $usuario['login']; ?></td>
				<td>
					<a class="bt" href="form_edita.php?id=<?php echo $usuario['id']; ?>">Editar</a>
				</td>
				<td>
					<a  class="bt" href="excluir.php?id=<?php echo $usuario['id']; ?>">Excluir</a>
				</td>
			</tr>
			<?php } }
				}
			?>
		</tbody>
	</table>
</body>
</html>
