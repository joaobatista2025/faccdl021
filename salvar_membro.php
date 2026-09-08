<?php
// 1. Recebe os IDs digitados
$membro_id = $_POST['membro_id'];
$equipe_id = $_POST['equipe_id'];

$atualizado_por = 1; // Administrador padrão

try {
    // 2. Conecta no Banco de Dados
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=sistema_equipes", "root", "123456");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 3. Prepara e salva o vínculo
    $sql = $pdo->prepare("INSERT INTO tbMembros (equipe_id, membro_id, atualizado_por) VALUES (?, ?, ?)");
    $sql->execute([$equipe_id, $membro_id, $atualizado_por]);

    echo "<h3>Vínculo criado com sucesso! A pessoa agora faz parte da equipe.</h3>";

} catch (PDOException $erro) {
    echo "Erro ao vincular: " . $erro->getMessage();
}
?>