<?php 
namespace src\br\com\caelum\leilao\dominio;

class Usuario {
	private $id;
	private $nome;
	
	public function __construct(string $nome){
		$this->nome = $nome;
	}
	
	public function getNome(){
		return $this->nome;
	}
	
	public function setNome(string $nome){
		$this->nome = $nome;
	}
}
?>