<?
/**
 * Login
 *
 * @package		Login
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
  */
Class Login{
	
	/**
	* __construct()
	* constroi a classe, faz include de classes necessárias e pega instancia da conexão com BD
	* inicia sessao
	*/
	function __construct(){
		setlocale(LC_ALL, 'ptb', 'portuguese-brazil', 'pt-br', 'bra', 'brazil');
		date_default_timezone_set('America/Sao_Paulo');
		require_once('../system/database.php');
		$pdo= new Database();
		$this->db=$pdo->getInstance();
		session_start();
	}

	/**
	 * Login
	 * Faz autenticação do usuario e redirecionamemto conforme resultado
	 * @param STRING $user, $senha
	 * return void
	 */	
	function login($user=false, $senha=false){
		if(!empty($_SESSION)){
			header('Location: ../briefing/form_lista.php');
		}
		else{
			//var_dump($_SESSION);
			//if(!$user or !$senha){ return FALSE;}
			$logado=$this->verifica_login($user, md5($senha, 'xyzhh12k34358g'));
			//var_dump($logado);
			if($logado){
				//var_dump($logado); exit(0);
				//$_SESSION['id']=$logado['id'];
				$_SESSION['nome_usuario']= $logado['nome'];
				$_SESSION['login']= $logado['login'];
				$_SESSION['tipo']= $logado['tipo'];
				header('Location: ../briefing/form_lista.php');
				//exit( 'logou');
			}
			else{
				header('Location: form_login.php?erro=true');
			}
		}
		exit('????');
	}

	/**
	 * Logout
	 * Destroi sessão e redireciona para formulario de login
	 * @param  STRING $user, $senha
	 * return void
	 */		
	function logout(){
		session_destroy();
		header('Location: form_login.php');
	}

	/**
	 * Verifica_login
	 * Verifica se login e senha estão corretos
	 * @param void
	 * return object $query
	 */			
	private function verifica_login($user=false, $senha=false){
		if(!$user or !$senha){return FALSE;}
		if($this->validaEmail($user)){
			$sql= "SELECT * FROM usuarios 
				WHERE email = '{$user}'	AND senha= '{$senha}'";
		}
		else{
		$sql= "SELECT * FROM usuarios 
				WHERE login='{$user}'	AND senha= '{$senha}'";
		}
		//var_dump($sql);
		$query=$this->db->query($sql); 
		$logado = $query->fetch(PDO::FETCH_ASSOC);
		//$errorcode = $this->db->errorCode();
		//echo $errorcode; 
		return $logado;
	}
	
	
	
	public 	function validaEmail($email) {
		$conta = "^[a-zA-Z0-9\._-]+@";
		$domino = "[a-zA-Z0-9\._-]+.";
		$extensao = "([a-zA-Z]{2,4})$";
		$pattern = $conta.$domino.$extensao;
		if (ereg($pattern, $email))
			return true;
			else
			return false;
	}
}

