<?php
require_once __DIR__ . '/../config/dbconfig.php';


class User extends dbconfig {
    private $table = "usuarios";

    public function register($nome, $email, $senha){
        try{
            if($this->emailExists($email)){
                return ["error" => true , "message" => "Email já cadastrado"];
            }
            $passwordCrypt = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "insert into $this->table (nome, email, senha) values (:nome, :email, :senha)";
            $connect = $this->getConnection()->prepare($sql);
            if (!$connect) {
                return ["error" => true, "message" => "Falha ao preparar a consulta SQL"];
            }

            $connect->bindParam(":nome", $nome);
            $connect->bindParam(":email", $email);
            $connect->bindParam(":senha", $passwordCrypt);

            if($connect->execute()){
                return ["error" => false, "message" => "Usuario cadastrado com sucesso"];
            }

        }catch(PDOException $e){
            return ["error" => true, "message" => "Erro ao cadastrar o usuario". $e->getMessage()];
        }
    }

    public function update($id, $nome, $email, $senha = null) {
        try {
       
            // Monta a query base
            $sql = "UPDATE $this->table SET nome = :nome, email = :email";
    
            // Adiciona o campo de senha à query, se fornecido
            if (!empty($senha)) {
                $sql .= ", senha = :senha";
            }
    
            $sql .= " WHERE id = :id";
    
            // Prepara a query
            $connect = $this->getConnection()->prepare($sql);
    
            // Faz o bind dos parâmetros obrigatórios
            $connect->bindParam(':nome', $nome);
            $connect->bindParam(':email', $email);
            $connect->bindParam(':id', $id, PDO::PARAM_INT);
    
            // Faz o bind da senha, se fornecida
            if (!empty($senha)) {
                $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);
                $connect->bindParam(':senha', $hashedPassword);
            }
    
            // Executa a query
            if ($connect->execute()) {
                return ['error' => false, 'message' => 'Usuário atualizado com sucesso.'];
            } else {
                return ['error' => true, 'message' => 'Erro ao atualizar o usuário.'];
            }
        } catch (PDOException $e) {
            // Captura exceções e retorna mensagem de erro
            return ['error' => true, 'message' => 'Erro ao atualizar o usuário: ' . $e->getMessage()];
        }
    }
    
public function getUserById($id) {
    try {
        $sql = "SELECT id, nome, email, senha FROM $this->table WHERE id = :id";
        $connect = $this->getConnection()->prepare($sql);
        $connect->bindParam(":id", $id);
        $connect->execute();

        $user = $connect->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return ["error" => false, "message" => $user];
        } else {
            return ["error" => true, "message" => "Usuário não encontrado"];
        }

    } catch (PDOException $e) {
        return ["error" => true, "message" => "Erro ao buscar o usuário: " . $e->getMessage()];
    }
}

        
        public function listAll(){
            try {
                $sql = "SELECT id, nome, email FROM $this->table ORDER BY created_at DESC";
                $connect = $this->getConnection()->prepare($sql);
                $connect->execute();
        
                $users = $connect->fetchAll(PDO::FETCH_ASSOC);  // Isso retorna um array
        
                // Se não houver usuários, deve retornar um array vazio
                if (count($users) > 0) {
                    return ["error" => false, "message" => $users];  // Retorna os usuários encontrados
                } else {
                    return ["error" => false, "message" => []];  // Retorna um array vazio
                }
            } catch (PDOException $e) {
                return ["error" => true, "message" => "Erro ao listar usuários: " . $e->getMessage()];
            }
        }

        public function delete($id){
            try{
                $sql = "delete from $this->table where id=:id";
                $connect = $this->getConnection()->prepare($sql);
    
                $connect->bindParam(":id", $id);
    
                if($connect->execute()){
                    return ["error" => false, "message" => "Usuario deletado com sucesso"];
                }
    
            }catch(PDOException $e){
                return ["error" => true, "message" => "Erro ao deletar o usuario". $e->getMessage()];
            }
    }

    public function emailExists($email){
            $sql = "select count(*) from $this->table where email=:email";
            $connect =  $this->getConnection()->prepare($sql);
            $connect->bindParam(":email",$email);
            $connect->execute();

            return $connect->fetchColumn() > 0;
    }
}