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
        $antiga = (new \DateTime())->sub(new \DateInterval("P7D"));
        
        $criador = new LeilaoBuilder();
        $leilao = $criador->comDescricao("PlayStation4")
            ->naData($antiga)
            ->cria();
        
        $dao = $this->createMock(LeilaoCrudDao::class);
        $dao->method("correntes")->will($this->returnValue([$leilao]));
        $dao->expects($this->atLeastOnce())->method("atualiza");
        
        $carteiro = $this->createMock(EnviadorDeEmailCrud::class);
        
        $encerrador = new EncerradorDeLeilao($dao, $carteiro);
        $encerrador->encerrar();
        
        $this->assertTrue($leilao->getEncerrado());
        $this->assertEquals(1, $encerrador->getTotal());
    }

    public function testNaoDeveAtualizarLeiloesEncerrados()
    {
        $antiga = (new \DateTime())->sub(new \DateInterval("P6D"));
        
        $leilao = new LeilaoBuilder();
        $leilao = $leilao->comDescricao("TV de Plasma")
            ->naData($antiga)
            ->cria();
        
        $dao = $this->createMock(LeilaoCrudDao::class);
        $dao->expects($this->never())->method("atualiza");
        $dao->method("correntes")->will($this->returnValue(array($leilao)));
        
        $carteiro = $this->createMock(EnviadorDeEmailCrud::class);
        
        $encerrador = new EncerradorDeLeilao($dao, $carteiro);
        $encerrador->encerrar();
        
        $this->assertFalse($leilao->getEncerrado());
        $this->assertEquals(0, $encerrador->getTotal());
    }
    
    public function testDeveAtualizarLeiloesEncerradosAtLeast()
    {
        $antiga = (new \DateTime())->sub(new \DateInterval("P7D"));
        
        $leilao = new LeilaoBuilder();
        $leilao = $leilao->comDescricao("TV de Plasma")
            ->naData($antiga)
            ->cria();
        
        $dao = $this->createMock(LeilaoCrudDao::class);
        $dao->expects($this->atLeast(1))->method("atualiza");
        $dao->method("correntes")->will($this->returnValue(array($leilao)));
        
        $carteiro = $this->createMock(EnviadorDeEmailCrud::class);
        
        $encerrador = new EncerradorDeLeilao($dao, $carteiro);
        $encerrador->encerrar();
        
        $this->assertTrue($leilao->getEncerrado());
        $this->assertEquals(1, $encerrador->getTotal());
    }
    
    public function testDeveAtualizarLeiloesEncerradosAtMost()
    {
        $antiga = (new \DateTime())->sub(new \DateInterval("P7D"));
        
        $leilao = new LeilaoBuilder();
        $leilao = $leilao->comDescricao("TV de Plasma")
        ->naData($antiga)
        ->cria();
        
        $dao = $this->createMock(LeilaoCrudDao::class);
        $dao->expects($this->atMost(1))->method("atualiza");
        $dao->method("correntes")->will($this->returnValue(array($leilao)));
        
        $carteiro = $this->createMock(EnviadorDeEmailCrud::class);
        
        $encerrador = new EncerradorDeLeilao($dao, $carteiro);
        $encerrador->encerrar();
        
        $this->assertTrue($leilao->getEncerrado());
        $this->assertEquals(1, $encerrador->getTotal());
    }
    
    public function testDeveEnviarEmailParaLeiloesEncerrados()
    {
        $antiga = (new \DateTime())->sub(new \DateInterval("P7D"));
        
        $leilao = new LeilaoBuilder();
        $leilao = $leilao->comDescricao("TV de Plasma")
        ->naData($antiga)
        ->cria();
        
        $dao = $this->createMock(LeilaoCrudDao::class);
        $dao->expects($this->atLeastOnce())->method("atualiza");
        $dao->method("correntes")->will($this->returnValue(array($leilao)));
        
        $carteiro = $this->createMock(EnviadorDeEmailCrud::class);
        $carteiro->expects($this->atLeastOnce())->method("envia");
        
        $encerrador = new EncerradorDeLeilao($dao, $carteiro);
        $encerrador->encerrar();
        
        $this->assertTrue($leilao->getEncerrado());
        $this->assertEquals(1, $encerrador->getTotal());
    }
    
    public function testDeveContinuarAExecucaoMesmoQuandoDaoFalha()
    {
        $antiga = (new \DateTime())->sub(new \DateInterval("P7D"));
        
        $leilao1 = new LeilaoBuilder();
        $leilao1 = $leilao1->comDescricao("TV de Plasma")
            ->naData($antiga)
            ->cria();
        
        $leilao2 = new LeilaoBuilder();
        $leilao2 = $leilao2->comDescricao("Geladeira")
            ->naData($antiga)
            ->cria();
        
        $dao = $this->createMock(LeilaoCrudDao::class);
        $dao->method("correntes")->will($this->returnValue([$leilao1, $leilao2]));
        $dao->method("atualiza")->will($this->throwException(new \RuntimeException("Erro ao se conectar ao DAO")));
        
        $carteiro = $this->createMock(EnviadorDeEmailCrud::class);
        $carteiro->expects($this->never())->method("envia");
        
        $encerrador = new EncerradorDeLeilao($dao, $carteiro);
        $encerrador->encerrar();
        
        $this->assertTrue($leilao1->getEncerrado());
        $this->assertTrue($leilao2->getEncerrado());
        $this->assertEquals(0, $encerrador->getTotal());
    }
}