<?php
/**
 * Criar usuario
 * @author		Daniel Soares Meurer
  * Recebe variavel array POST e chama metodo para criar novo usuario passando POST como parametro
  * 	cria variaves de sessão com retorno recebido
  * 	redireciona de volta pagina de origem 
 */
require_once("../classes/usuarios.php");
$usuario = new usuarios();

$retorno=$usuario->criar($_POST);
session_start();
$_SESSION['msg']=$retorno;
$_SESSION['values']=$_POST;
header('location: form_create.php');

