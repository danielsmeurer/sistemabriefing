<?php
/**
 * Editar Briefing
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
 * Recebe array POST via ajax e chama metodo para edição de briefing  passando $POST['id'] como parametro
 */
session_start();
 require_once('../classes/briefing.php'); 
	$brief= new briefing();
	$editar= $brief->editar();
	if(!$editar){
		exit("Acesso não autorizado.");
	}
	$_SESSION['msg']=$editar;
	//header( 'location:form_edita.php?id='.$_POST['id']);
	if(isset($_SESSION['msg']['sucesso'])){
		echo '<script language= "JavaScript"> alert("Briefing editado com sucesso.")</script>';
		unset($_SESSION['msg']);
		echo '
		redirecionando ...
		<script language= "JavaScript"> 
		setTimeout(myFunction, 3000)
		function myFunction() {
			location.href=" form_lista.php" 
		}
		</script>';
		exit();
	}
	else{
		echo '<script language= "JavaScript"> location.href=" form_edita.php?id='.$_POST['id'].'" </script>';
	}
 ?>

	
