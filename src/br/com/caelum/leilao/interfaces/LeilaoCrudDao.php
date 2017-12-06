<?php
namespace src\br\com\caelum\leilao\interfaces;

interface LeilaoCrudDao
{
    public function correntes();
    public function atualiza();
    public function encerrados();
}