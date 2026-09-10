<?php
/**
 * ==========================================================
 * CABEÇALHO PADRÃO DO SISTEMA (header.php)
 * Inclui o topo visual, título, CSS e o menu de navegação.
 * ==========================================================
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Organização de Equipes</title>
    <!-- Vincula a folha de estilos CSS oficial -->
    <link rel="stylesheet" href="estilo.css">
</head>
<body>

    <!-- Barra de Navegação Superior -->
    <header class="topo-navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-logo">
                👥 <span>Equipes</span> Manager
            </a>
            <nav>
                <ul class="navbar-menu">
                    <li><a href="index.php">🏠 Início</a></li>
                    <li><a href="listar_pessoas.php">👤 Pessoas</a></li>
                    <li><a href="listar_equipes.php">💼 Equipes</a></li>
                    <li><a href="listar_membros.php">🔗 Membros</a></li>
                    <li><a href="listar_tipos.php">🏷️ Papéis</a></li>
                    <li><a href="listar_usuarios.php">🔒 Usuários</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Início do Container Principal da Página -->
    <main class="container">
