<?php
session_start();
if (!isset($_SESSION['usuario_id']) || !$_SESSION['primeiro_acesso']) {
    header("Location: login.php");
    exit();
}

$host = "localhost"; $banco = "bd_mundo"; $usuario = "root"; $senha = "";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar");
}

$erro = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nova_senha = $_POST['nova_senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if (empty($nova_senha) || $nova_senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem ou estão em branco.";
    } else {
        $hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        
        // Atualiza a senha e desativa a flag de primeiro acesso
        $stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha, primeiro_acesso = 0 WHERE id_usuario = :id");
        $stmt->execute([':senha' => $hash, ':id' => $_SESSION['usuario_id']]);

        // Registrar Log
        $stmtLog = $pdo->prepare("INSERT INTO logs (id_usuario, acao, ip_origem) VALUES (:id, 'Troca de senha no primeiro acesso', :ip)");
        $stmtLog->execute([':id' => $_SESSION['usuario_id'], ':ip' => $_SERVER['REMOTE_ADDR']]);

        $_SESSION['primeiro_acesso'] = 0;
        header("Location: ../index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Troca de Senha Obrigatória</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="main-container">
        <section class="crud-section">
            <h2>Primeiro Acesso - Cadastre uma nova senha</h2>
            <?php if (!empty($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Nova Senha:</label>
                    <input type="password" name="nova_senha" required>
                </div>
                <div class="form-group">
                    <label>Confirmar Nova Senha:</label>
                    <input type="password" name="confirmar_senha" required>
                </div>
                <button type="submit" class="salvar">Alterar Senha</button>
            </form>
        </section>
    </main>
</body>
</html>