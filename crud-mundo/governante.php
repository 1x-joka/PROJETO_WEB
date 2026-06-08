<?php
$host = "localhost";
$banco = "bd_mundo";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar");
}

if (isset($_POST['acao']) && $_POST['acao'] === 'cadastrar') {
    $nome = $_POST['nome'];
    $partido = $_POST['partido_politico'];
    $nascimento = $_POST['data_nascimento'];
    $idade = $_POST['idade'];
    $inicio_mandato = $_POST['data_inicio_mandato'];
    
    // Tratamento de campos opcionais do formulário (vazio vira NULL no banco)
    $final_mandato = !empty($_POST['data_final_mandato']) ? $_POST['data_final_mandato'] : null;
    $id_pais = !empty($_POST['pais_id']) ? $_POST['pais_id'] : null;
    $id_cidade = !empty($_POST['cidade_id']) ? $_POST['cidade_id'] : null;

    $sql = "INSERT INTO governante (nome_governante, partido_politico_governante, data_nascimento_governante, idade_governante, data_inicio_mandato, data_final_mandato, id_pais, id_cidade) 
            VALUES (:nome, :partido, :nascimento, :idade, :inicio_mandato, :final_mandato, :id_pais, :id_cidade)";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':partido', $partido);
    $stmt->bindParam(':nascimento', $nascimento);
    $stmt->bindParam(':idade', $idade);
    $stmt->bindParam(':inicio_mandato', $inicio_mandato);
    $stmt->bindParam(':final_mandato', $final_mandato);
    $stmt->bindParam(':id_pais', $id_pais);
    $stmt->bindParam(':id_cidade', $id_cidade);

    if ($stmt->execute()) {
        echo "<script>alert('Governante cadastrado com sucesso!'); window.location.href='../index.php';</script>";
    } else {
        echo "Erro ao cadastrar governante.";
    }
}
?>