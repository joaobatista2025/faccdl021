<?php
/**
 * ==========================================================
 * PROCESSA O VÍNCULO DE MEMBRO (salvar_membro.php)
 * ==========================================================
 */

require_once 'conexao.php';
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipe_id = (int)$_POST['equipe_id'];
    $membro_id = (int)$_POST['membro_id'];
    $atualizado_por = 1;

    try {
        // 1. Valida se esse membro já está vinculado a essa equipe
        $check = $pdo->prepare("SELECT COUNT(*) FROM tbMembros WHERE equipe_id = ? AND membro_id = ?");
        $check->execute([$equipe_id, $membro_id]);
        $jaExiste = $check->fetchColumn();

        if ($jaExiste > 0) {
            echo "<div class='card formulario-box'>
                    <div class='alerta alerta-erro'>
                        <h3>⚠️ Vínculo Já Existe!</h3>
                        <p>Esta pessoa já faz parte desta equipe.</p>
                    </div>
                    <div style='display:flex; gap:10px;'>
                        <a href='cadastro_membro.php' class='btn btn-roxo'>Tentar Outro Vínculo</a>
                        <a href='listar_membros.php' class='btn btn-cinza'>Ver Lista de Membros</a>
                    </div>
                  </div>";
        } else {
            // 2. Insere o vínculo na tabela tbMembros
            $sql = $pdo->prepare("INSERT INTO tbMembros (equipe_id, membro_id, atualizado_por) VALUES (?, ?, ?)");
            $sql->execute([$equipe_id, $membro_id, $atualizado_por]);

            echo "<div class='card formulario-box'>
                    <div class='alerta alerta-sucesso'>
                        <h3>✅ Vínculo Realizado com Sucesso!</h3>
                        <p>A pessoa foi adicionada à equipe selecionada.</p>
                    </div>
                    <div style='display:flex; gap:10px;'>
                        <a href='cadastro_membro.php' class='btn btn-roxo'>+ Vincular Outro</a>
                        <a href='listar_membros.php' class='btn btn-cinza'>Ver Lista</a>
                        <a href='index.php' class='btn btn-cinza'>Início</a>
                    </div>
                  </div>";
        }

    } catch (PDOException $erro) {
        echo "<div class='card formulario-box'>
                <div class='alerta alerta-erro'>
                    <h3>❌ Erro ao vincular membro:</h3>
                    <p>" . $erro->getMessage() . "</p>
                </div>
                <a href='cadastro_membro.php' class='btn btn-cinza'>Tentar Novamente</a>
              </div>";
    }
} else {
    header('Location: listar_membros.php');
    exit;
}

require_once 'footer.php';
?>