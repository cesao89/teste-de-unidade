<?php
namespace src\br\com\caelum\leilao\dominio;

use phpDocumentor\Reflection\Types\Boolean;

class Leilao {
	private $descricao;
	private $lances;
	private $data;
	private $encerrado;
	
	public function __construct(string $descricao = NULL, array $lances = [])
	{
		$this->descricao = $descricao;
		$this->lances = $lances;
		$this->data = new \DateTime();
		$this->encerrado = false;
	}
	
	public function getDescricao()
	{
		return $this->descricao;
	}
	
	public function getLances()
	{
		return $this->lances;
	}
	
	public function getData()
	{
	    return $this->data;
	}
	
	public function getEncerrado()
	{
	    return $this->encerrado;
	}
	
	public function setDescricao(string $descricao)
	{
		$this->descricao = $descricao;
	}
	
	public function setLances(array $lances)
	{
		$this->lances = $lances;
	}
	
	public function setData(\DateTime $data)
	{
	    $this->data = $data;
	}
	
	public function setEncerrado(Boolean $boolean)
	{
	    $this->encerrado = $boolean;
	}
	
	public function propoe(Lances $lance)
	{   
	    $usuario = $lance->getUsuario();
	    
	    if(empty($this->lances)
	        || $this->validaQuantidadePorUsuario($usuario)
	        && $this->validaDoisLancesSeguidosPorUsuario($usuario)
	        && $this->validaLancesCrescente($lance->getValor())
	    ){
	       $this->lances[] = $lance;
	    }
	}
	
	public function encerra()
	{
	    $this->encerrado = true;
	}
	
	private function validaQuantidadePorUsuario(Usuario $usuario)
	{
	    $total = 0;
	    foreach ($this->lances as $lance){
	        if($lance->getUsuario() == $usuario){
	            $total++;
	        }
	    }
	    
	    if($total < 5){
	        return true;
	    }
	    
	    throw new \RuntimeException("Limite de Lançes por Usuário Excedido");
	}
	
	private function validaDoisLancesSeguidosPorUsuario(Usuario $usuario)
	{
	    if($this->lances[count($this->lances) -1]->getUsuario() != $usuario){
	        return true;
	    }
	    
	    throw new \RuntimeException("Não é possível efetuar dois lançes seguidos");
	}
	
	private function validaLancesCrescente(float $valor)
	{
	    if($this->lances[count($this->lances) -1]->getValor() < $valor){
	        return true;
	    }
	    
	    throw new \RuntimeException("Valor do lançe menor do lance anterior");
	}
}
?>