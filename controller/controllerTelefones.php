<?php
require 'model\telefones\daoTelefones.php';
require 'model\telefones\telefones.php';
class ControllerTelefones{
	public static function listarCidades(){
		echo json_encode(DaoTelefones::listCidades());
	}
	public static function listarCidadesUF($uf){
		echo json_encode(DaoTelefones::listCidadesUF($uf));
	}
	public static function listarCategorias(){
		echo json_encode(DaoTelefones::listCategorias());
	}
	
	public static function cadastrarTelefone($descricao, $numero, $categoria, $idcidade, $palavraschaves){
		$telefone = new Telefones();
		$telefone->setDescricao($descricao);
		$telefone->setNumero($numero);
		$telefone->setCategoria($categoria);
		$telefone->setCidade($idcidade);
		$palavraschaves = array_filter(explode("\n", $palavraschaves));
		$telefone->setPalavrasChaves($palavraschaves);
		DaoTelefones::inserir($telefone);
		
	}
	
	public static function listar(){
		$telefones = DaoTelefones::listAll();
		$data = array("data"=>array());
		foreach($telefones as $telefone){
		   array_push($data['data'], array($telefone["descricao"], $telefone["numero"], $telefone['id'], $telefone['id']));
		}
		echo json_encode($data);			
	}

	public static function deletar($id){
		DaoTelefones::deleta($id);
	}
	
	public static function buscaTelefoneCidade($idcidade, $palavra = ''){
		$telefones = DaoTelefones::buscaTelefoneCidade($idcidade, $palavra);
		$data = array("data"=>array());
		if(!$telefones){
			echo json_encode($data);
			exit;
		}
		foreach($telefones as $telefone){
		   array_push($data['data'], array($telefone["descricao"], $telefone["numero"], $telefone['categoria']));
		}
		echo json_encode($data);			
	}
	
	public static function buscaTelefoneId($id){
		echo json_encode(DaoTelefones::buscaId($id));
	}
	
	public static function palavras($chave){
		echo json_encode(DaoTelefones::listPalavras($chave));
	}
	
	public static function atualizarTelefone($descricao, $numero, $categoria, $idcidade, $palavraschaves, $id){
		$telefone = new Telefones();
		$telefone->setDescricao($descricao);
		$telefone->setNumero($numero);
		$telefone->setCategoria($categoria);
		$telefone->setCidade($idcidade);
		$palavraschaves = array_filter(explode("\n", $palavraschaves));
		$telefone->setPalavrasChaves($palavraschaves);
		$telefone->setId($id);
		Conn::getInstance()->beginTransaction();
		DaoTelefones::atualiza($telefone);		
		Conn::getInstance()->commit();
	}
	
}
?>