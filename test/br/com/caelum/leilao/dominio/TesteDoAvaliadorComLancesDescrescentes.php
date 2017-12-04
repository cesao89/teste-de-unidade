<?php
namespace test\br\com\caelum\leilao;

require_once ("vendor/autoload.php");

use src\br\com\caelum\leilao\dominio\Avaliador;
use src\br\com\caelum\leilao\dominio\Lances;
use src\br\com\caelum\leilao\dominio\Leilao;
use src\br\com\caelum\leilao\dominio\Usuario;

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

echo "Maior Valor: " . $leiloeiro->getMaiorValor () . "\n";
echo "Menor Valor: " . $leiloeiro->getMenorValor () . "\n";
?>