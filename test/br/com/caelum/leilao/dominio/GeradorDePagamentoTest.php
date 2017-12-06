<?php
namespace test\br\com\caelum\leilao\dominio;

use PHPUnit\Framework\TestCase;
use src\br\com\caelum\leilao\servicos\GeradorDePagamentos;
use src\br\com\caelum\leilao\interfaces\Relogio;
use src\br\com\caelum\leilao\interfaces\RepositorioDePagamentos;
use src\br\com\caelum\leilao\dominio\LeilaoBuilder;
use src\br\com\caelum\leilao\dominio\Usuario;
use src\br\com\caelum\leilao\dominio\Avaliador;
use src\br\com\caelum\leilao\interfaces\LeilaoCrudDao;

class GeradorDePagamentoTest extends TestCase
{
    public function testDeveEmpurrarParaOProximoDiaUtil()
    {
        $leiloes = $this->createMock(LeilaoCrudDao::class);
        $pagamentos = $this->createMock(RepositorioDePagamentos::class);
        
        $relogio = $this->createMock(Relogio::class);
        $relogio->method("hoje")->will($this->returnValue(new \DateTime("2017-12-02")));
        
        $leilao = new LeilaoBuilder();
        $leilao = $leilao->comDescricao("PlayStation4")
            ->comLance(new Usuario("Joao"), 2000.0)
            ->comLance(new Usuario("Jose"), 2500.0)
            ->cria();
        
        $leiloes->method("encerrados")->will($this->returnValue(array($leilao)));
        
        $gerador = new GeradorDePagamentos($pagamentos, $leiloes, new Avaliador(), $relogio);
        
        $pagamentos = $gerador->gera();
        $pagamentoGerado = $pagamentos[0];
        
        $this->assertEquals(1, $pagamentoGerado->getData()->format("w"));
    }
}