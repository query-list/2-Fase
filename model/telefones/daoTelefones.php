<?php
  class DaoTelefones{
    public static $instance;
  
    private function __construct() {
        //
    }
  
    public static function getInstance() {
        if (!isset(self::$instance))
            self::$instance = new DaoLogin();
  
        return self::$instance;
    }
	
	public static function buscaTelefoneCidade($idcidade){
			try{
				$p_sql = Conn::getInstance()->prepare('SELECT * FROM telefones WHERE idcidade = :idcidade');
				$p_sql->bindValue(":idcidade", $idcidade);
				$p_sql->execute();
				$telefone = $p_sql->fetchAll(PDO::FETCH_ASSOC);
				return $telefone;
			}
			catch(Exception $e){
				print $e->getMessage();
			}		
	}
  	
	public static function buscaId($id){
			try{
				$p_sql = Conn::getInstance()->prepare('SELECT * FROM telefones WHERE id = :id');
				$p_sql->bindValue(":id", $id);
				$p_sql->execute();
				$telefone = $p_sql->fetch(PDO::FETCH_ASSOC);
				return $telefone;
			}
			catch(Exception $e){
				print $e->getMessage();
			}
	}
	
    public static function deleta($id){	
		try{
			$p_sql = Conn::getInstance()->prepare('DELETE FROM telefones WHERE id = :id');
			$p_sql->bindValue(":id", $id);
			$p_sql->execute();
			echo 'Sucesso: telefone deletado.';
			return TRUE;
		}
		catch(Exception $e){
			print $e->getMessage();
		}
	}
	
	public static function listAll(){
		try{
			$p_sql = Conn::getInstance()->prepare('SELECT * FROM telefones ORDER BY descricao');
			$p_sql->execute();
			return $p_sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $e){
			print $e->getMessage();
		}	
	}
	
	public static function listCategorias(){
		try{
			$p_sql = Conn::getInstance()->prepare('SELECT DISTINCT(categoria) AS categoria FROM telefones ORDER BY categoria');
			$p_sql->execute();
			return $p_sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $e){
			print $e->getMessage();
		}			
	}
	
	public static function listCidades(){
		try{
			$p_sql = Conn::getInstance()->prepare('SELECT * FROM municipio ORDER BY Nome');
			$p_sql->execute();
			return $p_sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $e){
			print $e->getMessage();
		}		
	}
	
	public static function listCidadesUF($uf){
		try{
			$p_sql = Conn::getInstance()->prepare('SELECT * FROM municipio WHERE uf = :uf ORDER BY Nome');
			$p_sql->bindValue(":uf", $uf);
			$p_sql->execute();
			return $p_sql->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(Exception $e){
			print $e->getMessage();
		}	
	}
	
	public static function atualiza($usuario){
		/*$sql = 'UPDATE telefones SET nome = :nome, email = :email, usuario = :usuario, senha = :senha WHERE id = :id';
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
		}*/
	}		
	
	public static function buscaToken($token){
   	try{
		$p_sql = Conn::getInstance()->prepare("SELECT * FROM telefones WHERE token = :token");
		$p_sql->bindValue(":token", $token);
		$p_sql->execute();
		return $p_sql->fetch(PDO::FETCH_ASSOC);
	}
	catch(Exception $e){
		print $e->getMessage();
	}		
  }
	public static function inserirPalavrasChaves($telefone){
		$idTelefone = $telefone->getId();
		$sql = 'INSERT INTO palavrachavestelefones(nome, idtelefone) VALUES(:nome, :idtelefone)';	
		foreach($telefone->getPalavrasChaves() as $chave){
		  $p_sql = Conn::getInstance()->prepare($sql);
		  $p_sql->bindValue(":nome", $chave); 
		  $p_sql->bindValue(":idtelefone", $telefone->getId()); 
		  //"'+$chave+'", "'+$telefone->getNumero() + '")';
		  $p_sql->execute();
		}
	}
	
	public static function inserir($telefone){
		$telefone->geraToken();
		$sql = 'INSERT INTO telefones(categoria, numero,  idcidade, descricao, token) VALUES(:categoria, :numero, :idcidade, :descricao, :token)';
		try{
			$p_sql = Conn::getInstance()->prepare($sql);
			$p_sql->bindValue(":categoria", $telefone->getCategoria());
			$p_sql->bindValue(":numero", $telefone->getNumero());
			$p_sql->bindValue(":idcidade", $telefone->getCidade());
			$p_sql->bindValue(":descricao", $telefone->getDescricao());
			$p_sql->bindValue(":token", $telefone->getToken());
			$p_sql->execute();
			$telefone->setId(DaoTelefones::buscaToken($telefone->getToken())['id']);
			DaoTelefones::inserirPalavrasChaves($telefone);
			echo 'Sucesso: telefone cadastrado.';
			return TRUE;
		}
		catch(Exception $e){
			Conn::getInstance()->rollBack();
			echo $e->getMessage();
			return FALSE;
		}
	}
  }
  
?>