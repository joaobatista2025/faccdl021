<?php
/**
 * ARQUIVO DE CONEXÃO COM O BANCO DE DADOS (conexao.php)
 * Utiliza PDO (PHP Data Objects), o padrão moderno e seguro do PHP.
 */

// Configurações de Conexão (Local / XAMPP / MySQL Workbench)
$host    = "127.0.0.1";        // Endereço do servidor MySQL
$banco   = "sistema_equipes";  // Nome do banco de dados
$usuario = "root";             // Usuário do banco
$senha   = "123456";           // Senha do banco (se estiver na Locaweb, altere aqui)

try {
    // 1. Cria o objeto PDO para conectar ao MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    
    // 2. Configura o PDO para lançar exceções caso ocorra algum erro de SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 3. Configura para retornar resultados como arrays associativos por padrão
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $erro) {
    // Se a conexão falhar, exibe uma mensagem amigável e interrompe
    die("<div style='color:red; font-family:Arial; padding:20px;'>
            <h3>Erro ao conectar com o banco de dados!</h3>
            <p><strong>Detalhe do erro:</strong> " . $erro->getMessage() . "</p>
            <p>Verifique se o MySQL está rodando e se os dados em <code>conexao.php</code> estão corretos.</p>
         </div>");
}
?>