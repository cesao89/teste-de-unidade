<?php
namespace src\br\com\caelum\leilao\servicos;

use src\br\com\caelum\leilao\interfaces\Relogio;

class RelogioDoSistema implements Relogio
{
    public function hoje()
    {
        return new \DateTime();
    }
}