<?php
namespace test\br\com\caelum\leilao\dominio;

use PHPUnit\Framework\TestCase;
use src\br\com\caelum\leilao\dominio\Avaliador;
use src\br\com\caelum\leilao\dominio\Lances;
use src\br\com\caelum\leilao\dominio\Leilao;
use src\br\com\caelum\leilao\dominio\Usuario;

class AvaliadorTest extends TestCase
{
    public function testInicial()
    {
        $joao = new Usuario ( "Joao" );
        $jose = new Usuario ( "Jose" );
        $maria = new Usuario ( "Maria" );
        
        $lances = [
            new Lances($joao, 300),
            new Lances($jose, 400),
            new Lances($maria, 200)
        ];
        
        $leilao = new Leilao ("PlayStation4", $lances);
        
        $leiloeiro = new Avaliador ();
        $leiloeiro->avalia ( $leilao );
        
        $maiorEsperado = 400;
        $medioEsperado = 300;
        $menorEsperado = 200;
        
        $this->assertEquals($maiorEsperado, $leiloeiro->getMaiorValor());
        $this->assertEquals($medioEsperado, $leiloeiro->getMedioValor());
        $this->assertEquals($menorEsperado, $leiloeiro->getMenorValor());
    }
    
    public function testAvaliadorComLancesCrescentes()
    {
        $joao = new Usuario("Joao");
        $pedro = new Usuario("Pedro");
        
        $lances = [
            new Lances($joao, 300),
            new Lances($pedro, 400),
            new Lances($joao, 500),
            new Lances($pedro, 600),
            new Lances($joao, 700)
        ];
        
        $leilao = new Leilao("PlayStation4", $lances);
        
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        
        $maiorEsperado = 700;
        $medioEsperado = 500;
        $menorEsperado = 300;
        
        $this->assertEquals($maiorEsperado, $leiloeiro->getMaiorValor());
        $this->assertEquals($medioEsperado, $leiloeiro->getMedioValor());
        $this->assertEquals($menorEsperado, $leiloeiro->getMenorValor());
    }

    public function testAvaliadorComLancesDecrescentes()
    {
        $joao = new Usuario ( "Joao" );
        $jose = new Usuario ( "Jose" );
        
        $lances = [
            new Lances($joao, 700),
            new Lances($jose, 600),
            new Lances($joao, 500),
            new Lances($jose, 400),
            new Lances($joao, 300)
        ];
        
        $leilao = new Leilao ("PlayStation4", $lances);
        
        $leiloeiro = new Avaliador ();
        $leiloeiro->avalia ( $leilao );
        
        $maiorEsperado = 700;
        $medioEsperado = 500;
        $menorEsperado = 300;
        
        $this->assertEquals($maiorEsperado, $leiloeiro->getMaiorValor());
        $this->assertEquals($medioEsperado, $leiloeiro->getMedioValor());
        $this->assertEquals($menorEsperado, $leiloeiro->getMenorValor());
    }

    public function testAvaliadorComUmLance()
    {
        $joao = new Usuario ( "Joao" );
        
        $lances = [
            new Lances($joao, 300)
        ];
        
        $leilao = new Leilao ("PlayStation4", $lances);
        
        $leiloeiro = new Avaliador ();
        $leiloeiro->avalia ( $leilao );
        
        $maiorEsperado = 300;
        $medioEsperado = 300;
        $menorEsperado = 300;
        
        $this->assertEquals($maiorEsperado, $leiloeiro->getMaiorValor());
        $this->assertEquals($medioEsperado, $leiloeiro->getMedioValor());
        $this->assertEquals($menorEsperado, $leiloeiro->getMenorValor());
    }

    public function testAvaliadorSemLance()
    {
        $lances = [];
        
        $leilao = new Leilao ("PlayStation4", $lances);
        
        $leiloeiro = new Avaliador ();
        $leiloeiro->avalia ( $leilao );
        
        $maiorEsperado = 0;
        $medioEsperado = 0;
        $menorEsperado = 0;
        
        $this->assertEquals($maiorEsperado, $leiloeiro->getMaiorValor());
        $this->assertEquals($medioEsperado, $leiloeiro->getMedioValor());
        $this->assertEquals($menorEsperado, $leiloeiro->getMenorValor());
    }
    
    public function testAvaliadorCom5Lances()
    {
        $joao = new Usuario("Joao");
        $maria = new Usuario("Maria");
        $jose = new Usuario("Jose");
        $matheus = new Usuario("Matheus");
        $abraao = new Usuario("Abraao");
        
        $lances = [
            new Lances($joao, 230),
            new Lances($maria, 310),
            new Lances($jose, 400),
            new Lances($matheus, 10),
            new Lances($abraao, 200)
        ];
        
        $leilao = new Leilao("PlayStation4", $lances);
        
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        
        $maiorEsperado = 400;
        $medioEsperado = 230;
        $menorEsperado = 10;
        
        $this->assertEquals($maiorEsperado, $leiloeiro->getMaiorValor());
        $this->assertEquals($medioEsperado, $leiloeiro->getMedioValor());
        $this->assertEquals($menorEsperado, $leiloeiro->getMenorValor());
    }
    
    public function testAvaliadorCom5LancesCrescente()
    {
        $joao = new Usuario("Joao");
        $maria = new Usuario("Maria");
        $jose = new Usuario("Jose");
        $matheus = new Usuario("Matheus");
        $abraao = new Usuario("Abraao");
        
        $lances = [
            new Lances($matheus, 10),
            new Lances($abraao, 200),
            new Lances($joao, 230),
            new Lances($maria, 310),
            new Lances($jose, 400)
        ];
        
        $leilao = new Leilao("PlayStation4", $lances);
        
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        
        $maiorEsperado = 400;
        $medioEsperado = 230;
        $menorEsperado = 10;
        
        $this->assertEquals($maiorEsperado, $leiloeiro->getMaiorValor());
        $this->assertEquals($medioEsperado, $leiloeiro->getMedioValor());
        $this->assertEquals($menorEsperado, $leiloeiro->getMenorValor());
    }
    
    public function testAvaliadorCom5LancesDecrescente()
    {
        $joao = new Usuario("Joao");
        $maria = new Usuario("Maria");
        $jose = new Usuario("Jose");
        $matheus = new Usuario("Matheus");
        $abraao = new Usuario("Abraao");
        
        $lances = [
            new Lances($jose, 400),
            new Lances($maria, 310),
            new Lances($joao, 230),
            new Lances($abraao, 200),
            new Lances($matheus, 10)
        ];
        
        $leilao = new Leilao("PlayStation4", $lances);
        
        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        
        $maiorEsperado = 400;
        $medioEsperado = 230;
        $menorEsperado = 10;
        
        $this->assertEquals($maiorEsperado, $leiloeiro->getMaiorValor());
        $this->assertEquals($medioEsperado, $leiloeiro->getMedioValor());
        $this->assertEquals($menorEsperado, $leiloeiro->getMenorValor());
    }
    
    public function testAvaliadorCom3MaioresLances()
    {
        $joao = new Usuario("Joao");
        $jose = new Usuario("Jose");
        $maria = new Usuario("Maria");
        
        $lances = [
            new Lances($jose, 400),
            new Lances($maria, 500),
            new Lances($joao, 600),
            new Lances($joao, 300),
            new Lances($jose, 700),
            new Lances($maria, 800)
        ];
        
        $leilao = new Leilao("PlayStation4", $lances);

        $leiloeiro = new Avaliador();
        $leiloeiro->avalia($leilao);
        
        $tresMaioresEsperado = [800, 700, 600];
        
        $this->assertEquals(3, count($leiloeiro->getTresMaiores()));
        $this->assertEquals($tresMaioresEsperado, $leiloeiro->getTresMaiores());
        
    }
}
?>