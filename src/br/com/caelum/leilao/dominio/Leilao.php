<?php
namespace src\br\com\caelum\leilao\dominio;

class Leilao {
	private $descricao;
	private $lances;
	
	public function __construct(string $descricao, array $lances){
		$this->descricao = $descricao;
		$this->lances = $lances;
	}
	
	public function getDescricao(){
		return $this->descricao;
	}
	
	public function getLances(){
		return $this->lances;
	}
	
	public function setDescricao(string $descricao){
		$this->descricao = $descricao;
	}
	
	public function setLances(array $lances){
		$this->lances = $lances;
	}
}
?>