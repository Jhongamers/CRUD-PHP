<?php
session_start();
require_once __DIR__ . '/../controllers/UserController.php';
$controller = new UserController();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// Verifica a ação e o ID para edição
if (isset($_GET['action']) && $_GET['action'] === 'edit' && filter_input(INPUT_GET,'id')) {
    $user = $controller->getUser($_GET['id']);
} else {
    $user = ['id' => '', 'nome' => '', 'email' => '', 'senha' => ''];
}
$emailError = isset($_SESSION['email_error']) ? $_SESSION['email_error'] : null;
    unset($_SESSION['email_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $user['id'] ? "Editar" : "Cadastrar" ?> de Usuário</title>
    <link rel="stylesheet" href="../assets/css/register.css">
</head>
<body>
<form method="POST" action="../router/web.php<?php echo isset($_GET['id']) ? '?action=save' : ''; ?>">
    <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo isset($user['nome']) ? $user['nome'] : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
    
        <?php if ($emailError): ?>
            <small style="color: red;"><?php echo $emailError; ?></small>
        <?php endif; ?>
        <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : (isset($user['email']) ? $user['email'] : ''); ?>" required>
    </div>

    <div class="form-group">
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" <?php echo isset($user['id']) ? "" : "required"; ?>>
        <?php if (isset($user['id'])): ?>
            <small> Deixe em branco para manter a senha atual </small>
        <?php endif; ?>
    </div>

    <input type="hidden" name="id" value="<?php echo isset($user['id']) ? $user['id'] : ''; ?>">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">

    <div class="form-actions">
        <button type="submit" id="enviar" class="btn btn-primary">Salvar</button>
        <a href="../views/users.php" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

<script>
    const inputField = document.getElementById('senha');
    const submitButton = document.getElementById('enviar');
    submitButton.disabled = false; 
    <?php if (filter_input(INPUT_POST,'email') && $controller->isEmailRegistered(filter_input(INPUT_POST,'email'))): ?>
        document.getElementById('email').focus();
    <?php endif; ?>
    <?php if(isset($_POST["id"])): ?>
   // Inicialmente desabilita o botão se a senha tiver menos de 6 caracteres
   submitButton.disabled = inputField.value.length < 6; 
   <?php endif; ?>
// Verifica se o campo de senha é preenchido ou apagado
inputField.addEventListener('input', () => {
    if (inputField.value.length >= 6) {
        submitButton.disabled = false; // Ativa o botão se tiver 6 ou mais caracteres
    } else {
        submitButton.disabled = true; // Desabilita o botão se tiver menos de 6 caracteres
    }
});

</script>

</body>
</html>