# 🎓 GUIA DE ESTUDOS - EXPLICAÇÃO LINHA POR LINHA
## Disciplina: Programação Web | Professor: Hiran Savir
### Sistema 021 - Sistema de Organização de Equipes

Este guia foi feito exatamente para quando o professor apontar para a tela e perguntar: **"O que essa linha de código faz?"**

---

## 📌 1. ARQUIVO `conexao.php` (Conexão com o Banco)

```php
$host = "127.0.0.1";
$banco = "sistema_equipes";
$usuario = "root";
$senha = "123456";
```
* **O que responder:** "Essas variáveis guardam as configurações para acessar o MySQL: o endereço do servidor (`$host`), o nome da nossa base de dados (`$banco`), o nome do usuário (`$usuario`) e a senha (`$senha`)."

```php
$pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
```
* **O que responder:** "Essa linha cria o objeto de conexão chamado `$pdo` usando a classe nativa do PHP chamada `PDO`. Ela abre a comunicação entre o nosso site PHP e o banco de dados MySQL."

```php
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```
* **O que responder:** "Essa linha configura o PDO para disparar um alerta de erro (uma exceção) caso algum comando SQL esteja errado, facilitando encontrar falhas."

```php
try { ... } catch (PDOException $erro) { ... }
```
* **O que responder:** "É o bloco de tratamento de erros. O `try` tenta conectar. Se o banco estiver fora do ar ou a senha errada, o `catch` captura o erro e evita que a página trave feia, mostrando uma mensagem amigável."

---

## 📌 2. ARQUIVOS DE SALVAR (Ex: `salvar_pessoa.php`)

```php
require_once 'conexao.php';
```
* **O que responder:** "Essa linha importa o arquivo `conexao.php`. Usamos `require_once` para que a conexão seja carregada apenas uma vez, reaproveitando o objeto `$pdo`."

```php
$nome = $_POST['nome'];
$cpf  = $_POST['cpf'];
```
* **O que responder:** "Essa linha pega o valor que o usuário digitou no campo `<input name='nome'>` do formulário HTML e guarda na variável `$nome` do PHP."

```php
$sql = $pdo->prepare("INSERT INTO tbPessoas (nome, cpf) VALUES (?, ?)");
```
* **O que responder:** "Essa linha prepara o comando SQL de inserção. Nós colocamos as interrogações `?` (parâmetros posicionais) para proteger o sistema contra **SQL Injection**."

```php
$sql->execute([$nome, $cpf]);
```
* **O que responder:** "Essa linha executa o comando no MySQL, enviando os valores das variáveis `$nome` e `$cpf` para substituir as interrogações `?` com total segurança."

---

## 📌 3. ARQUIVOS DE LISTAGEM (Ex: `listar_pessoas.php`)

```php
$sql = "SELECT p.pessoa_id, p.nome, t.descricao AS papel 
        FROM tbPessoas p 
        LEFT JOIN tbPessoaTipo t ON p.pessoa_tipo_id = t.pessoa_tipo_id";
```
* **O que responder:** "Essa linha cria o comando SQL que busca os dados das pessoas e faz um `LEFT JOIN` com a tabela `tbPessoaTipo` para trazer o nome do cargo (ex: 'Desenvolvedor') em vez de mostrar só o número do ID."

```php
$stmt = $pdo->query($sql);
```
* **O que responder:** "Essa linha executa o comando `SELECT` diretamente no banco de dados através do `$pdo->query()`."

```php
$pessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);
```
* **O que responder:** "Essa linha extrai todas as linhas retornadas do banco e as organiza em uma lista (array associativo), onde podemos acessar os campos pelos nomes das colunas (ex: `$p['nome']`)."

```php
<?php foreach ($pessoas as $p): ?>
    <tr>
        <td><?php echo htmlspecialchars($p['nome']); ?></td>
    </tr>
<?php endforeach; ?>
```
* **O que responder:** 
  - `foreach`: "É um laço de repetição que percorre cada pessoa da lista e cria uma linha `<tr>` na tabela HTML para cada uma."
  - `echo htmlspecialchars(...)`: "O `echo` imprime o texto na tela. A função `htmlspecialchars` limpa o texto para evitar falhas de segurança do tipo XSS caso alguém digite tags HTML no nome."

---

## 📌 4. ARQUIVOS DE FORMULÁRIO HTML (Ex: `cadastro_pessoa.html`)

```html
<form action="salvar_pessoa.php" method="POST">
```
* **O que responder:** 
  - `action="salvar_pessoa.php"`: "Define para qual arquivo os dados serão enviados quando o usuário clicar em salvar."
  - `method="POST"`: "Define que os dados serão enviados de forma invisível pelo corpo da requisição, sem poluir a URL."

```html
<input type="text" id="nome" name="nome" required>
```
* **O que responder:** 
  - `type="text"`: "Cria um campo de texto simples."
  - `name="nome"`: "É o identificador que o PHP vai usar para ler esse dado através de `$_POST['nome']`."
  - `required`: "Validação do HTML5 que obriga o usuário a preencher o campo antes de enviar."

```html
<select id="tipo" name="pessoa_tipo_id">
    <option value="1">Scrum Master</option>
    <option value="2">Desenvolvedor</option>
</select>
```
* **O que responder:** "Cria uma caixa de seleção suspensa (dropdown). O texto 'Scrum Master' é o que o usuário vê, mas o que é enviado para o banco é o `value='1'`, que é o `pessoa_tipo_id`."

---

## 📌 5. BANCO DE DADOS (`script_banco.sql`)

```sql
pessoa_id INT(11) PRIMARY KEY AUTO_INCREMENT,
```
* **O que responder:** 
  - `PRIMARY KEY`: "Define que essa coluna é a Chave Primária, ou seja, o identificador exclusivo e único da linha."
  - `AUTO_INCREMENT`: "O próprio banco de dados gera o próximo número automaticamente (1, 2, 3...) a cada novo cadastro."

```sql
FOREIGN KEY (pessoa_tipo_id) REFERENCES tbPessoaTipo(pessoa_tipo_id)
```
* **O que responder:** "Define uma **Chave Estrangeira**. Ela amarra a tabela `tbPessoas` à tabela `tbPessoaTipo`, garantindo que ninguém cadastre um tipo que não existe."

```sql
FOREIGN KEY (equipe_id) REFERENCES tbEquipe(equipe_id) ON DELETE CASCADE
```
* **O que responder:** "É a chave estrangeira na tabela `tbMembros`. O `ON DELETE CASCADE` significa que se uma equipe for excluída, os vínculos dos membros dela também são removidos automaticamente para não deixar lixo no banco."

---

## 🏆 DICA DE OURO PARA A SUA APRESENTAÇÃO
Se o professor perguntar:
1. **"Onde está o Front-End?"** ➡️ "Está nos arquivos `.html` com as tags HTML5 e estilizado com CSS no topo ou em classes."
2. **"Onde está o Back-End?"** ➡️ "Está nos arquivos `.php` que recebem o `$_POST`, fazem a lógica e conversam com o MySQL via PDO."
3. **"Onde está o Banco de Dados?"** ➡️ "Está no MySQL, criado a partir do arquivo `script_banco.sql` seguindo exatamente o DER do Sistema 021."

