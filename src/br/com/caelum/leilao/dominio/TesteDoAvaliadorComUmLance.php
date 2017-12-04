<?php
namespace src\br\com\caelum\leilao;

require_once ("vendor/autoload.php");

use src\br\com\caelum\leilao\dominio\Avaliador;
use src\br\com\caelum\leilao\dominio\Lances;
use src\br\com\caelum\leilao\dominio\Leilao;
use src\br\com\caelum\leilao\dominio\Usuario;

$joao = new Usuario ( "Joao" );

$lances = [
	new Lances($joao, 300)
];

$leilao = new Leilao ("PlayStation4", $lances);

$leiloeiro = new Avaliador ();
$leiloeiro->avalia ( $leilao );

echo "Maior Valor: " . $leiloeiro->getMaiorValor () . "\n";
echo "Menor Valor: " . $leiloeiro->getMenorValor () . "\n";
?>