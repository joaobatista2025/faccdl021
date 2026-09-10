<?php
/**
 * ==========================================================
 * CADASTRO DE EQUIPE (cadastro_equipe.php)
 * ==========================================================
 */

require_once 'header.php';
?>

<div class="card formulario-box">
    <div class="card-titulo">
        <span>💼 Criar Nova Equipe</span>
    </div>

    <form action="salvar_equipe.php" method="POST">
        <div class="form-grupo">
            <label for="nome">Nome da Equipe / Time:</label>
            <input type="text" id="nome" name="nome" required minlength="3" placeholder="Ex: Equipe de Desenvolvimento Web">
        </div>

        <div class="form-acoes">
            <input type="submit" value="Salvar Equipe" class="btn btn-verde">
            <a href="listar_equipes.php" class="btn btn-cinza">Voltar / Cancelar</a>
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?>
