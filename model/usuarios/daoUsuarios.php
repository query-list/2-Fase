<?php
  class DaoUsuarios{
    public static $instance;
  
    private function __construct() {
        //
    }
  
    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new DaoLogin();
  
        return self::$instance;
    }
  	
    public static function buscaLogin($usuario, $senha){
    	
		try{
			$p_sql = Conn::getInstance()->prepare('SELECT * FROM usuarios WHERE usuario = :usuario');
			$p_sql->bindValue(":usuario", $usuario);
			$p_sql->execute();
			$login = $p_sql->fetch(PDO::FETCH_ASSOC);
			if (md5($senha) === $login['senha']) 
			  return $login;
			else
			  return FALSE;
		}
		catch(Exception $e){
			print $e->getMessage();
		}
	}

	public static function buscaId($id){
			try{
				$p_sql = Conn::getInstance()->prepare('SELECT * FROM usuarios WHERE id = :id');
				$p_sql->bindValue(":id", $id);
				$p_sql->execute();
				$usuario = $p_sql->fetch(PDO::FETCH_ASSOC);
				return $usuario;
			}
			catch(Exception $e){
				print $e->getMessage();
			}
	}
	
    public static function deleta($id){	
		try{
			$p_sql = Conn::getInstance()->prepare('DELETE FROM usuarios WHERE id = :id');
			$p_sql->bindValue(":id", $id);
			$p_sql->execute();
			echo 'Sucesso: usuário deletado.';
			return TRUE;
		}
		catch(Exception $e){
			print $e->getMessage();
		}
	}
	
	public static function buscaUsuario($usuario){
		try{
			$p_sql = Conn::getInstance()->prepare('SELECT * FROM usuarios WHERE usuario = :usuario');
			$p_sql->bindValue(":usuario", $usuario);
			$p_sql->execute();
			return $p_sql->fetch(PDO::FETCH_ASSOC);
		}
		catch(Exception $e){
			print $e->getMessage();
		}		
	}
	
	public static function buscaEmail($email){
		try{
			$p_sql = Conn::getInstance()->prepare('SELECT * FROM usuarios WHERE email = :email');
			$p_sql->bindValue(":email", $email);
			$p_sql->execute();
			return $p_sql->fetch(PDO::FETCH_ASSOC);
		}
		catch(Exception $e){
			print $e->getMessage();
		}		
	}
	
	public static function listAll(){
		try{
			$p_sql = Conn::getInstance()->prepare('SELECT * FROM usuarios ORDER BY nome');
			$p_sql->execute();
			return $p_sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $e){
			print $e->getMessage();
		}	
	}
	public static function atualiza($usuario){
		$sql = 'UPDATE usuarios SET nome = :nome, email = :email, usuario = :usuario, senha = :senha WHERE id = :id';
		try {
		  $p_sql = Conn::getInstance()->prepare($sql);
          $p_sql->bindValue(":nome", $usuario->getNome());
		  $p_sql->bindValue(":email", $usuario->getNome());
		  $p_sql->bindValue(":usuario", $usuario->getUsuario());
		  $p_sql->bindValue(":senha", md5($usuario->getSenha()));
		  $p_sql->bindValue(":id", md5($usuario->getId()));
          $p_sql->execute();
		  echo 'Sucesso: usuário atualizado.';
		  return TRUE;
	   }
		catch(Exception $e){
			Conn::getInstance()->rollBack();
			echo $e->getMessage();
		}
	}		
	
    public static function inserir($usuario) {
    	$sql = 'INSERT INTO usuarios(nome, email, usuario, senha) VALUES(:nome, :email, :usuario, :senha)';
        try {
        	if (DaoUsuarios::buscaUsuario($usuario->getUsuario())){
				echo 'Erro: Usuário já cadastrado';
				return FALSE;
			}
        	if (DaoUsuarios::buscaEmail($usuario->getEmail())){
				echo 'Erro: Email já cadastrado';
				return FALSE;
			}			
            $p_sql = Conn::getInstance()->prepare($sql);
            $p_sql->bindValue(":nome", $usuario->getNome());
			$p_sql->bindValue(":email", $usuario->getNome());
			$p_sql->bindValue(":usuario", $usuario->getUsuario());
			$p_sql->bindValue(":senha", md5($usuario->getSenha()));
            $p_sql->execute();
			echo 'Sucesso: usuário cadastrado.';
			return TRUE;
		}
		catch(Exception $e){
			Conn::getInstance()->rollBack();
			echo $e->getMessage();
		}
	} 
  }
?>