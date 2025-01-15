<?php

session_start(); 
require_once __DIR__ . '/../controllers/UserController.php';
$controller = new UserController();

// Criação do token CSRF se não existir
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Gera um token único
}

// Validação do CSRF quando o formulário for submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Erro: Token CSRF inválido!');
    }
    unset($_SESSION['csrf_token']); // Limpa o token após a validação
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_GET['action'])) {
    $nome =  filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];

    // Verifica se o email já está registrado
    if ($controller->isEmailRegistered($email)) {
        $_SESSION['email_error'] = "Email já cadastrado";
        header("Location: ../views/user-form.php");
        exit;
    }
    if (empty($senha) || strlen($senha) < 6) {
        $_SESSION['email_error'] = "Senha deve ter 6 caracteres ou mais";
        header("Location: ../views/user-form.php");
        exit;
    }
    // Caso o email não seja registrado, segue para registrar o usuário
    $controller->registerUser($nome, $email, $senha);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'save') {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $nome =  filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];


    if (empty($senha) || strlen($senha) < 6) {
        $_SESSION['email_error'] = "Senha deve ter 6 caracteres ou mais";
        header("Location: ../views/user-form.php");
        exit;
    }

    $controller->store($id, $nome, $email, $senha);
}



if (isset($_GET['action'])  && $_GET['action'] == 'delete') {
    $id = isset($_GET['id']) ? $_GET['id'] : null;
     $controller->deleteUser($id);
}

?>
