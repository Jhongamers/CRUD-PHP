<?php
  require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $users = $controller->listUsers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Users</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Lista de Usuários</h2>
        <div class="form-actions">
            <a href="../views/user-form.php" class="btn btn-primary">Cadastrar Novo Usuário</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <?php 
    // Verificar se $users contém usuários
    if (is_array($users) && isset($users['message']) && !empty($users['message'])):  
        foreach ($users['message'] as $user): 
?>
        <tr>
            <td><?= isset($user['id']) ? $user['id'] : 'N/A' ?></td>
            <td><?= isset($user['nome']) ? $user['nome'] : 'N/A' ?></td>
            <td><?= isset($user['email']) ? $user['email'] : 'N/A' ?></td>
            <td>
                <a href="user-form.php?action=edit&id=<?= $user['id'] ?>" class="btn btn-edit">
                    ✏️ Editar
                </a>
                <button class="btn btn-delete" onclick="confirmDelete(<?= $user['id'] ?>)">
                    🗑️ Excluir
                </button>
            </td>
        </tr>
<?php 
        endforeach;
    else: 
?>
        <tr>
            <td colspan="4">Nenhum usuário encontrado.</td>
        </tr>
<?php endif; ?>

</tbody>



            </table>
        </div>

    </div>

    <script>
    function confirmDelete(userId) {
        if (confirm('Tem certeza que deseja excluir este usuário?')) {
            window.location.href = '../router/web.php?action=delete&id=' + userId;
        }
    }
    </script>
</body>
</html>