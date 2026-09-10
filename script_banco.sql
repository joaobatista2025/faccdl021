-- ==========================================================
-- SISTEMA DE ORGANIZAÇÃO DE EQUIPES (Tema 021)
-- Script do Banco de Dados MySQL
-- Alinhado 100% com o Diagrama Entidade-Relacionamento (DER)
-- ==========================================================

-- 1. Criação do Banco de Dados
CREATE DATABASE IF NOT EXISTS `sistema_equipes` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sistema_equipes`;

-- 2. Limpeza prévia para garantir execução limpa
DROP TABLE IF EXISTS `tbMembros`;
DROP TABLE IF EXISTS `tbEquipe`;
DROP TABLE IF EXISTS `tbPessoas`;
DROP TABLE IF EXISTS `tbUsuarios`;
DROP TABLE IF EXISTS `tbPessoaTipo`;

-- 3. Tabela: dominio.tbPessoaTipo (Papéis / Cargos)
CREATE TABLE `tbPessoaTipo` (
    `pessoa_tipo_id` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(200) NOT NULL,
    PRIMARY KEY (`pessoa_tipo_id`),
    UNIQUE KEY `uk_tipo_descricao` (`descricao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabela: seguranca.tbUsuarios (Acesso e Login)
CREATE TABLE `tbUsuarios` (
    `usuario_id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(200) NOT NULL,
    `login` VARCHAR(50) NOT NULL,
    `senha` VARCHAR(255) NOT NULL,
    `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `atualizado_por` INT DEFAULT 1,
    PRIMARY KEY (`usuario_id`),
    UNIQUE KEY `uk_usuario_login` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabela: cadastro.tbPessoas (Profissionais / Membros)
CREATE TABLE `tbPessoas` (
    `pessoa_id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(200) NOT NULL,
    `cpf` VARCHAR(14) NOT NULL,
    `nascimento` DATE NOT NULL,
    `telefone` VARCHAR(20) NOT NULL,
    `pessoa_tipo_id` INT NOT NULL,
    `atualizado_por` INT NOT NULL DEFAULT 1,
    `atualizado_em` DATE NOT NULL,
    PRIMARY KEY (`pessoa_id`),
    UNIQUE KEY `uk_pessoa_cpf` (`cpf`),
    CONSTRAINT `fk_pessoas_tipo` FOREIGN KEY (`pessoa_tipo_id`) REFERENCES `tbPessoaTipo` (`pessoa_tipo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tabela: tbEquipe (Times / Equipes)
CREATE TABLE `tbEquipe` (
    `equipe_id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(200) NOT NULL,
    `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `atualizado_por` INT DEFAULT 1,
    PRIMARY KEY (`equipe_id`),
    UNIQUE KEY `uk_equipe_nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Tabela: tbMembros (Vínculo de Pessoas às Equipes)
CREATE TABLE `tbMembros` (
    `membros_id` INT NOT NULL AUTO_INCREMENT,
    `atualizado_em` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `equipe_id` INT NOT NULL,
    `membro_id` INT NOT NULL,
    `atualizado_por` INT DEFAULT 1,
    PRIMARY KEY (`membros_id`),
    CONSTRAINT `fk_membros_equipe` FOREIGN KEY (`equipe_id`) REFERENCES `tbEquipe` (`equipe_id`) ON DELETE CASCADE,
    CONSTRAINT `fk_membros_pessoa` FOREIGN KEY (`membro_id`) REFERENCES `tbPessoas` (`pessoa_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ==========================================================
-- DADOS INICIAIS DE TESTE (Para o sistema já abrir preenchido)
-- ==========================================================

-- Inserindo os papéis do sistema
INSERT INTO `tbPessoaTipo` (`pessoa_tipo_id`, `descricao`) VALUES
(1, 'Gerente de Projetos / Scrum Master'),
(2, 'Líder de Equipe'),
(3, 'Membro da Equipe / Desenvolvedor'),
(4, 'Stakeholder / Cliente Interno'),
(5, 'RH / Administrador do Sistema');

-- Inserindo usuário de acesso
INSERT INTO `tbUsuarios` (`usuario_id`, `nome`, `login`, `senha`, `atualizado_por`) VALUES
(1, 'Administrador do Sistema', 'admin', '123456', 1);

-- Inserindo pessoas de exemplo
INSERT INTO `tbPessoas` (`pessoa_id`, `nome`, `cpf`, `nascimento`, `telefone`, `pessoa_tipo_id`, `atualizado_por`, `atualizado_em`) VALUES
(1, 'Carlos Silva', '111.222.333-44', '1990-05-15', '(11) 98888-1111', 1, 1, '2026-09-10'),
(2, 'Ana Souza', '222.333.444-55', '1995-08-20', '(11) 97777-2222', 2, 1, '2026-09-10'),
(3, 'Lucas Pereira', '333.444.555-66', '1998-02-10', '(11) 96666-3333', 3, 1, '2026-09-10'),
(4, 'Mariana Oliveira', '444.555.666-77', '2000-11-25', '(11) 95555-4444', 3, 1, '2026-09-10');

-- Inserindo equipes de exemplo
INSERT INTO `tbEquipe` (`equipe_id`, `nome`, `atualizado_por`) VALUES
(1, 'Equipe Alpha (Front-End & UX)', 1),
(2, 'Equipe Beta (Back-End & Banco)', 1);

-- Vinculando membros às equipes
INSERT INTO `tbMembros` (`membros_id`, `equipe_id`, `membro_id`, `atualizado_por`) VALUES
(1, 1, 1, 1),
(2, 1, 3, 1),
(3, 2, 2, 1),
(4, 2, 4, 1);
