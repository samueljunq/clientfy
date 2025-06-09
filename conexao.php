<?php
$servidor = "localhost";
$usuario = "root";
$senha = "Samuca2013@"; 
$banco = "sistema_clientes";
$porta = 3307; 

$conn = new mysqli($servidor, $usuario, $senha, $banco, $porta);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
