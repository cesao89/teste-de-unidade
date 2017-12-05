<?php 
namespace src\br\com\caelum\leilao\dominio;

class Lances {
	private $valor;
	private $usuario;
	
	public function __construct(Usuario $usuario, float $valor)
	{
		$this->valor = $valor;
		$this->usuario = $usuario;
	}
	
	public function getValor()
	{
		return $this->valor;
	}
	
	public function getUsuario()
	{
		return $this->usuario;
	}
	
	public function setValor(float $valor)
	{
		$this->valor = $valor;
	}
	
	public function setUsuario(Usuario $usuario)
	{
		$this->usuario = $usuario;
	}
}
?>