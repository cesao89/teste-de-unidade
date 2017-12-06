<?php
namespace test\br\com\caelum\leilao\dominio;

use src\br\com\caelum\leilao\dominio\Leilao;

interface EnviadorDeEmailCrud
{
    public function envia(Leilao $leilao);
}