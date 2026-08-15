<?php
$host = "localhost"; $banco = "bd_mundo"; $usuario = "root"; $senha = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar");
}

if (isset($_POST['acao'])) {
    if ($_POST['acao'] === 'cadastrar') {
        $nome = $_POST['nome']; $populacao = $_POST['populacao']; $area = $_POST['area'];
        $clima = $_POST['clima']; $data_fundacao = $_POST['data_fundacao']; $id_pais = $_POST['pais_id'];

        $sql = "INSERT INTO cidade (nome_cidade, populacao_cidade, area_km2_cidade, clima_cidade, data_fundacao, id_pais) 
                VALUES (:nome, :populacao, :area, :clima, :data_fundacao, :id_pais)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome); $stmt->bindParam(':populacao', $populacao); $stmt->bindParam(':area', $area);
        $stmt->bindParam(':clima', $clima); $stmt->bindParam(':data_fundacao', $data_fundacao); $stmt->bindParam(':id_pais', $id_pais);

        if ($stmt->execute()) {
            echo "<script>alert('Cidade cadastrada com sucesso!'); window.location.href='../index.php';</script>";
        } else {
            echo "Erro ao cadastrar cidade.";
        }
    }

    if ($_POST['acao'] === 'excluir' && isset($_POST['id_cidade'])) {
        $id = $_POST['id_cidade'];
        $sql = "DELETE FROM cidade WHERE id_cidade = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "<script>alert('Cidade excluída!'); window.location.href='../index.php';</script>";
    }
}
?>