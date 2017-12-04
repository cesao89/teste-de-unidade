<?php 
namespace src\br\com\caelum\leilao\dominio;

class Avaliador{
	private $maiorLance = -INF;
	private $menorLance = INF;
	private $medioLance;
	
	public function avalia(Leilao $leilao)
	{
	    if(empty($leilao->getLances())){
	        $this->maiorLance = 0;
	        $this->menorLance = 0;
	        $this->medioLance = 0;
	    } else {
	        $lances = $leilao->getLances();
	        
	        foreach ($lances as $lance){
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
}
?>