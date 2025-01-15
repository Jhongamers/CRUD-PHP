# Projeto de Cadastro de Usuários

Este é um projeto simples de cadastro de usuários desenvolvido em PHP. O objetivo é registrar, editar e listar usuários em um banco de dados MySQL.

## Passos para Configuração

### 1. Configuração do Banco de Dados

1. Navegue até a pasta `config` e abra o arquivo `dbconfig.php`
2. No arquivo `dbconfig.php`, configure as credenciais de conexão com o banco de dados:

```php
class dbconfig {
    private $host = "localhost";  // servidor do banco de dados
    private $username = "root";   // usuário do banco
    private $password = "";       // senha do banco
    private $database = "user-registration"; // nome do seu banco de dados
    private $conn;

    public function __construct(){
        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->database",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
```

## Instruções de Configuração

### 1. Configuração do Banco de Dados

- **host**: O endereço do servidor MySQL (geralmente `localhost`)
- **username**: O nome de usuário do MySQL (por padrão é `root`)
- **password**: A senha do MySQL (deixe em branco se não houver senha)
- **database**: O nome do banco de dados. Certifique-se de que o banco de dados esteja configurado com o nome `user-registration`

### 2. Subindo o Banco de Dados

O banco de dados utilizado no projeto já está disponível no repositório.

1. Baixe o arquivo SQL do banco de dados (que deve estar incluído no repositório, caso contrário, você pode criá-lo manualmente)
2. Acesse o MySQL via **phpMyAdmin** ou qualquer outro cliente de banco de dados
3. Crie um novo banco de dados chamado `user-registration` (se já não existir)
4. Importe o arquivo SQL fornecido para criar as tabelas necessárias no banco de dados

### 3. Colocando os Arquivos no XAMPP

Se você estiver usando o **XAMPP**, siga os seguintes passos:

1. Mova todos os arquivos do projeto para a pasta `htdocs` do XAMPP. A pasta `htdocs` geralmente está localizada em:
    ```bash
    C:\xampp\htdocs
    ```
2. Crie uma pasta para o projeto, por exemplo, `user-registration`, e coloque os arquivos dentro dessa pasta
3. Abra o XAMPP e inicie os seguintes serviços:
    - **Apache** (para o servidor web)
    - **MySQL** (para o banco de dados)

### 4. Rodando o Projeto

1. Abra o navegador e acesse o seguinte endereço:
    ```
    http://localhost/user-registration
    ```
2. Você será redirecionado para a tela onde todos os usuários cadastrados são listados

### 5. Cadastro de Usuários

1. Para cadastrar um novo usuário, clique no botão **Cadastrar**
2. Preencha o formulário de cadastro com o nome, email e senha
3. Após o cadastro, você será redirecionado para a página de listagem de usuários, onde poderá visualizar os usuários cadastrados

### 6. Funcionalidades

- **Cadastro de Usuários**: Permite o cadastro de novos usuários com nome, email e senha
- **Edição de Usuários**: Você pode editar as informações de um usuário, exceto a senha (a menos que você a altere no formulário de edição)
- **Exclusão de Usuários**: Permite excluir usuários cadastrados

### 7. Observações

- Certifique-se de que o servidor **Apache** e **MySQL** estão rodando no **XAMPP**
- Caso haja algum erro relacionado ao banco de dados, verifique se as credenciais estão corretamente configuradas no arquivo `config/dbconfig.php`
- Para ambientes de produção, é importante configurar o banco de dados com uma senha forte e garantir que as conexões sejam feitas de maneira segura

---

Se tiver alguma dúvida, entre em contato com o desenvolvedor!

**Autor**: Jonathan
