<?php
/**
 * ==========================================================
 * CADASTRO DE USUÁRIO (cadastro_usuario.php)
 * ==========================================================
 */

require_once 'header.php';
?>

<div class="card formulario-box">
    <div class="card-titulo">
        <span>🔒 Cadastrar Novo Usuário</span>
    </div>

    <form action="salvar_usuario.php" method="POST">
        <div class="form-grupo">
            <label for="nome">Nome Completo:</label>
            <input type="text" id="nome" name="nome" required placeholder="Ex: João da Silva">
        </div>

        <div class="form-grupo">
            <label for="login">Login de Acesso:</label>
            <input type="text" id="login" name="login" required minlength="3" placeholder="Ex: joao.silva">
        </div>

        <div class="form-grupo">
            <label for="senha">Senha de Acesso:</label>
            <input type="password" id="senha" name="senha" required minlength="4" placeholder="Digite uma senha">
        </div>

        <div class="form-acoes">
            <input type="submit" value="Salvar Usuário" class="btn btn-azul">
            <a href="listar_usuarios.php" class="btn btn-cinza">Voltar / Cancelar</a>
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?>
