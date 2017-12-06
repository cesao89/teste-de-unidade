<?php
namespace src\br\com\caelum\leilao\dao;

use src\br\com\caelum\leilao\dominio\Usuario;

class UsuarioDao
{
    private $con;
    
    public function __construct(PDO $con)
    {
        $this->con = $con;
    }
    
    public function porId(int $id)
    {
        $stmt = $this->con->prepare("SELECT * FROM Usuario WHERE id = :id");
        $stmt->bindParam("id", $id);
        
        $function = $stmt->execute();
        
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Usuario::class);
        $usuario = $stmt->fetch();
        
        return $usuario;
    }
    
    public function porNomeEEmail(string $nome, string $email)
    {
        $stmt = $this->con->prepare("SELECT * FROM Usuario WHERE nome = :nome AND email = :email");
        $stmt->bindParam("nome", $nome);
        $stmt->bindParam("email", $email);
        $stmt->execute();
        
        $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Usuario::class);
        $usuario = $stmt->fetch();
        
        return $usuario;
    }
}