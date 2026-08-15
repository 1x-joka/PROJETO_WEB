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
        $idioma = $_POST['idioma']; $clima = $_POST['clima']; $regime = $_POST['regime_politico'];
        $moeda = $_POST['moeda']; $id_continente = $_POST['continente_id'];

        $sql = "INSERT INTO pais (nome_pais, populacao_pais, area_km2_pais, idioma_pais, clima_pais, regime_politico_pais, moeda_pais, id_continente) 
                VALUES (:nome, :populacao, :area, :idioma, :clima, :regime, :moeda, :id_continente)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome); $stmt->bindParam(':populacao', $populacao); $stmt->bindParam(':area', $area);
        $stmt->bindParam(':idioma', $idioma); $stmt->bindParam(':clima', $clima); $stmt->bindParam(':regime', $regime);
        $stmt->bindParam(':moeda', $moeda); $stmt->bindParam(':id_continente', $id_continente);

        if ($stmt->execute()) {
            echo "<script>alert('País cadastrado com sucesso!'); window.location.href='../index.php';</script>";
        } else {
            echo "Erro ao cadastrar país";
        }
    }
    
    // Função de Deletar
    if ($_POST['acao'] === 'excluir' && isset($_POST['id_pais'])) {
        $id = $_POST['id_pais'];
        $sql = "DELETE FROM pais WHERE id_pais = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        echo "<script>alert('País excluído!'); window.location.href='../index.php';</script>";
    }
}
?>