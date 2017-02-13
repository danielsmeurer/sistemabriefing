<?
Class usuarios{
	public $user='';
	function __construct(){
		$this->user['tipo']= 2;
		setlocale(LC_ALL, 'ptb', 'portuguese-brazil', 'pt-br', 'bra', 'brazil');
		date_default_timezone_set('America/Sao_Paulo');
		require_once('../system/database.php');
		$pdo= new Database();
		$this->db=$pdo->getInstance();
	}
	
	function criar($usuario){
		$this->user = $usuario;
		$msg=false;
		if($this->user['nome']==''){ 
			$msg['error']['nome']="O preenchimento do campo Nome � obrigat�rio.";
		}
		
		if($this->user['login']==''){ 
			$msg['error']['login']="O preenchimento do campo Login � obrigat�rio.";
		}
		elseif(strlen($this->user['login'])<5){
			$msg['error']['login']="O Login deve ter pelo menos 5 digitos.";
		}
		else{
			$login_existe=$this->pega_usuario_login($this->user['login']);
			if($login_existe){ $msg['error']['login']="Este login j� existe em nosso cadastro";}
		}

		if($this->user['email']==''){
			$msg['error']['email']="O preenchimento do campo E-mail � obrigat�rio.";
		}
		elseif(!filter_var($this->user['email'], FILTER_VALIDATE_EMAIL)){
			$msg['error']['email']="Digite um email v�lido.";			
		}		

		if($this->user['senha']==''){
			$msg['error']['senha']="O preenchimento do campo Senha � obrigat�rio.";
		}
		elseif(strlen($this->user['senha'])<5){
			$msg['error']['senha']="A Senha deve ter pelo menos 5 digitos.";
		}
		
		if($this->user['conf_senha']!==$this->user['senha']){
			$msg['error']['conf_senha']="O confirma��o de Senha deve ser igual ao campo Senha.";
		}
		
		if($msg['error']){
			$msg['error']['main']= 'Erro no prenchimento dos campos do formul�rio. <br> Verifique se os campos foram preenchidos corretamente.';
			return $msg;
		}
		
		$this->user['nome'] = $usuario['nome'];
		$this->user['login']= $usuario['login'];
		$this->user['senha']= md5($usuario['senha'], 'xyzhh12k34358g');
		$this->user['tipo']= 2;
		//var_dump($this->user); exit(0);
		/*$tipo = $this->pega_usuario_categoria($this->user['tipo']);
		if($tipo); exit(0);*/
		$sql="INSERT INTO usuarios(
				nome, 
				email, 
				login, 
				senha, 
				tipo
			) 
			VALUES( 
				'{$this->user['nome']}', 
				'{$this->user['email']}', 
				'{$this->user['login']}',
				'{$this->user['senha']}', 
				'{$this->user['tipo']}'
			)";
		
		if($this->db->query($sql)){
			$msg['sucesso'] = "Usu�rio cadastrado com sucesso.";
			return $msg;
		}
		else{
			$errorcode = $this->db->errorCode();
			echo $errorcode;
			exit(0);
		}
	}
	
	function listar($id=false){
		if($id){
			$where= 'where id='.$id;
			}else{
				$where='';
			}
		$sql="SELECT *FROM usuarios {$where}";
		//var_dump($sql); exit(0);
		$query=$this->db->query($sql); 
		
		if($id){
			$user=$query->fetch(PDO::FETCH_ASSOC);
			if($user){
				
				return $user;
			}
			else{
				return FALSE;
			}
		}
		else{
			$users=$query->fetchAll(PDO::FETCH_ASSOC);
			if($users){
				//var_dump($users); exit(0);
				return $users;
			}
			else{
				return FALSE;
			}
		}
	}
	
	function editar($usuario=false){
		$usuario['erro']=FALSE;
		$usuario['sucesso']=FALSE;
		if(!$usuario){ return FALSE; }
		if(!isset($usuario['nome']) or empty($usuario['nome']) ){
			$usuario['erro']['nome']= "O campo Nome � obrigat�rio";
		}
		if(!isset($usuario['login']) or empty($usuario['login']) ){
			$usuario['erro']['login']= "O campo Login � obrigat�rio";
		}
		
		if(isset($usuario['new_senha'])){
			if(!($usuario['new_senha']) or (empty($usuario['new_senha'])) ){
				$usuario['erro']['new_senha']= "O campo Nova senha � obrigat�rio";
			}
			elseif(strlen($usuario['new_senha'])<5){
				$usuario['erro']['new_senha']= "O campo Nova senha deve ter no minimo 5 digitos.";
			}
			
			if(!($usuario['conf_new_senha']) or (empty($usuario['conf_new_senha'])) ){
				$usuario['erro']['conf_new_senha']= "O campo Confirmar de nova senha � obrigat�rio";
			}
			if($usuario['new_senha']!='' and $usuario['conf_new_senha']!='' ){
				if($usuario['new_senha']!=$usuario['conf_new_senha']){
					$usuario['erro']['conf_new_senha']= "O campo Nova senha e Confirmar nova senha devem ser iguais";
				}
				else{
					$usuario['senha']= md5($usuario['new_senha'],  'xyzhh12k34358g');
				}
			}
			
		}
		
		if($usuario['erro']){
			//var_dump($usuario['erro']); exit(0);
			return $usuario;
		}
		else{
			$query = $this->query_editar($usuario);
			//var_dump($query); exit(0);
			if($query){
				$usuario['sucesso']=TRUE;
				return $usuario;
			}
			else{
				return FALSE;
			}
		}
		
		return FALSE;
	}
	

	function query_editar($dados=false){
		if(!$dados){ return FALSE;}
		if(isset($dados['senha'])){
			$senha = ", senha = '{$dados['senha']}' "; 
		}
		else{
			$senha = '';
		}
		$data = date('Y-m-d H:i:s');
		$sql = "UPDATE usuarios SET 
			nome = '{$dados['nome']}',
			login = '{$dados['login']}'
			{$senha}
            WHERE id ='{$dados['id']}'";
           
		if($this->db->query($sql)){
			return $this->db->query($sql);
		}
		else{
			//echo $this->db->errorCode();
			//$errorcode = $this->db->errorCode();
			return FALSE;
		}
		
	}
	
	
	
	function excluir($id){
		$sql='DELETE FROM usuarios WHERE id = '.$id;
		$this->db->query($sql);
		if($this->db->query($sql)){
			return TRUE;
		}
		else{
			return FALSE;
			//echo $this->db->errorCode();
			//$errorcode = $this->db->errorCode();
		}
	}
	
	
	function pega_usuario_categoria($tipo){
		$sql='SELECT * FROM usuarios  WHERE tipo = '.$tipo;
		$query=$this->db->query($sql); 
		if($query->rowCount()>0){
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		return FALSE;
	}
	
	function pega_usuario_id($id){
		$sql='SELECT *FROM usuarios  WHERE id = '.$id;
		$query=$this->db->query($sql); 
		
		if($query){
			if($query->rowCount()>0){
				return $query->fetch(PDO::FETCH_ASSOC);
				
			}
		}
		return FALSE; 
	}
	
	function pega_usuario_login($login){
		$sql='SELECT *FROM usuarios  WHERE login = "'.$login.'"';
		$query=$this->db->query($sql); 
		if($query->rowCount()>0){
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		return FALSE;
	}
	
	function ajax_trocar_senha($senhas){
		if(!isset($senhas['new_senha'])){return FALSE;}
		if($senhas['new_senha']===$senhas['conf_new_senha']){
				var_dump($senhas); 
				exit(0);
		}
		else{
				exit('dd');
		}
		return FALSE;	
	}
}
