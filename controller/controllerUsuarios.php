<?php
require 'model\usuarios\daoUsuarios.php';
require 'model\usuarios\usuarios.php';
require 'model\conn.php';
class ControllerUsuarios{
	
	public static function login($usuario, $senha){
		if (DaoUsuarios::buscaLogin($usuario, $senha)) {		
		    session_start();
			$_SESSION['usuario'] = $usuario;
			echo 'true';
		}
	    else{
			echo 'false';
		}
	}	
	
	public static function logout(){
	   session_start();
	   session_destroy();
	}	
	
	public static function cadastrar($nome, $email, $login, $senha){
		$usuario = new Usuarios;
		$usuario->setNome($nome);
		$usuario->setEmail($email);
		$usuario->setSenha($senha);
		$usuario->setUsuario($login);
		Conn::getInstance()->beginTransaction();
		DaoUsuarios::inserir($usuario);
		//Conn::getInstance()->commit();
	}
	
	public static function listar(){
		$usuarios = DaoUsuarios::listAll();
		$data = array("data"=>array());
		foreach($usuarios as $usuario){
		   array_push($data['data'], array($usuario["nome"], $usuario['usuario'], $usuario['id'], $usuario['id']));
		}
		echo json_encode($data);
	}
	
	public static function deletar($id){
		DaoUsuarios::deleta($id);
	}
	
	public static function busca($id){
		 echo json_encode(DaoUsuarios::buscaId($id));
	}
	
	public static function atualiza($nome, $usuario, $email, $senha, $id){
		$usuario = new Usuarios();
		$usuario->setNome = $nome;
		$usuario->setUsuario = $usuario;
		$usuario->setEmail = $email;
		$usuario->setSenha = $senha;
		$usuario->setId = $id;
		DaoUsuario::atualiza($usuario);
	}
}

?>