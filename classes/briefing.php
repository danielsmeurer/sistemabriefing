<?php
/**
 * Briefing
 *
 * @package		Briefing
 * @author		Daniel Soares Meurer
 * @copyright	Copyright (c) 2014, Daniel Soares Meurer (danielsmeurer@gmail.com) 
  */
Class Briefing{
	/*
	 * var ARRAY dados publica
	 */
	public $dados= '';
	
	/*
	 * var ARRAY db publica
	 * pega instacia da classe data_base
	 */
	//public $db=false;
	/**
	 * __construct()
	 * constroi a classe, faz include de classes necessárias e pega instancia da conexão com BD
	 */
	function __construct(){
		setlocale(LC_ALL, 'ptb', 'portuguese-brazil', 'pt-br', 'bra', 'brazil');
		date_default_timezone_set('America/Sao_Paulo');
		require_once('../system/database.php');
		require_once('../loader.php');
		$pdo= new Database();
		$this->db=$pdo->getInstance();
		
	}
	
	/**
	 * Create
	 * Cria um novo briefing
	 * Insere dados do array $_POST no banco de dados
	 * @param void
	 * retorna TRUE se inserção for feita no BD e FALSE caso não aconteça algum erro 
	 */
	function create(){
		session_start();
		require_once('usuarios.php');
		$user = new usuarios();
		
		if($_POST['titulo']!=''){ $briefing['titulo']=$_POST['titulo'];}
		if($_POST['nome_cliente']!=''){ $briefing['nome_cliente']=$_POST['nome_cliente'];}
		$briefing['info_cliente'] = '';
		$briefing['publico']='';
		$briefing['demanda']='';
		$briefing['demanda_pecas']='';
		$briefing['demanda_formato']='';
		$briefing['demanda_materiais']='';
		$briefing['demanda_finalizacao']='';
		$briefing['demanda_local']='';
		$briefing['objetivo' ]='';		
		$briefing['recomendacoes_ideia']='';
		$briefing['recomendacoes_referencias']='';
		$briefing['recomendacoes_objecoes']='';
		$usuario=$user->pega_usuario_login($_SESSION['login']);
		$briefing['usuario_id']=$usuario['id'];
		$briefing['data_criado']=date('Y-m-d H:i:s');
		$briefing['alterado_em']=$briefing['data_criado'];
		

		$sql="INSERT INTO briefing(
				titulo, nome_cliente , 
				info_cliente, 
				publico, 
				demanda,
				demanda_pecas, 
				demanda_formato, 
				demanda_materiais, 
				demanda_finalizacao, 
				demanda_local,  
				objetivo, 
				usuario_id ,
				recomendacoes_ideia,
				recomendacoes_referencias,
				recomendacoes_objecoes,
				data_criado ,
				ultima_alteracao 
			) values(
				'{$briefing['titulo']}',
				'{$briefing['nome_cliente']}',
				'{$briefing['info_cliente']}',
				'{$briefing['publico']}',
				'{$briefing['demanda']}',
				'{$briefing['demanda_pecas']}',
				'{$briefing['demanda_formato']}',
				'{$briefing['demanda_materiais']}',
				'{$briefing['demanda_finalizacao']}',
				'{$briefing['demanda_local']}',
				'{$briefing['objetivo' ]}',
				'{$briefing['usuario_id']}' ,
				'{$briefing['recomendacoes_ideia']}',
				'{$briefing['recomendacoes_referencias']}',
				'{$briefing['recomendacoes_objecoes']}',
				'{$briefing['data_criado']}',
				'{$briefing['alterado_em']}'
				
			)";
		
		if($this->db->query($sql)){
			$id= $this->db->lastInsertId(); 
			return $id;
		}
		else{
			/*$errorcode = $this->db->errorCode();
			echo $errorcode;*/
			return FALSE;
		}
	}
	
	/**
	 * Listar
	 * Lista todos o briefing Cadastrados
	 * 
	 * @param INT $limit (optional)
	 * @param INT $offset (optional)
	 * retorna FALSE para em caso de erro em caso a consulta não traga resultados ou array de valores da consulta
	 * return array or bool FALSE
	 */
	function listar($limit=false , $offset=false ){
		if($limit){
			$limit='LIMIT '.$limit;
		} 
		else{
			$limit='';
		}
		
		if($offset){
			$offset='OFFSET '.$offset;
		} 
		else{
			$offset='';
		}
		$sql="SELECT * FROM briefing  ORDER BY id DESC {$limit} {$offset}";
		$query=$this->db->query($sql); 
		$briefs=$query->fetchAll(PDO::FETCH_ASSOC);
		if($briefs){
			return $briefs;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Form_listar
	 * Lista briefings de uma pagina para formulario
	 * 
	 * @param INT $page (optional)
	 * return array $briefing com informações de briefings da pagina
	 */	
	function form_listar($page=1){
		if(isset($_GET['page'])){$page=$_GET['page']; }
		$total=$this->get_total_brief();
		$limit=10;
		$offset=0+(($limit*$page)-$limit);
		
		$total_pg=(int)($total/$limit);
		if($total_pg<($total/$limit)){
			$briefing['total']=$total_pg+1;
		}
		else{
			$briefing['total']=$total_pg;
		}
		$briefing['lista'] = $this->listar($limit,$offset);
		$briefing['pagination'] = $this->pagination($page,$briefing['total']);
		return $briefing;
	}
	
	
	/**
	 * Editar
	 * Edita briefing passado via post
	 * 
	 * @param void
	 * return array com mesnsagens de validação 
	 */	
	 function editar(){
		$msg = false;
	/*	$user= new usuarios();
		session_start();
		$user_data=$user->pega_usuario_login($_SESSION['login']); */
		//var_dump($user_data['id']);
		if(!isset($_POST['id']) || $_POST['id']==''){ return FALSE;}
		$data = date('Y-m-d H:i:s');
		//exit( str_replace("\r\n", "<br/>", $_POST['info_cliente']) );
		if($_POST['titulo']==""){$msg['error']['titulo'] = 'O preenchimento do campo Titulo é obrigatório.'; }
		if($_POST['nome_cliente']==""){$msg['error']['nome_cliente'] = 'O preenchimento do campo Nome do cliente é obrigatório.'; }
		$sql = "UPDATE briefing SET nome_cliente = \"".$_POST['nome_cliente']."\",
			titulo = \"".$_POST['titulo']."\", 
            info_cliente = \"".$_POST['info_cliente']."\", 
            publico = \"".$_POST['publico']."\",  
            demanda = \"".$_POST['demanda']."\",  
            demanda_pecas =\"".$_POST['demanda_pecas']."\",  
            demanda_formato =\"".$_POST['demanda_formato']."\",
            demanda_materiais =\"".$_POST['demanda_materiais']."\",
            demanda_finalizacao =\"".$_POST['demanda_finalizacao']."\",
            demanda_local =\"".$_POST['demanda_local']."\",
            objetivo = \"".$_POST['objetivo']."\",
            recomendacoes_ideia = \"".$_POST['recomendacoes_ideia']."\",
            recomendacoes_referencias = \"".$_POST['recomendacoes_referencias']."\",
            recomendacoes_objecoes = \"".$_POST['recomendacoes_objecoes']."\",
            ultima_alteracao='{$data}'
            WHERE id = \"".$_POST['id']."\"";
			//var_dump( $sql); exit(0); 
        if($msg){ 
			$msg['error']['main']='Erro no prenchimento dos campos do formulário. <br> Verifique se os campos foram preenchidos corretamente.';
			return $msg;
		}
		if($this->db->query($sql)){
			$msg['sucesso'] = 'Dados alterados com sucesso.';
			return $msg;
			
		}
		else{
			echo $this->db->errorCode();
			exit(0);
		}
	}
	
	/**
	 * GetBriefing
	 * Consulta briefing especificado de acordo com seu id
	 * 
	 * @param INT $id
	 * return array com dados consultados
	 */	
	function getBriefing($id){
		$sql='SELECT * FROM briefing WHERE id='.$id.' ORDER BY id DESC';
		$query=$this->db->query($sql); 
		$briefing=$query->fetch(PDO::FETCH_ASSOC);
		if($briefing){
			return $briefing;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Excluir
	 * Exclui briefing conforme id informado
	 * 
	 * @param INT $id
	 * return bool
	 */
	private function excluir($id=false){
		if(!$id){return FALSE;}
		
		$pecas = $this->get_peca($id);
		if($pecas){
			foreach($pecas as $peca){
				if(!$this->excluir_peca($peca['id'])){ return FALSE;}
			}
		}
		$cronogramas = $this->get_cronograma($id);
		//var_dump($cronogramas); exit('55');
		if($cronogramas){
			foreach($cronogramas as	$cronograma){
				if(!$this->excluir_cronograma($cronograma['id'])){ return FALSE;}
			}
		}
		
		$referencias = $this->get_referencias($id);
		//var_dump($referencias); exit('55');
		if($referencias){
			foreach($referencias as	$referencia){
				if(!$this->excluir_referencia($referencia['id'])){ return FALSE;}
			}
		}
		
		$sql='DELETE FROM briefing WHERE id='.$id;
		
		
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

	/**
	 * Ajax_edita
	 * Edita campos fronecidos do briefing
	 * 
	 * @param INT $id 
	 * @param STRING $campo
	 * @param$ mixed valor
	 * return void
	 */	
	function ajax_edita($id=false, $campo=false, $valor=false){
		$data = date('Y-m-d H:i:s');
		$sql = "UPDATE briefing SET {$campo} = '{$valor}', ultima_alteracao='{$data}'  WHERE id =".$id; 
		
		$this->db->query($sql); 
	}
	
	/**
	 * Ajax_excluir
	 * Exclui briefing conforme id informado via ajax
	 * 
	 * @param INT $id 
	 * return bool
	 */	
	function ajax_excluir($id=false){
		if(!$id){return FALSE;}
		if($this->excluir($id)){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	/**
	 * Get_total_brief
	 * Consulta quantos briefings estão cadastros ou em um intervalo informado
	 * 
	 * @param INT (optional)$limit,  (optional)$offset
	 * return INT total
	 */	
	private function get_total_brief($limit=false , $offset=false ){
		if($limit){
			$limit='LIMIT '.$limit;
		} 
		else{
			$limit='';
		}
		
		if($offset){
			$offset='OFFSET '.$offset;
		} 
		else{
			$offset='';
		}
		$sql="SELECT * FROM briefing {$limit} {$offset}";
		$query=$this->db->query($sql); 
		return $query->rowCount();
	}

	/**
	 * Pagination
	 * Cria paginação de briefings
	 * 
	 * @param INT $page, $total
	 * return STRING $pagination
	 */		
	function pagination($page=1,$total=1){
		$max=11;
		if($total==1){
			$proxima=1;
			$anterior=1;
			if($total<11){
				$max=$total;
			}
		}		
		else{
			$proxima=$page+1;
			$anterior=$page-1;
			if($anterior==0){
				$anterior=1;
			}
			if($proxima>$total){
				$proxima=$total;
			}
			if($total<11){
				$max=$total;
			}
		}
		
		$pagination="<a class='bt' href='form_lista.php?page={$anterior}'>Anterior</a>";
		if($page>=1 and $page<=10 ){
			for($i=1; $i<=$max; $i++){
				if($page==$i){
					$pagination.="<strong><a class='bt' href='form_lista.php?page={$i}'  id='selecionado' >{$i}</a></strong>"; 
				}
				else{
					$pagination.="<a class='bt' href='form_lista.php?page={$i}'>{$i}</a>"; 
				}
			}
		}
		else{
			$max=(int)($max/2);
			for($i=$max; $i>=1; $i--){
				$pagina=$page-$i;
				$pagination.="<a class='bt' href='form_lista.php?page={$pagina}' id='selecionado'>{$pagina}</a>";
			}
			
			$pagination.="<strong><a class='bt' href='form_lista.php?page={$page}' id='selecionado'>{$page}</a></strong>"; 
			
			for($i=1; $i<=$max; $i++){
				$pagina=$page+$i;
				$pagination.="|{$pagina}|";
			}
		}
		$pagination.="<a class='bt' href='form_lista.php?page={$proxima}'>Proxima</a>";
		return $pagination;
	}

/**
	 * Adicionar_atividades_cronograma
	 * Adiciona novas atividades na tabela cronograma conforme id informado
	 * 
	 * @param INT $cronograma
	 * return bool
	 */	
	function adicionar_atividades_cronograma($cronograma=false){
		//if((!$briefing_id) || (!$cronograma) ){ return FALSE;}
		//var_dump($cronograma); exit(0);
		$inicio= $this->convert_data_human_to_bd($cronograma['inicio']);
		$fim =	$this->convert_data_human_to_bd($cronograma['fim']);
		$sql="INSERT INTO cronograma(
					atividade,
					inicio,
					fim,
					briefing_id
			)values(
				'{$cronograma['atividade']}',
				'{$inicio}',
				'{$fim}',
				'{$cronograma['briefing_id']}'
			)";
		$query = $this->db->query($sql);
		$count=$query->rowCount();
		if($count>0){
			return TRUE;
			
		}
		else{
			return FALSE;
			$errorcode = $this->db->errorCode();
			echo $errorcode;
			//return FALSE;
		}
	}
	
	/**
	 * Get_cronograma
	 * Consulta todos os cronogramas cadastros podendo ser filtrado pelo id do cronograma ou id do briefinfg a que pertencem
	 * 
	 * @param INT (optional)$id_briefing , (optional)$id_cronograma
	 * return array com dados consultados
	 */	
	function get_cronograma($id_briefing=false , $id_cronograma=false){
		 $where_id='';
		if(!$id_briefing){return FALSE;}
		if($id_cronograma){ $where_id = 'AND `id`='.$id_cronograma;}
		$sql = "SELECT * FROM `cronograma` WHERE `briefing_id` = ". $id_briefing.' '.$where_id." ORDER BY id DESC";
		$query=$this->db->query($sql); 
		
		$briefing= $query->fetchAll(PDO::FETCH_ASSOC);
		if($briefing){
			return $briefing;
		}
		else{
			return FALSE;
		}
	}
	
	/**
	 * Edita_cronograma
	 * edita itens de um cronograma 
	 * @param ARRAY dados
	 * return BOOL
	 */	
	function edita_cronograma($dados){
		//var_dump($dados);
		if(!isset($dados['briefing'])){return FALSE;}
		$sql =	"UPDATE `cronograma` SET"; 
		if(isset($dados['atividade']) and ($dados['atividade']) and !(empty($dados['atividade']))){
			$sql.=	"`atividade`='{$dados['atividade']}',"; 
		}
		
		if(isset($dados['inicio']) and ($dados['inicio']) and !(empty($dados['inicio']))){ 
			$inicio = $this->convert_data_human_to_bd($dados['inicio']);
			$sql.=	"`inicio`='{$inicio}',"; 
		}
		
		if(isset($dados['fim']) and ($dados['fim']) and !(empty($dados['fim']))){ 
			$fim = $this->convert_data_human_to_bd($dados['fim']);
			$sql.= "`fim`='{$fim}'"; 
		}
		
		$sql.= "WHERE `briefing_id`={$dados['briefing']} AND `id`={$dados['cronograma']}";
		
		//var_dump($sql);
		if($this->db->query($sql)){
			return TRUE;
		}
		else{
			return FALSE;
			//echo $this->db->errorCode();
			exit(0);
		}
	}

	/**
	 * Excluir_cronograma
	 * Exclui cronograma especificado por id
	 * 
	 * @param INT $id
	 * return bool
	 */		
	function excluir_cronograma($id){
		if(!$id){return FALSE;}
		$sql='DELETE FROM cronograma WHERE id='.$id;
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
	
	/**
	 * Convert_data_human_to_bd
	 * Converte data do  padrão dd/mm/aaaa para o padrão Mysql 
	 * 
	 * @param STRING $data
	 * return string com data modificada 
	 */		
	function convert_data_human_to_bd($data){
		if($data){
			$data = explode("/", $data);
			$dia = $data[0];
			$mes = $data[1];
			$ano = $data[2];
			$bd_data = $ano.'-'.$mes.'-'.$dia;
			return $bd_data;
		}
	}
	
	/**
	 * convert_data_bd_to_human
	 * Converte data do padrão Mysql para  padrão dd/mm/aaaa 
	 * 
	 * @param STRING $data
	 * return string com data modificada 
	 */
	function convert_data_bd_to_human($data){
		//var_dump($data);
		$hora=false;
		$data_hora = explode(" ", $data);
		
		if(isset($data_hora[1])){
			//var_dump($datab);
			$data =	$data_hora[0];
			$hora = $data_hora[1];
		}
		
		$data = explode("-", $data);
		$ano = $data[0];
		$mes = $data[1];
		$dia= $data[2];
		//var_dump($data);
		if($hora){		
			$human_data =  $hora.' - '.$dia.'/'.$mes.'/'.$ano;
		}
		else{
			$human_data =  $dia.'/'.$mes.'/'.$ano;
		}
		return $human_data;
	}

	/**
	 * Gera_pdf
	 * Cria um PDF de briefing conforme id passado como parametro para query em DB
	 * 
	 * @param IN $id
	 * return void
	 */
	function gera_pdf($id){
		$briefing= $this->getBriefing($id);
		$cronograma=$this->get_cronograma($id);
		$referencias = $this->get_referencias($id);
		$id_formated = str_pad($id, 4, "0", STR_PAD_LEFT);
		//var_dump($briefing); exit(0);
		$info_cliente = nl2br( $briefing['info_cliente']);
		//var_dump($id_formated , $briefing['titulo']); exit(0);
		$publico = nl2br($briefing['publico']);
		$demanda = nl2br($briefing['demanda']);
		$demanda_pecas=$briefing['demanda_pecas'];
		$demanda_formato=$briefing['demanda_formato'];
		$demanda_materiais=$briefing['demanda_materiais'];
		$demanda_finalizacao=$briefing['demanda_finalizacao'];
		$demanda_local=$briefing['demanda_local'];
		$objetivo = nl2br($briefing['objetivo']);
		$recomendacoes_ideia = nl2br($briefing['recomendacoes_ideia']);
		$recomendacoes_referencias = nl2br($briefing['recomendacoes_referencias']);
		$recomendacoes_objecoes = nl2br($briefing['recomendacoes_objecoes']);
		
		
		
		require_once("../tcpdf/tcpdf.php"); 
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Daniel');
		$pdf->SetTitle('Teste');
		$pdf->SetSubject('Teste');
		$pdf->SetFont('helvetica', '', 14);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		// add a page
		$pdf->AddPage();
		$pdf->Image('../img/logoVENTO.png', 10, 10, 50, 43, 'PNG', '#', '', true, 150, '', false, false, 0, false, false, false);

		$txt='<strong>Razão Social: Vento Comunicação Ltda.</strong>
				<br>
				CNPJ: 08.633.990/0001-07
				<br>
				Inscrição Municipal: 50963627
				<br>
				Endereço: Rua Independência 1159/303
				<br>
				Porto Alegre/RS
				<br>
				CEP: 90035-073
				<br>
				Fone: (51) 3013.3833';
		$txt= utf8_encode($txt);
		//var_dump($txt); exit(0);
		// MultiCell($w, $h, $txt, $border=0, $align='L', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
		$pdf->SetTextColor(0, 170, 201);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,0, 0, 1);
		$pdf->MultiCell(60, 45, '', 0, 'C', 1, 0, '', '', true, 0, false, true, '12', 'M');
		
		$pdf->SetFillColor(255, 255, 255);
		$pdf->MultiCell(130, 45, $txt, 0, 'L', 1, 1, '', '', true, 0, true, true, '12', 'M');		
		$pdf->Ln(4);
				
		$txt=utf8_encode('BRIEFING Nº ').$id_formated.' - '.utf8_encode($briefing['titulo']);
		
		//var_dump($txt); exit(0);
		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
		$pdf->SetTextColor(255, 255, 255);
		$pdf->SetFillColor(0, 170, 201);
		$pdf->SetFont('helvetica', 'b', 12);
		$pdf->MultiCell(190, 12, $txt, 0, 'C', 1, 1, '', '', true, 0, false, true, '12', 'M');
			
		$txt='CLIENTE';
		$txt= utf8_encode($txt);
		$pdf->SetTextColor(0, 170, 201);
		$pdf->SetFillColor(249,207 , 69);
		$pdf->MultiCell(190, 12, $txt, 0, 'C', 1, 1, '', '', true, 0, false, true, '12', 'M');
		$pdf->Ln(2);
		$txt='Nome do cliente: ';
		//$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		
		$txt = $briefing['nome_cliente'];
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,0, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		$pdf->Ln(5);
		
		$txt = utf8_encode('Informações do cliente:');
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		
		$txt = $info_cliente;
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,0, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, 'J', 1, 1, '', '', true, 0, true, true, '', 'M');
		$pdf->Ln(10);
		
		$txt = 'DEMANDA ';
		$txt= utf8_encode($txt);
		//var_dump($txt); exit(0);
		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
		$pdf->SetFont('helvetica', 'b', 12);
		$pdf->SetTextColor(0, 170, 201);
		$pdf->SetFillColor(249,207 , 69);
		$pdf->MultiCell(190, 12, $txt, 0, 'C', 1, 1, '', '', true, 0, false, true, '12', 'M');
		$pdf->Ln(5);
		
		$txt='Descrição e conceito:';
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		
		$txt = $demanda;
		//$txt = str_replace(array("<br/>","<br>") , "\n" , $demanda );
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,3, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, '', 1, 1, '', '', true, 0, true, true, '12', 'M');
		$pdf->Ln(5);
		
		$txt='Objetivo de comunicação:';
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		
		$txt = $objetivo;
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,3, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, '', 1, 1, '', '', true, 0, true, true, '12', 'M');
		$pdf->Ln(5);
		
		
		
		$txt='Público-alvo:';
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
				
		$txt = $publico;
	/*	$txt = str_replace(array("<br/>","<br />", "<br>") , "\r" , $publico ); */
		
		//$txt = str_replace(array("<br/>","<br>") , "\n" , $demanda );
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,3, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, '', 1, 1, '', '', true, 0, true, true, '12', 'M');
		$pdf->Ln(5);
		
		
		$txt = 'DADOS TÉCNICOS DA DEMANDA';
		$txt= utf8_encode($txt);
		//var_dump($txt); exit(0);
		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
		$pdf->SetFont('helvetica', 'b', 12);
		$pdf->SetTextColor(0, 170, 201);
		$pdf->SetFillColor(249,207 , 69);
		$pdf->MultiCell(190, 12, $txt, 0, 'C', 1, 1, '', '', true, 0, false, true, '12', 'M');
		$pdf->Ln(5);
		
		$pecas = $this->get_peca($id);
		
		
		 /*
		$txt='Peças (Quais/quantas): ';
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		
		$txt = $demanda_pecas;
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,0, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		$pdf->Ln(3);
		
		$txt='Formatos/tamanhos:';
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		
		$txt = $demanda_formato;
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,0, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		$pdf->Ln(5);
	*/	
		if($pecas){
			$txt='Peças:';
			$txt= utf8_encode($txt);
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetTextColor(0, 0, 0); 
			$pdf->SetFillColor(255, 255, 255);
			$pdf->setCellPaddings(0,0, 0, 0);
			$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
			
			foreach($pecas as $pc){
				$txt =	'Descrição';
				$txt= utf8_encode($txt);
				$pdf->SetFont('helvetica', '', 12);
				$pdf->SetTextColor(0, 0, 0); 
				$pdf->SetFillColor(128, 191, 255);
				$pdf->setCellPaddings(3,0, 0, 1);
				// set cell margins
				//$pdf->setCellMargins(1, 1, 1, 1);
				$pdf->MultiCell(25, 12, $txt, 1, 'L', 1, 0, '', '', true, 0, false, true, '12', 'M');
				
				
				$txt = $pc['peca_descricao'];
				$txt= utf8_encode($txt);
				$pdf->SetFont('helvetica', '', 12);
				$pdf->SetTextColor(0, 0, 0); 
				$pdf->SetFillColor(255, 255, 255);
				$pdf->setCellPaddings(3,0, 0, 1);
				// set cell margins
				//$pdf->setCellMargins(1, 1, 1, 1);
				$pdf->MultiCell(165, 12, $txt, 1, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
				
				
				$txt = 'Qtd';
				$txt= utf8_encode($txt);
				$pdf->SetFont('helvetica', '', 12);
				$pdf->SetTextColor(0, 0, 0); 
				$pdf->SetFillColor(128, 191, 255);
				$pdf->setCellPaddings(3,0, 0, 1);
				// set cell margins
				//$pdf->setCellMargins(1, 1, 1, 1);
				$pdf->MultiCell(15, 12, $txt, 1, 'L', 1, 0, '', '', true, 0, false, true, '12', 'M');
								
				$txt = $pc['peca_qtd' ];
				$txt= utf8_encode($txt);
				$pdf->SetFont('helvetica', '', 12);
				$pdf->SetTextColor(0, 0, 0); 
				$pdf->SetFillColor(255,255 , 255);
				$pdf->setCellPaddings(3,0, 0, 1);
				// set cell margins
				//$pdf->setCellMargins(1, 1, 1, 1);
				$pdf->MultiCell(20, 12, $txt, 1, 'L', 1, 0, '', '', true, 0, false, true, '12', 'M');
				
				$txt = 'Formato';
				$txt= utf8_encode($txt);
				$pdf->SetFont('helvetica', '', 12);
				$pdf->SetTextColor(0, 0, 0); 
				$pdf->SetFillColor(128, 191, 255);
				$pdf->setCellPaddings(3,0, 0, 1);
				// set cell margins
				//$pdf->setCellMargins(1, 1, 1, 1);
				$pdf->MultiCell(20, 12, $txt, 1, 'L', 1,0, '', '', true, 0, false, true, '12', 'M');
		
				
				$txt = $pc['peca_formato'];
				$txt= utf8_encode($txt);
				$pdf->SetFont('helvetica', '', 12);
				$pdf->SetTextColor(0, 0, 0); 
				$pdf->SetFillColor(255, 255, 255);
				$pdf->setCellPaddings(3,0, 0, 1);
				// set cell margins
				//$pdf->setCellMargins(1, 1, 1, 1);
				$pdf->MultiCell(55, 12, $txt, 1, 'L', 1, 0, '', '', true, 0, false, true, '12', 'M');
				
				$txt = 'Data entrega:';
				$txt= utf8_encode($txt);
				$pdf->SetFont('helvetica', '', 12);
				$pdf->SetTextColor(0, 0, 0); 
				$pdf->SetFillColor(128, 191, 255);
				$pdf->setCellPaddings(3,0, 0, 1);
				// set cell margins
				//$pdf->setCellMargins(1, 1, 1, 1);
				$pdf->MultiCell(30, 12, $txt, 1, 'L', 1, 0, '', '', true, 0, false, true, '12', 'M');
								
				$txt = $pc['peca_data_entrega'];
				$txt= utf8_encode($txt);
				$pdf->SetFont('helvetica', '', 12);
				$pdf->SetTextColor(0, 0, 0); 
				$pdf->SetFillColor(255, 255, 255);
				$pdf->setCellPaddings(3,0, 0, 1);
				// set cell margins
				//$pdf->setCellMargins(1, 1, 1, 1);
				$pdf->MultiCell(50, 12, $txt, 1, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
				$pdf->Ln(5);
			/*	
				$txt = 'Prioridade';
				$txt= utf8_encode($txt);
				$pdf->SetFont('helvetica', '', 12);
				$pdf->SetTextColor(0, 0, 0); 
				$pdf->SetFillColor(255, 255, 255);
				$pdf->setCellPaddings(3,0, 0, 1);
				
				$pdf->MultiCell(190, 12, $txt, 1, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
				$pdf->Ln(5);
				
				$txt = $pc['peca_prioridade'];
				$txt= utf8_encode($txt);
				$pdf->SetFont('helvetica', '', 12);
				$pdf->SetTextColor(0, 0, 0); 
				$pdf->SetFillColor(255, 255, 255);
				$pdf->setCellPaddings(3,0, 0, 1);
				// set cell margins
				//$pdf->setCellMargins(1, 1, 1, 1);
				$pdf->MultiCell(190, 12, $txt, 1, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
				$pdf->Ln(5); 
		*/
				
			}
		}
		
		$txt='Materiais e acabamentos:';
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		
		$txt = $demanda_materiais;
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,0, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		$pdf->Ln(5);
	
		$txt='Modo de finalização:';
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		
		$txt = $demanda_finalizacao;
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,0, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		$pdf->Ln(5);
		
		$txt='Local do arquivo:';
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		
		$txt = $demanda_local;
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,0, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		$pdf->Ln(5);
		
		$txt = 'RECOMENDAÇÕES ';
		$txt= utf8_encode($txt);
	
		//var_dump($txt); exit(0);
		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
		$pdf->SetFont('helvetica', 'b', 12);
		$pdf->SetTextColor(0, 170, 201);
		$pdf->SetFillColor(249,207 , 69);
		$pdf->MultiCell(190, 12, $txt, 0, 'C', 1, 1, '', '', true, 0, false, true, '12', 'M');
		$pdf->Ln(5);
		 
		 
		/* 
		$txt='Ideia inicial:';
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		//$pdf->Ln(5);
		
		$txt = $recomendacoes_ideia;
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,3, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, '', 1, 1, '', '', true, 0, true, true, '12', 'M');
		//$pdf->Ln(5);
		
		*/
		$pdf->Ln(5);
		
		
		/*		
		$txt = $recomendacoes_referencias;
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,3, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, '', 1, 1, '', '', true, 0, true, true, '12', 'M');
		*/
		
		$txt='Referências:';
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
		
		if($referencias){
			$txt = '';
			$cont=0;
			foreach($referencias as $ref){
				$cont++;
				$txt =$ref['caminho'];
				$pdf->SetFont('helvetica', '', 10);
				$pdf->SetTextColor(0, 0, 0); 
				if($cont%2==0){
					$pdf->SetFillColor(223, 239, 255);
				}
				else{					
					$pdf->SetFillColor(255, 255, 255);
				}
				$pdf->setCellPaddings(3,3, 0, 1);
				// set cell margins
				//$pdf->setCellMargins(1, 1, 1, 1);
				$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
				
			}
		}
		
		$pdf->Ln(5);
		
		$txt='Objeçoes:';
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0); 
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(0,0, 0, 0);
		$pdf->MultiCell(190, 12, $txt, 0, 'L', 1, 1, '', '', true, 0, false, true, '12', 'M');
				
		$txt = $recomendacoes_objecoes;
		$txt= utf8_encode($txt);
		$pdf->SetFont('helvetica', '', 12);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFillColor(255, 255, 255);
		$pdf->setCellPaddings(3,3, 0, 1);
		// set cell margins
		//$pdf->setCellMargins(1, 1, 1, 1);
		$pdf->MultiCell(190, 12, $txt, 1, '', 1, 1, '', '', true, 0, true, true, '12', 'M');
		$pdf->Ln(5);
		
		
		
		$txt = 'CRONOGRAMA ';
		$txt= utf8_encode($txt);
		//var_dump($txt); exit(0);
		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
		$pdf->SetFont('helvetica', 'b', 12);
		$pdf->SetTextColor(0, 170, 201);
		$pdf->SetFillColor(249,207 , 69);
		$pdf->MultiCell(190, 12, $txt, 0, 'C', 1, 1, '', '', true, 0, false, true, '12', 'M');
		$pdf->Ln(5);
		
		$txt ='';
		if($cronograma){
			$txt ='Atividade';
			$pdf->SetFont('helvetica', 'b', 12);
			$pdf->SetTextColor(0, 0, 0); 
			$pdf->SetFillColor(128, 191, 255);
			$pdf->setCellPaddings(3,3, 0, 1);
			// set cell margins
			//$pdf->setCellMargins(1, 1, 1, 1);
			$pdf->MultiCell(130, 10, $txt, 0, 'L', 1, 0, '', '', true, 0, true, true, '12', 'M');
			$txt ='Início';
			$txt= utf8_encode($txt);
			$pdf->MultiCell(30, 10, $txt, 0, 'L', 1, 0, '', '', true, 0, true, true, '12', 'M');
			$txt ='Fim';
			$pdf->MultiCell(30, 10, $txt, 0, 'L', 1, 1, '', '', true, 0, true, true, '12', 'M');
			//$pdf->Ln(5);
			$cont=0;
			foreach($cronograma as $etapa){
				$cont++;
				$txt =$etapa['atividade'];
				$pdf->SetFont('helvetica', '', 10);
				$pdf->SetTextColor(0, 0, 0); 
				if($cont%2==0){
					$pdf->SetFillColor(223, 239, 255);
				}
				else{					
					$pdf->SetFillColor(255, 255, 255);
				}
				$pdf->setCellPaddings(3,3, 0, 1);
				// set cell margins
				//$pdf->setCellMargins(1, 1, 1, 1);
				$pdf->MultiCell(130, 8, $txt, 0, '', 1, 0, '', '', true, 0, true, true, '12', 'M');
				$txt =$this->convert_data_bd_to_human($etapa['inicio']);
				$pdf->MultiCell(30, 8, $txt, 0, '', 1, 0, '', '', true, 0, true, true, '12', 'M');
				$txt =$this->convert_data_bd_to_human($etapa['fim']);
				$pdf->MultiCell(30, 8, $txt, 0, '', 1, 1, '', '', true, 0, true, true, '12', 'M');
			}
			//$txt .= "</table>";
		} 
		else{
		
			//$txt= utf8_encode($txt);
			//var_dump($txt); exit(0);
			$pdf->SetFont('helvetica', '', 12);
			$pdf->SetTextColor(0, 0, 0); 
			$pdf->SetFillColor(255, 255, 255);
			$pdf->setCellPaddings(3,3, 0, 1);
			// set cell margins
			//$pdf->setCellMargins(1, 1, 1, 1);
			$pdf->MultiCell(190, 12, $txt, 1, '', 1, 1, '', '', true, 0, true, true, '12', 'M');
			$pdf->Ln(5);
		}

		$pdf->lastPage();
		$pdf->Output('teste.pdf', 'I');
	}
	
/**
	 * adicionar_peca
	 * Adiciona novas atividades na tabela pecas conforme id informado do briefing
	 * 
	 * @param INT $pecas
	 * return bool
	 */		
	function adicionar_peca($peca=false){
		//if((!$briefing_id) || (!$cronograma) ){ return FALSE;}

		$peca_data_entrega= $this->convert_data_human_to_bd($peca['peca_data_entrega']);
		$sql="INSERT INTO pecas(
				peca_descricao, 
				peca_qtd, 
				peca_formato, 
				peca_data_entrega, 
				peca_prioridade, 
				briefing_id 
			)values(
				'{$peca['peca_descricao']}',
				'{$peca['peca_qtd']}',
				'{$peca['peca_formato']}',
				'{$peca_data_entrega}',
				'{$peca['peca_prioridade']}',
				'{$peca['briefing_id']}'
			)";
		
		$query = $this->db->query($sql);
		//var_dump($sql); exit(0);
		$count=$query->rowCount();
		if($count>0){
			return TRUE;
			
		}
		else{
			return FALSE;
			$errorcode = $this->db->errorCode();
			echo $errorcode;
			//return FALSE;
		}
	}
	
	/**
	 * Get_pecas
	 * Consulta todos as peças ser filtrado pelo id da peça ou id do briefinfg a que pertencem
	 * 
	 * @param INT (optional)$id_briefing , (optional)$id_peca
	 * return array com dados consultados
	 */	
	function get_peca($id_briefing=false , $id_peca=false){
		 $where_id='';
		if(!$id_briefing){return FALSE;}
		if($id_peca){ $where_id = 'AND `id`='.$id_peca;}
		$sql = "SELECT * FROM `pecas` WHERE `briefing_id` = ". $id_briefing.' '.$where_id." ORDER BY peca_prioridade ASC";
		$query=$this->db->query($sql);
		if($query){ 
			$briefing= $query->fetchAll(PDO::FETCH_ASSOC);
			if($briefing){ return $briefing; }
		}
		return FALSE;
	}
	
		/**
	 * Edita_Peca
	 * altera campos da tabela pecas
	 * 
	 * @param ARRAY $dados
	 * return bool
	 */	
	function edita_peca($dados){
		//var_dump($dados);
		if(!isset($dados['peca_descricao'])){return FALSE;}
		$sql =	"UPDATE `pecas` SET "; 
		if(isset($dados['peca_descricao']) and ($dados['peca_descricao']) and !(empty($dados['peca_descricao']))){
			$sql.=	" `peca_descricao`='{$dados['peca_descricao']}',"; 
		}
		
		if(isset($dados['peca_qtd']) and ($dados['peca_qtd']) and !(empty($dados['peca_qtd']))){ 
			$sql.=	"`peca_qtd`='{$dados['peca_qtd']}',"; 
		}
		
		if(isset($dados['peca_formato']) and ($dados['peca_formato']) and !(empty($dados['peca_formato']))){ 
			$sql.= "`peca_formato`='{$dados['peca_formato']}',"; 
		}
		
		if(isset($dados['peca_data_entrega']) and ($dados['peca_data_entrega']) and !(empty($dados['peca_data_entrega']))){ 
			$peca_data_entrega = $this->convert_data_human_to_bd($dados['peca_data_entrega']);
			$sql.=	"`peca_data_entrega`='{$peca_data_entrega}',"; 
		}
		
		if(isset($dados['peca_prioridade'])){ 
			$sql.= "`peca_prioridade`='{$dados['peca_prioridade']}' "; 
		}
		
		$sql.= " WHERE `briefing_id`={$dados['briefing_id']} AND `id`={$dados['idPeca']}";		
		//var_dump($sql);
		if($this->db->query($sql)){
			
			return TRUE;
		}
		else{
			echo $this->db->errorCode();
			return FALSE;
		}
	}
	
		/**
	 * Excluir_peca
	 * Exclui peça especificado por id
	 * 
	 * @param INT $id
	 * return bool
	 */		
	function excluir_peca($id){
		if(!$id){return FALSE;}
		$sql='DELETE FROM pecas WHERE id='.$id;
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
	/*REFERENCIAS */
	/*-----------------------------------------------------------------------------------------------------*/
	/*salvar_referencias
	 * Recebe array $referencias e INT $briefing_id se for uma url salva no banco se for arquivo salva arquivo em pasta e no BD.
	 * Se salvar arquivo retorna FALSE senão strung com $erro ou TRUE; se for url TRUE salva;
	 * */
	function salvar_referencias($referencias, $briefing_id){
		//var_dump($referencias, $briefing_id);exit(111);
		if(!$briefing_id){ return TRUE;}
		if(!is_array($referencias) or empty($referencias)){ return TRUE;}
		if(isset($referencias['tipo']) and $referencias['tipo']=='url' ){
			if(!(strstr($referencias['caminho'], 'http://')) and !(strstr($referencias['caminho'], 'https://')) ){
				//exit('sem htt');
				$referencias['caminho']= 'http://'.$referencias['caminho'];
			}
			//exit('com htt');
			if (!filter_var($referencias['caminho'], FILTER_VALIDATE_URL) === false) {
				if($this->salva_referencia_bd($referencias)){
					return TRUE;
				}
				return FALSE;
			} else {
				return FALSE;
			}
		}
		else{
			//var_dump($referencias);
			$result = $this->salva_arquivos($referencias, $briefing_id);
			//var_dump($result,'ss');
			//exit('1 nivel');
			return $result;
			
		}
		return TRUE;
	}
	
	
	/*Salva arquivos
	 * Recebe array $referencias e INT $briefing_id salva arquivo em pasta e no BD.
	 * Se salvar retorna FALSE senão strung com $erro ou TRUE;
	 * */
	private function salva_arquivos($referencias, $briefing_id = FALSE){
		if(!$briefing_id){var_dump($briefing_id); exit('01');return TRUE;}
		if(!is_array($referencias) or empty($referencias)){ return TRUE;}
		if (is_uploaded_file($referencias['tmp_name'])) {
			$invalido=$this->validar_arquivos($referencias);
			//echo 'nivel 2';
			//var_dump($invalido);
			if($invalido){
				//echo 'invalido';
				return $invalido;
			}
			else{
				//echo 'valido';
				$nome = utf8_decode($referencias['name']);
				$new_name = $this->sanitizeString(strtolower(trim(stripslashes($nome))));
				$dir= "../files/";
				$new_name = $new_name;
				$destino = $dir.$new_name;
				$tipo = $this->verifica_estensao($referencias['name']);
				$referencia_bd=array(
					'nome'=>	$new_name,
					'caminho'=>	$destino,
					'tipo'=>	$tipo,
					'briefing_id'=>	$briefing_id
				);
				
				if(move_uploaded_file($referencias['tmp_name'],$destino)){
					if($this->salva_referencia_bd($referencia_bd)){
						return FALSE;
					}
					else{
						return TRUE;
					}
				}
				else{
					return TRUE;
					//exit( "nao moveu");
				}
				
			}
		} else {
			/*echo "Possível ataque de envio de arquivo: ";
			echo "nome do arquivo '". $referencias['tmp_name'] . "'.";*/
			echo "Nenhum arquivo foi enviado";
			
		}
		//echo 'dddd';
		return TRUE;
	}
	
	private function validar_arquivos($arquivo=false){
		if($arquivo){
			$erro= FALSE;
			$valido=FALSE;
			$max_size = 2000000;
			$extensao= $this->verifica_estensao($arquivo['name']);
			$extensoes_validas= array( 'pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif');
			foreach($extensoes_validas as $ext ){
				if($extensao==$ext){ $valido= TRUE; }
				
			}
			if(!$valido){
				$erro = "Extensão do arquivo invalida"; 
				//echo $erro;
				//echo "Extensão do arquivo invalida";
				return $erro;
			}
			elseif($arquivo['size']>$max_size){
				$erro = "Este arquivo ultrapassa o tamanho máximo permitido (2MB).";
				//echo $erro;
				return $erro;
			}
			else{
				//echo 'ffffffffffffffffff';
				return FALSE;
			}
		}
		//echo '1111111111111';
		return FALSE;
	}
	
	
	private function salva_referencia_bd($referencia=false){
		if(!$referencia){return FALSE;}
		$sql="INSERT INTO referencias(
			nome, 
			tipo, 
			caminho, 
			briefing_id 
		)values(
			'{$referencia['nome']}',
			'{$referencia['tipo']}',
			'{$referencia['caminho']}',
			'{$referencia['briefing_id']}'
		)";
				$query = $this->db->query($sql);
		//var_dump($sql); exit(0);
		$count=$query->rowCount();
		if($count>0){
			return TRUE;
			
		}
		else{
			return FALSE;
			$errorcode = $this->db->errorCode();
			echo $errorcode;
		}
		
	}
	
	
	function sanitizeString($string) {
		// matriz de entrada
		$caracteres_especias = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º', '‡' );

		// matriz de saída
		$caracteres_simples   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );

		// devolver a string
		return str_replace($caracteres_especias, $caracteres_simples, $string);
	}
	
	private function verifica_estensao($file){
		$file_name= strtolower(trim(stripslashes($file)));
		$file_name= explode('.',$file_name);
		$extensao= end($file_name);
		return $extensao;
	}
	
	function get_referencias($id_briefing=false , $id_referencia=false){
		 $where_id='';
		if(!$id_briefing){return FALSE;}
		if($id_referencia){ $where_id = 'AND `id`='.$id_referencia;}
		$sql = "SELECT * FROM `referencias` WHERE `briefing_id` = ". $id_briefing.' '.$where_id." ORDER BY id DESC";
		$query=$this->db->query($sql); 
		$briefing= $query->fetchAll(PDO::FETCH_ASSOC);
		if($briefing){
			return $briefing;
		}
		else{
			return FALSE;
		}
	}
	
	function is_image($arquivo){
		$is_image=FALSE;
		$extensao = $this->verifica_estensao($arquivo);
		$imagem= array( 'bmp', 'jpg', 'jpeg', 'png', 'gif');
		foreach($imagem as $ext ){
			if($extensao==$ext){ $is_image = TRUE; }
		}
		return $is_image;
	}
	
	
	function excluir_referencia($id){
		if(!$id){return FALSE;}
		$sql='DELETE FROM referencias WHERE id='.$id;
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

}

