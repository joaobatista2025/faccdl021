<?php
// 1. RECEBENDO OS DADOS DO FORMULÁRIO (HTML)
$nome = $_POST['nome'];
$login = $_POST['login'];
$senha = $_POST['senha'];

try {
    // 2. CONECTANDO AO BANCO DE DADOS
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sistema_equipes", "root", "123456");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. PREPARANDO O COMANDO SQL (Evita invasões de hackers)
    $sql = $pdo->prepare("INSERT INTO tbUsuarios (nome, login, senha) VALUES (?, ?, ?)");

    // 4. EXECUTANDO E SALVANDO NO BANCO
    $sql->execute([$nome, $login, $senha]);

    echo "<h3>Usuário cadastrado com sucesso!</h3>";

} catch (PDOException $erro) {
    echo "Erro ao cadastrar: " . $erro->getMessage();
}
?>