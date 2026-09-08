<?php
$host = "127.0.0.1";
$usuario = "root";
$senha = "123456";
$banco = "sistema_equipes";

try {
    // Cria a conexão usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    
    // Configura o PDO para mostrar erros na tela, caso algo dê errado
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Conexão com o banco de dados realizada com sucesso!";
} catch (PDOException $erro) {
    echo "Erro de conexão: " . $erro->getMessage();
}
?>