<?php
// 1. Recebe os dados do formulário
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$nascimento = $_POST['nascimento'];
$telefone = $_POST['telefone'];
$pessoa_tipo_id = $_POST['pessoa_tipo_id'];

// Dados automáticos exigidos pelo banco
$atualizado_por = 1; 
$atualizado_em = date('Y-m-d'); // Pega a data de hoje do servidor

try {
    // 2. Conecta no Banco de Dados
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sistema_equipes", "root", "123456");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. Prepara o envio protegendo contra falhas
    $sql = $pdo->prepare("INSERT INTO tbPessoas (nome, cpf, nascimento, telefone, pessoa_tipo_id, atualizado_por, atualizado_em) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // 4. Executa a ação
    $sql->execute([$nome, $cpf, $nascimento, $telefone, $pessoa_tipo_id, $atualizado_por, $atualizado_em]);

    echo "<h3>Pessoa '$nome' cadastrada com sucesso!</h3>";

} catch (PDOException $erro) {
    echo "Erro ao cadastrar: " . $erro->getMessage();
}
?>