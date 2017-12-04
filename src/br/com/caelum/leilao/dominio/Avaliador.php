<?php 
namespace src\br\com\caelum\leilao\dominio;

class Avaliador{
	private $maiorLance = -INF;
	private $menorLance = INF;
	private $medioLance;
	private $todosLances;
	
	public function avalia(Leilao $leilao)
	{
	    if(empty($leilao->getLances())){
	        $this->maiorLance = 0;
	        $this->menorLance = 0;
	        $this->medioLance = 0;
	    } else {
	        $lances = $leilao->getLances();
	        
	        foreach ($lances as $lance){
	            $this->todosLances[] = $lance->getValor();
	            
	            if($lance->getValor() > $this->maiorLance){
	                $this->maiorLance = $lance->getValor();
	            }
	            
	            if($lance->getValor() < $this->menorLance){
	                $this->menorLance = $lance->getValor();
	            }
	            
	            $this->medioLance += $lance->getValor();
	        }
	        
	        $this->medioLance = $this->medioLance/count($lances);
	    }
	}
	
	public function getMaiorValor(){
		return $this->maiorLance;
	}
	
	public function getMenorValor(){
		return $this->menorLance;
	}
	
	public function getMedioValor(){
	    return $this->medioLance;
	}
	
	public function getTresMaiores()
	{
	    rsort($this->todosLances);
	    $return = array_chunk($this->todosLances, 3);
	    return $return[0];
	}
}
?>