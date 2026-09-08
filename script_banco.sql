-- Criação do Banco de Dados
CREATE DATABASE IF NOT EXISTS sistema_equipes;
USE sistema_equipes;

-- Tabela: dominio.tbPessoaTipo
CREATE TABLE tbPessoaTipo (
    pessoa_tipo_id INT(10) PRIMARY KEY AUTO_INCREMENT,
    descricao VARCHAR(200) NOT NULL UNIQUE
);

-- Tabela: seguranca.tbUsuarios
CREATE TABLE tbUsuarios (
    usuario_id INT(10) PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    atualizado_por INT(10)
);

-- Tabela: cadastro.tbPessoas
CREATE TABLE tbPessoas (
    pessoa_id INT(11) PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    nascimento DATE NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    pessoa_tipo_id INT(10) NOT NULL,
    atualizado_por INT(10) NOT NULL,
    atualizado_em DATE NOT NULL,
    FOREIGN KEY (pessoa_tipo_id) REFERENCES tbPessoaTipo(pessoa_tipo_id)
);

-- Tabela: tbEquipe
CREATE TABLE tbEquipe (
    equipe_id INT(10) PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL UNIQUE,
    atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    atualizado_por INT(10) NOT NULL
);

-- Tabela: tbMembros
CREATE TABLE tbMembros (
    membros_id INT(10) PRIMARY KEY AUTO_INCREMENT,
    atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    equipe_id INT(10) NOT NULL,
    membro_id INT(11) NOT NULL,
    atualizado_por INT(10),
    FOREIGN KEY (equipe_id) REFERENCES tbEquipe(equipe_id),
    FOREIGN KEY (membro_id) REFERENCES tbPessoas(pessoa_id)
);