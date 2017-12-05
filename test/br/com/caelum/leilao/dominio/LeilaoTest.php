<?php
namespace test\br\com\caelum\leilao\dominio;

use PHPUnit\Framework\TestCase;
use src\br\com\caelum\leilao\dominio\Usuario;
use src\br\com\caelum\leilao\dominio\LeilaoBuilder;

class LeilaoTest extends TestCase
{
    private $usuario1;
    private $usuario2;
    private $usuario3;
    private $builder;
    
    /**
     * @before
     */
    public function startUsuarios()
    {
        $this->usuario1 = new Usuario("Joao");
        $this->usuario2 = new Usuario("Jose");
        $this->usuario3 = new Usuario("Maria");
        $this->builder = new LeilaoBuilder();
    }
    
    public function testDeveRetornarUmLance()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario1, 100.0)
            ->cria();
        
        $this->assertEquals(1, count($leilao->getLances()));
    }
    
    /**
     * @expectedException \RuntimeException
     */
    public function testDeveRetornarVariosLances()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario1, 100.0)
            ->comLance($this->usuario2, 50.0)
            ->comLance($this->usuario1, 140.0)
            ->cria();
        
        $this->assertEquals(1, count($leilao->getLances()));
    }
    
    /**
     * @expectedException \RuntimeException
     */
    public function testNaoDeveAceitarMaisDe5LancesPorUsuario()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario1, 100)
            ->comLance($this->usuario2, 200)
            ->comLance($this->usuario1, 300)
            ->comLance($this->usuario2, 400)
            ->comLance($this->usuario1, 500)
            ->comLance($this->usuario2, 600)
            ->comLance($this->usuario1, 700)
            ->comLance($this->usuario2, 800)
            ->comLance($this->usuario1, 900)
            ->comLance($this->usuario2, 1000)
            ->comLance($this->usuario1, 1100)
            ->cria();
        
        $this->assertEquals(10, count($leilao->getLances()));
    }
    
    /**
     * @expectedException \RuntimeException
     */
    public function testNaoDeveAceitarDoisLancesSeguidosPorUsuario()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario1, 100)
            ->comLance($this->usuario1, 200)
            ->cria();
        
        $this->assertEquals(1, count($leilao->getLances()));
    }
    
    /**
     * @expectedException \RuntimeException
     */
    public function testNaoDeveAceitarLancesMenorQueAnterior()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario1, 100)
            ->comLance($this->usuario2, 90)
            ->comLance($this->usuario1, 130)
            ->cria();
        
        $this->assertEquals(1, count($leilao->getLances()));
    }
}