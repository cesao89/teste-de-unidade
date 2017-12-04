<?php
namespace test\br\com\caelum\leilao\dominio;

use PHPUnit\Framework\TestCase;
use src\br\com\caelum\leilao\dominio\Usuario;
use src\br\com\caelum\leilao\dominio\FiltroDeLances;
use src\br\com\caelum\leilao\dominio\Lances;

class FiltroDeLancesTest extends TestCase
{
    public function testDeveSelecionarLancesEntre1000E3000()
    {
        $joao = new Usuario("Joao");
        
        $filtro = new FiltroDeLances();
        
        $resultado = $filtro->filtra(array(
            new Lances($joao, 2000),
            new Lances($joao, 1000),
            new Lances($joao, 3000),
            new Lances($joao, 800)
        ));
        
        $this->assertEquals(1, count($resultado));
        $this->assertEquals(2000, $resultado[0]->getValor(), 0.00001);
    }
    
    public function testDeveSelecionarLancesEntre500E700()
    {
        $joao = new Usuario("Joao");
        
        $filtro = new FiltroDeLances();
        
        $resultado = $filtro->filtra(array(
            new Lances($joao, 600),
            new Lances($joao, 500),
            new Lances($joao, 700),
            new Lances($joao, 800)
        ));
        
        $this->assertEquals(1, count($resultado));
        $this->assertEquals(600, $resultado[0]->getValor(), 0.00001);
    }
}