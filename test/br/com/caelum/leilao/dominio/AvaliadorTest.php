<?php
namespace test\br\com\caelum\leilao\dominio;

use PHPUnit\Framework\TestCase;
use src\br\com\caelum\leilao\dominio\Avaliador;
use src\br\com\caelum\leilao\dominio\Usuario;
use src\br\com\caelum\leilao\dominio\LeilaoBuilder;

class AvaliadorTest extends TestCase
{
    private $builder;
    private $avaliador;
    private $usuario1;
    private $usuario2;
    private $usuario3;
    private $usuario4;
    private $usuario5;
    
    /**
     * @beforeClass
     */
    public static function comeco()
    {
        echo "\nInicia os Testes";
    }
    
    /**
     * @before
     */
    public function antes()
    {
        echo "\nInicio";
        $this->avaliador = new Avaliador();
        $this->builder = new LeilaoBuilder();
        $this->usuario1 = new Usuario("Joao");
        $this->usuario2 = new Usuario("Jose");
        $this->usuario3 = new Usuario("Maria");
        $this->usuario4 = new Usuario("Abraao");
        $this->usuario5 = new Usuario("Matheus");
    }
    
    /**
     * @afterClass
     */
    public static function fim()
    {
        echo "\nFim dos Testes\n\n";
    }
    
    /**
     * @after
     */
    public function depois()
    {
        echo "\nFim";
    }
    
    public function testInicial()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario1, 300)
            ->comLance($this->usuario2, 400)
            ->comLance($this->usuario3, 200)
            ->cria();
        
        $this->avaliador->avalia($leilao);
        
        $this->assertEquals(400, $this->avaliador->getMaiorValor());
        $this->assertEquals(350, $this->avaliador->getMedioValor());
        $this->assertEquals(300, $this->avaliador->getMenorValor());
    }
    
    public function testAvaliadorComLancesCrescentes()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario1, 300)
            ->comLance($this->usuario2, 400)
            ->comLance($this->usuario1, 500)
            ->comLance($this->usuario2, 600)
            ->comLance($this->usuario1, 700)
            ->cria();
        
        $this->avaliador->avalia($leilao);
        
        $this->assertEquals(700, $this->avaliador->getMaiorValor());
        $this->assertEquals(500, $this->avaliador->getMedioValor());
        $this->assertEquals(300, $this->avaliador->getMenorValor());
    }

    public function testAvaliadorComLancesDecrescentes()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario1, 700)
            ->comLance($this->usuario2, 600)
            ->comLance($this->usuario1, 500)
            ->comLance($this->usuario2, 400)
            ->comLance($this->usuario1, 300)
            ->cria();
        
        $this->avaliador->avalia ( $leilao );
        
        $this->assertEquals(700, $this->avaliador->getMaiorValor());
        $this->assertEquals(700, $this->avaliador->getMedioValor());
        $this->assertEquals(700, $this->avaliador->getMenorValor());
    }

    public function testAvaliadorComUmLance()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario1, 300)
            ->cria();
        
        $this->avaliador->avalia ( $leilao );
        
        $this->assertEquals(300, $this->avaliador->getMaiorValor());
        $this->assertEquals(300, $this->avaliador->getMedioValor());
        $this->assertEquals(300, $this->avaliador->getMenorValor());
    }
    
    /**
     * @expectedException \RuntimeException
     */
    public function testAvaliadorSemLance()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
        ->cria();
        
        $this->avaliador->avalia($leilao);
        
        $this->assertEquals(0, $this->avaliador->getMaiorValor());
        $this->assertEquals(0, $this->avaliador->getMedioValor());
        $this->assertEquals(0, $this->avaliador->getMenorValor());
    }
    
    public function testAvaliadorCom5Lances()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario1, 230)
            ->comLance($this->usuario2, 310)
            ->comLance($this->usuario3, 400)
            ->comLance($this->usuario4, 10)
            ->comLance($this->usuario5, 200)
            ->cria();
        
        $this->avaliador->avalia($leilao);
        
        $this->assertEquals(400, $this->avaliador->getMaiorValor());
        $this->assertEquals(313.3333333333333, $this->avaliador->getMedioValor());
        $this->assertEquals(230, $this->avaliador->getMenorValor());
    }
    
    public function testAvaliadorCom5LancesCrescente()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario1, 10)
            ->comLance($this->usuario2, 200)
            ->comLance($this->usuario3, 230)
            ->comLance($this->usuario4, 310)
            ->comLance($this->usuario5, 400)
            ->cria();
        
        $this->avaliador->avalia($leilao);
        
        $this->assertEquals(400, $this->avaliador->getMaiorValor());
        $this->assertEquals(230, $this->avaliador->getMedioValor());
        $this->assertEquals(10, $this->avaliador->getMenorValor());
    }
    
    public function testAvaliadorCom5LancesDecrescente()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario1, 400)
            ->comLance($this->usuario2, 310)
            ->comLance($this->usuario3, 230)
            ->comLance($this->usuario4, 200)
            ->comLance($this->usuario5, 10)
            ->cria();
        
        $this->avaliador->avalia($leilao);
        
        $this->assertEquals(400, $this->avaliador->getMaiorValor());
        $this->assertEquals(400, $this->avaliador->getMedioValor());
        $this->assertEquals(400, $this->avaliador->getMenorValor());
    }
    
    public function testAvaliadorCom3MaioresLances()
    {
        $leilao = $this->builder->comDescricao("PlayStation4")
            ->comLance($this->usuario2, 400)
            ->comLance($this->usuario3, 500)
            ->comLance($this->usuario1, 600)
            ->comLance($this->usuario1, 300)
            ->comLance($this->usuario2, 700)
            ->comLance($this->usuario3, 800)
            ->cria();

        $this->avaliador->avalia($leilao);
        
        $this->assertEquals(3, count($this->avaliador->getTresMaiores()));
        $this->assertEquals([800, 700, 600], $this->avaliador->getTresMaiores());
        
    }
}
?>