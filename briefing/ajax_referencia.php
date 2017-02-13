

<?php
//echo alert('ddddddddddddd');
include("../classes/briefing.php");
$briefing =	new Briefing();
//var_dump($_POST); exit('ddd');
if(isset($_POST['evento']) and ($_POST['evento']==='excluir')){
	$briefing->excluir_referencia($_POST['id']);
	exit(0);
}
elseif(!isset($_POST['briefing_id']) ){
	exit('<h3> acessso não autorizado</h3>');
}
else{

//var_dump($_POST, $_FILES); exit();
//exit('ddd888');
if(isset($_POST['tipo']) and $_POST['tipo']='url'){
	//exit('dddd555');
	//$briefing =	new Briefing();
	//var_dump($briefing); exit('4');
	//$briefing_salvo = $briefing->salvar_referencias($_POST, $_POST['briefing_id']);
	//var_dump($briefing_salvo); exit('s');
	if($briefing->salvar_referencias($_POST, $_POST['briefing_id'])){
		
		echo "<script>alert('Referência salva.')</script>";
		exit(0);
	}
	else{
		exit('nao salvou');
		echo "<script>alert('Não foi possivel salvar.')</script>";
		exit(0);
	}
	exit(0);
}
elseif(!empty($_FILES)){
	$briefing =	new Briefing();
	$salvar_briefing = $briefing->salvar_referencias($_FILES['referencias'], $_POST['briefing_id']);
	//var_dump($salvar_briefing);
	if($salvar_briefing){
		echo '<span style="color:#A52A2A" >'.$salvar_briefing.'</span>';
		//exit('não salvou');
		echo "<br><a href='form_referencia_file.php?briefing_id={$_POST['briefing_id']}' class='bt'>Suba outro arquivo</a>";
	}
	else{
		echo '<span style="color:#127F12" >Arquivo Salvo </span><br><br>';
		echo "<a href='form_referencia_file.php?briefing_id={$_POST['briefing_id']}' class='bt'>Subir outro arquivo</a>";
	}
}
else{
echo 'falhou';
echo '<span style="color:#A52A2A" >Falhou</span>';
echo "<br><a href='form_referencia_file.php?briefing_id={$_POST['briefing_id']}' class='bt'>Tente novamente</a>";
}
}
?>
