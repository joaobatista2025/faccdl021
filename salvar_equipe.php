<?php
// 1. Recebe o nome digitado na tela
$nome_equipe = $_POST['nome'];
$atualizado_por = 1; // ID provisório do administrador logado

try {
    // 2. Conecta no Banco de Dados
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sistema_equipes", "root", "123456");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. Prepara o envio para a tabela tbEquipe
    $sql = $pdo->prepare("INSERT INTO tbEquipe (nome, atualizado_por) VALUES (?, ?)");

    // 4. Executa a ação
    $sql->execute([$nome_equipe, $atualizado_por]);

    echo "<h3>Equipe '$nome_equipe' criada com sucesso!</h3>";

} catch (PDOException $erro) {
    echo "Erro ao criar equipe: " . $erro->getMessage();
}
?>