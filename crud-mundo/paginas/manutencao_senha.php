<?php
session_start();

// Garante que apenas usuários autenticados acessem a página
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost"; 
$banco = "bd_mundo"; 
$usuario = "root"; 
$senha = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

$mensagem = "";
$tipo_mensagem = ""; // "erro" ou "sucesso"

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha_atual = $_POST['senha_atual'] ?? '';
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    $usuario_id = $_SESSION['usuario_id'];

    if (empty($senha_atual) || empty($nova_senha) || empty($confirmar_senha)) {
        $mensagem = "Por favor, preencha todos os campos.";
        $tipo_mensagem = "erro";
    } elseif ($nova_senha !== $confirmar_senha) {
        $mensagem = "A nova senha e a confirmação não coincidem.";
        $tipo_mensagem = "erro";
    } else {
        // Busca a senha atual salva no banco para validação
        $stmt = $pdo->prepare("SELECT senha FROM usuarios WHERE id_usuario = :id");
        $stmt->execute([':id' => $usuario_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha_atual, $user['senha'])) {
            // Criptografa a nova senha
            $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

            // Atualiza a tabela usuarios
            $updateStmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id_usuario = :id");
            $updateStmt->execute([
                ':senha' => $nova_senha_hash,
                ':id' => $usuario_id
            ]);

            // Registra a alteração na tabela de logs
            $logStmt = $pdo->prepare("INSERT INTO logs (id_usuario, acao, ip_origem) VALUES (:id, 'Manutenção de senha realizada', :ip)");
            $logStmt->execute([
                ':id' => $usuario_id,
                ':ip' => $_SERVER['REMOTE_ADDR']
            ]);

            $mensagem = "Senha alterada com sucesso!";
            $tipo_mensagem = "sucesso";
        } else {
            $mensagem = "A senha atual está incorreta.";
            $tipo_mensagem = "erro";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenção de Senha</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="main-container">
        <section class="crud-section" style="margin-top: 30px;">
            <h2>Manutenção de Senha de Acesso</h2>

            <?php if (!empty($mensagem)): ?>
                <p style="color: <?php echo $tipo_mensagem === 'sucesso' ? 'green' : 'red'; ?>; text-align: center; margin-bottom: 15px; font-weight: bold;">
                    <?php echo htmlspecialchars($mensagem); ?>
                </p>
            <?php endif; ?>

            <form action="manutencao_senha.php" method="POST">
                <div class="form-group">
                    <label for="senha_atual">Senha Atual:</label>
                    <input type="password" id="senha_atual" name="senha_atual" required>
                </div>

                <div class="form-group">
                    <label for="nova_senha">Nova Senha:</label>
                    <input type="password" id="nova_senha" name="nova_senha" required>
                </div>

                <div class="form-group">
                    <label for="confirmar_senha">Confirmação da Nova Senha:</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required>
                </div>

                <button type="submit" class="salvar">Atualizar Senha</button>
            </form>

            <div style="margin-top: 15px; text-align: center;">
                <a href="index.php" style="color: #333; text-decoration: none; font-size: 14px;">← Voltar para o Sistema</a>
            </div>
        </section>
    </main>
</body>
</html>