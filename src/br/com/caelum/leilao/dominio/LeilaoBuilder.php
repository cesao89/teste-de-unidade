<?php
namespace src\br\com\caelum\leilao\dominio;

class LeilaoBuilder
{
    private $leilao;

    public function __construct()
    {
        $this->leilao = new Leilao();
    }
    
    public function comLance(Usuario $usuario, float $valor)
    {
        $this->leilao->propoe(new Lances($usuario, $valor));    
        return $this;
    }
    
    public function comDescricao(string $descricao)
    {
        $this->leilao->setDescricao($descricao);
        return $this;
    }
    
    public function naData(\DateTime $data)
    {
        $this->leilao->setData($data);
        return $this;
    }
    
    public function cria()
    {
        return $this->leilao;
    }
}