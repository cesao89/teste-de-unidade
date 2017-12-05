<?php
namespace test\br\com\caelum\leilao\dominio;

use PHPUnit\Framework\TestCase;
use src\br\com\caelum\leilao\dominio\LeilaoBuilder;
use src\br\com\caelum\leilao\dominio\EncerradorDeLeilao;

date_default_timezone_set("America/Sao_Paulo");

class EncerradorDeLeilaoTest extends TestCase
{
    public function testDeveEncerrarLeilaoComMaisDeUmaSemana()
    {
        $antiga = new \DateTime("2017-11-28 16:00:00");
        
        $criador = new LeilaoBuilder();
        $leilao = $criador->comDescricao("PlayStation4")
            ->naData($antiga)
            ->cria();
        
        $dao = $this->createMock(LeilaoCrudDao::class);
        $dao->method("correntes")
            ->will($this->returnValue([$leilao]));
        
        $encerrador = new EncerradorDeLeilao($dao);
        $encerrador->encerrar();
        
        $this->assertTrue($leilao->getEncerrado());
        $this->assertEquals(1, $encerrador->getTotal());
    }
}