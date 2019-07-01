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
		$palavraschaves = explode("\n", $palavraschaves);
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
	
	public static function buscaTelefoneCidade($idcidade){
		$telefones = DaoTelefones::buscaTelefoneCidade($idcidade);
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
}
?>