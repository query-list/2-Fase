<?php
class Telefones{
	private $id;
	private $categoria;
	private $numero;
	private $cidade;
	private $descricao;
	private $palavrasChaves; //array com palavras chaves
	private $token;
	
	public function getId(){
		return $this->id;
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getDescricao(){
		return $this->descricao; 
	}
	
	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	
	public function getCategoria(){
		return $this->categoria;
	}
	
	public function setCategoria($categoria){
		$this->categoria = $categoria;
	}
	
	public function getNumero(){
		return $this->numero;
	}
	
	public function setNumero($numero){
		$this->numero=$numero;
	}
	public function getCidade(){
		return $this->cidade;
	}
	
	public function setCidade($cidade){
		$this->cidade = $cidade;
	}
	
	public function geraToken(){
		$this->token = bin2hex(openssl_random_pseudo_bytes(24));
	}
	
	public function getToken(){
	  return $this->token;	
	}
	
	public function setPalavrasChaves($palavrasChaves){
		$this->palavrasChaves = $palavrasChaves;
	}
	
	public function getPalavrasChaves(){
		return $this->palavrasChaves;
	}
	
}
?>