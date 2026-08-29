<?php
session_start();

$host = "localhost"; $banco = "bd_mundo"; $usuario = "root"; $senha = "";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar");
}

$mensagem_erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $senha_digitada = $_POST['senha'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE login = :login");
    $stmt->execute([':login' => $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verifica se a conta está bloqueada
        if ($user['bloqueado'] == 1) {
            $mensagem_erro = "Usuário bloqueado por exceder o número de tentativas incorretas.";
        } else {
            // Valida a senha
            if (password_verify($senha_digitada, $user['senha'])) {
                // Sucesso: Zera tentativas incorretas
                $stmtReset = $pdo->prepare("UPDATE usuarios SET tentativas_com_erro = 0 WHERE id_usuario = :id");
                $stmtReset->execute([':id' => $user['id_usuario']]);

                // Registrar Log de login
                $stmtLog = $pdo->prepare("INSERT INTO logs (id_usuario, acao, ip_origem) VALUES (:id, 'Login efetuado com sucesso', :ip)");
                $stmtLog->execute([':id' => $user['id_usuario'], ':ip' => $_SERVER['REMOTE_ADDR']]);

                // Configura Sessão
                $_SESSION['usuario_id'] = $user['id_usuario'];
                $_SESSION['usuario_login'] = $user['login'];
                $_SESSION['primeiro_acesso'] = $user['primeiro_acesso'];

                // Redireciona conforme status de primeiro acesso
                if ($user['primeiro_acesso'] == 1) {
                    header("Location: trocar_senha.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                // Senha errada: Incrementa falhas
                $novas_tentativas = $user['tentativas_com_erro'] + 1;
                $bloquear = ($novas_tentativas >= 3) ? 1 : 0;

                $stmtUpdate = $pdo->prepare("UPDATE usuarios SET tentativas_com_erro = :tentativas, bloqueado = :bloqueado WHERE id_usuario = :id");
                $stmtUpdate->execute([
                    ':tentativas' => $novas_tentativas,
                    ':bloqueado' => $bloquear,
                    ':id' => $user['id_usuario']
                ]);

                // Registrar Log de falha
                $acaoLog = $bloquear ? "Tentativa incorreta - Usuário bloqueado" : "Tentativa de login com senha errada ($novas_tentativas/3)";
                $stmtLog = $pdo->prepare("INSERT INTO logs (id_usuario, acao, ip_origem) VALUES (:id, :acao, :ip)");
                $stmtLog->execute([':id' => $user['id_usuario'], ':acao' => $acaoLog, ':ip' => $_SERVER['REMOTE_ADDR']]);

                if ($bloquear) {
                    $mensagem_erro = "Senha incorreta. Você excedeu 3 tentativas e seu acesso foi bloqueado.";
                } else {
                    $mensagem_erro = "Senha incorreta. Tentativa " . $novas_tentativas . " de 3.";
                }
            }
        }
    } else {
        $mensagem_erro = "Usuário não encontrado.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Administração Global</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="main-container">
        <section class="crud-section" style="margin-top: 50px;">
            <h2>Autenticação de Usuário</h2>
            <?php if (!empty($mensagem_erro)): ?>
                <p style="color: red; text-align: center; margin-bottom: 15px;"><?php echo htmlspecialchars($mensagem_erro); ?></p>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label>Login:</label>
                    <input type="text" name="login" required>
                </div>
                <div class="form-group">
                    <label>Senha:</label>
                    <input type="password" name="senha" required>
                </div>
                <button type="submit" class="salvar">Entrar</button>
            </form>
        </section>
    </main>
</body>
</html>