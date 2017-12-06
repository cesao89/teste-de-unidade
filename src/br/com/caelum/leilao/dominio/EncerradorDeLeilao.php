<?php
namespace src\br\com\caelum\leilao\dominio;

use test\br\com\caelum\leilao\dominio\LeilaoCrudDao;
use test\br\com\caelum\leilao\dominio\EnviadorDeEmailCrud;

class EncerradorDeLeilao
{
    private $total = 0;
    private $dao;
    private $carteiro;
    
    public function __construct(LeilaoCrudDao $dao, EnviadorDeEmailCrud $carteiro)
    {
        $this->dao = $dao;
        $this->carteiro = $carteiro;
    }
    
    public function encerrar()
    {
        $todosLeiloesCorrentes = $this->dao->correntes();
        
        foreach ($todosLeiloesCorrentes as $leilao){
            try {
                if($this->comecouSemanaPassada($leilao)){
                    $leilao->encerra();
                    $this->dao->atualiza($leilao);
                    $this->carteiro->envia($leilao);
                    $this->total++;
                }
            } catch (\RuntimeException $e) {
                // Salvar LOG
            }
        }
    }
    
    /**
     * @return number
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param number $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    private function comecouSemanaPassada(Leilao $leilao)
    {
        if($this->diasEntre($leilao->getData(), new \DateTime()) > 7){
            return true;
        }
        
        //throw new \RuntimeException("Leilão criado menos de 7 dias");
    }
    
    private function diasEntre(\DateTime $inicio, \DateTime $fim)
    {
        $data = clone $inicio;
        $diasNoIntervalo = 0;
        
        while ($data < $fim){
            $data->add(new \DateInterval("P1D"));
            $diasNoIntervalo++;
        }
        
        return $diasNoIntervalo;
    }
}