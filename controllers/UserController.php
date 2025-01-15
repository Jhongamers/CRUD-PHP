<?php


require_once __DIR__ . '/../models/User.php';


class UserController {

    private $userModel;

    function __construct(){
        $this->userModel = new User;

    }

    public function registerUser($nome, $email, $senha){
        $result = $this->userModel->register($nome, $email, $senha);
        if ($result['error']) {
            echo "Erro: {$result['message']}";
        } else {
            echo "Usuário registrado com sucesso!";
            // Redirecionar ou exibir mensagem de sucesso
            header("Location: ../views/users.php");
            exit;
        }
    }

    public function listUsers(){
        $result = $this->userModel->listAll();
        return $result;
    }

    public function deleteUser($id){
        $result = $this->userModel->delete($id);
        var_dump($result);
        if(!$result['error']){
            header('location:../views/users.php');
        }else{
            echo "deu erro";
        }
     
   
    }
    public function isEmailRegistered($email){
        $result = $this->userModel->emailExists($email);
        return $result;
    }

    public function store($id, $nome, $email, $senha = null){
        $result = $this->userModel->update($id, $nome, $email, $senha);
        if (!$result['error']) {
           header('location:../views/users.php');
        } else {
            echo "<p>Erro ao carregar os usuários: {$result['message']}</p>";
        }
    }

    public function getUser($id) {
        // Aqui você deve implementar a lógica de buscar o usuário pelo ID
        $result = $this->userModel->getUserById($id);
        return $result['error'] ? null : $result['message'];
    }

    public function listUsersView() {
        $userModel = new User();
        $users = $userModel->listAll();

        if (!$users['error']) {
            require_once 'views/users.php';
        } else {
            echo "<p>Erro ao carregar os usuários: {$users['message']}</p>";
        }
    }
}

?>