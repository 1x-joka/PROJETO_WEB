<?php
$host = "localhost"; $banco = "bd_mundo"; $usuario = "root"; $senha = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados");
}

if (isset($_POST['acao'])) {
    if ($_POST['acao'] === 'cadastrar') {
        $nome = $_POST['nome'];
        $populacao = $_POST['populacao'];
        $area = $_POST['area'];

        $sql = "INSERT INTO continente (nome_continente, populacao_continente, area_km2_continente) VALUES (:nome, :populacao, :area)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':populacao', $populacao);
        $stmt->bindParam(':area', $area);

        if ($stmt->execute()) {
            echo "<script>alert('Continente cadastrado com sucesso!'); window.location.href='../index.php';</script>";
        } else {
            echo "Erro ao cadastrar continente.";
        }
    }
    
    // Função de Deletar
    if ($_POST['acao'] === 'excluir' && isset($_POST['id_continente'])) {
        $id = $_POST['id_continente'];
        $sql = "DELETE FROM continente WHERE id_continente = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            echo "<script>alert('Continente excluído!'); window.location.href='../index.php';</script>";
        }
    }
}
?>