<?php
namespace src\br\com\caelum\leilao\dominio;

class Leilao {
	private $descricao;
	private $lances;
	
	public function __construct(string $descricao, array $lances)
	{
		$this->descricao = $descricao;
		$this->lances = $lances;
	}
	
	public function getDescricao()
	{
		return $this->descricao;
	}
	
	public function getLances()
	{
		return $this->lances;
	}
	
	public function setDescricao(string $descricao)
	{
		$this->descricao = $descricao;
	}
	
	public function setLances(array $lances)
	{
		$this->lances = $lances;
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
	    return false;
	}
	
	private function validaDoisLancesSeguidosPorUsuario(Usuario $usuario)
	{
	    if($this->lances[count($this->lances) -1]->getUsuario() != $usuario){
	        return true;
	    }
	    return false;
	}
	
	private function validaLancesCrescente(float $valor)
	{
	    if($this->lances[count($this->lances) -1]->getValor() < $valor){
	        return true;
	    }
	    return false;
	}
}
?>