<?php
namespace src\br\com\caelum\leilao\servicos;

use src\br\com\caelum\leilao\interfaces\LeilaoCrudDao;
use src\br\com\caelum\leilao\interfaces\RepositorioDePagamentos;
use src\br\com\caelum\leilao\dominio\Avaliador;
use src\br\com\caelum\leilao\dominio\Pagamento;
use src\br\com\caelum\leilao\interfaces\Relogio;

class GeradorDePagamentos
{
    private $pagamentos;
    private $leiloes;
    private $avaliador;
    private $relogio;
    
    public function __construct(
        RepositorioDePagamentos $pagamentos, 
        LeilaoCrudDao $leiloes, 
        Avaliador $avaliador,
        Relogio $relogio = null)
    {
        $this->leiloes = $leiloes;
        $this->pagamentos = $pagamentos;
        $this->avaliador = $avaliador;
        $this->relogio = $relogio ?? new RelogioDoSistema();
    }
    
    public function gera()
    {
        $leiloesEncerrados = $this->leiloes->encerrados();
        
        $novosPagamentos = array();
        
        foreach ($leiloesEncerrados as $leilao){
            $this->avaliador->avalia($leilao);
            
            $novoPagamento = new Pagamento($this->avaliador->getMaiorValor(), $this->primeiroDiaUtil());
            $novosPagamentos[] = $novoPagamento;
        }
        
        $this->pagamentos->salvaTodos($novosPagamentos);
        return $novosPagamentos;
    }
    
    public function getPagamentos()
    {
        return $this->pagamentos;
    }
    
    private function primeiroDiaUtil()
    {
        $data = $this->relogio->hoje();
        $diaDaSemana = $data->format("w");
        
        if($diaDaSemana == 6){
            $data->add(new \DateInterval("P2D"));
        } elseif ($diaDaSemana == 0){
            $data->add(new \DateInterval("P1D"));
        }
        
        return $data;
    }
}