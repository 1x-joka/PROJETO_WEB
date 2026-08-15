<?php
// 1. Conexão ao banco
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

// 2. Buscando dados para os selects dos formulários
$continentes = $pdo->query("SELECT id_continente, nome_continente FROM continente")->fetchAll(PDO::FETCH_ASSOC);
$paises = $pdo->query("SELECT id_pais, nome_pais FROM pais")->fetchAll(PDO::FETCH_ASSOC);
$cidades = $pdo->query("SELECT id_cidade, nome_cidade FROM cidade")->fetchAll(PDO::FETCH_ASSOC);

// 3. Buscando dados completos para preencher as tabelas de listagem
$lista_continentes = $pdo->query("SELECT * FROM continente")->fetchAll(PDO::FETCH_ASSOC);
$lista_paises = $pdo->query("SELECT p.*, c.nome_continente FROM pais p LEFT JOIN continente c ON p.id_continente = c.id_continente")->fetchAll(PDO::FETCH_ASSOC);
$lista_cidades = $pdo->query("SELECT c.*, p.nome_pais FROM cidade c LEFT JOIN pais p ON c.id_pais = p.id_pais")->fetchAll(PDO::FETCH_ASSOC);
$lista_governantes = $pdo->query("SELECT g.*, p.nome_pais, c.nome_cidade FROM governante g LEFT JOIN pais p ON g.id_pais = p.id_pais LEFT JOIN cidade c ON g.id_cidade = c.id_cidade")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração Global</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <h1>Administração Global</h1>
    </header>
    <main class="main-container">
        
        <!-- ================= SEÇÃO CONTINENTES ================= -->
        <section class="crud-section">
            <h2>Cadastrar Continente</h2>
            <form action="backend/continente.php" method="POST">
                <input type="hidden" name="acao" value="cadastrar">
                <div class="form-group"><label>Nome:</label><input type="text" name="nome" required></div>
                <div class="form-group"><label>População:</label><input type="number" name="populacao" required></div>
                <div class="form-group"><label>Área (km²):</label><input type="number" step="0.01" name="area" required></div>
                <button type="submit" class="salvar">Salvar Continente</button>
            </form>

            <h3 style="margin-top: 30px;">Continentes Cadastrados</h3>
            <table class="tabela-dados">
                <tr><th>ID</th><th>Nome</th><th>População</th><th>Área (km²)</th><th>Ação</th></tr>
                <?php foreach ($lista_continentes as $cont): ?>
                <tr>
                    <td><?php echo $cont['id_continente']; ?></td>
                    <td><?php echo htmlspecialchars($cont['nome_continente']); ?></td>
                    <td><?php echo $cont['populacao_continente']; ?></td>
                    <td><?php echo $cont['area_km2_continente']; ?></td>
                    <td>
                        <form action="backend/continente.php" method="POST" style="display:inline;" onsubmit="return confirmarExclusao(event, '<?php echo htmlspecialchars($cont['nome_continente']); ?>')">
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id_continente" value="<?php echo $cont['id_continente']; ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <!-- ================= SEÇÃO PAÍSES ================= -->
        <section class="crud-section">
            <h2>Cadastrar País</h2>
            <form action="backend/pais.php" method="POST">
                <input type="hidden" name="acao" value="cadastrar">
                <div class="form-group"><label>Nome do País:</label><input type="text" name="nome" required></div>
                <div class="form-group"><label>População:</label><input type="number" name="populacao" required></div>
                <div class="form-group"><label>Área (km²):</label><input type="number" step="0.01" name="area" required></div>
                <div class="form-group"><label>Idioma:</label><input type="text" name="idioma" required></div>
                <div class="form-group"><label>Clima:</label><input type="text" name="clima" required></div>
                <div class="form-group"><label>Regime Político:</label><input type="text" name="regime_politico" required></div>
                <div class="form-group"><label>Moeda:</label><input type="text" name="moeda" required></div>
                <div class="form-group">
                    <label>Continente:</label>
                    <select name="continente_id" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($continentes as $c): ?>
                            <option value="<?php echo $c['id_continente']; ?>"><?php echo htmlspecialchars($c['nome_continente']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="salvar">Salvar País</button>
            </form>

            <h3 style="margin-top: 30px;">Países Cadastrados</h3>
            <table class="tabela-dados">
                <tr><th>ID</th><th>Nome</th><th>Continente</th><th>População</th><th>Ação</th></tr>
                <?php foreach ($lista_paises as $p): ?>
                <tr>
                    <td><?php echo $p['id_pais']; ?></td>
                    <td><?php echo htmlspecialchars($p['nome_pais']); ?></td>
                    <td><?php echo htmlspecialchars($p['nome_continente']); ?></td>
                    <td><?php echo $p['populacao_pais']; ?></td>
                    <td>
                        <form action="backend/pais.php" method="POST" style="display:inline;" onsubmit="return confirmarExclusao(event, '<?php echo htmlspecialchars($p['nome_pais']); ?>')">
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id_pais" value="<?php echo $p['id_pais']; ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <!-- ================= SEÇÃO CIDADES ================= -->
        <section class="crud-section">
            <h2>Cadastrar Cidade</h2>
            <form action="backend/cidade.php" method="POST">
                <input type="hidden" name="acao" value="cadastrar">
                <div class="form-group"><label>Nome da Cidade:</label><input type="text" name="nome" required></div>
                <div class="form-group"><label>População:</label><input type="number" name="populacao" required></div>
                <div class="form-group"><label>Área (km²):</label><input type="number" step="0.01" name="area" required></div>
                <div class="form-group"><label>Clima:</label><input type="text" name="clima" required></div>
                <div class="form-group"><label>Data de Fundação:</label><input type="date" name="data_fundacao" required></div>
                <div class="form-group">
                    <label>País:</label>
                    <select name="pais_id" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($paises as $p): ?>
                            <option value="<?php echo $p['id_pais']; ?>"><?php echo htmlspecialchars($p['nome_pais']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="salvar">Salvar Cidade</button>
            </form>

            <h3 style="margin-top: 30px;">Cidades Cadastradas</h3>
            <table class="tabela-dados">
                <tr><th>ID</th><th>Nome</th><th>País</th><th>População</th><th>Ação</th></tr>
                <?php foreach ($lista_cidades as $cid): ?>
                <tr>
                    <td><?php echo $cid['id_cidade']; ?></td>
                    <td><?php echo htmlspecialchars($cid['nome_cidade']); ?></td>
                    <td><?php echo htmlspecialchars($cid['nome_pais']); ?></td>
                    <td><?php echo $cid['populacao_cidade']; ?></td>
                    <td>
                        <form action="backend/cidade.php" method="POST" style="display:inline;" onsubmit="return confirmarExclusao(event, '<?php echo htmlspecialchars($cid['nome_cidade']); ?>')">
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id_cidade" value="<?php echo $cid['id_cidade']; ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>

        <!-- ================= SEÇÃO GOVERNANTES ================= -->
        <section class="crud-section">
            <h2>Cadastrar Governante</h2>
            <form action="backend/governante.php" method="POST">
                <input type="hidden" name="acao" value="cadastrar">
                <div class="form-group"><label>Nome:</label><input type="text" name="nome" required></div>
                <div class="form-group"><label>Partido Político:</label><input type="text" name="partido_politico" required></div>
                <div class="form-group"><label>Data de Nascimento:</label><input type="date" name="data_nascimento" required></div>
                <div class="form-group"><label>Idade:</label><input type="number" name="idade" required></div>
                <div class="form-group"><label>Início do Mandato:</label><input type="date" name="data_inicio_mandato" required></div>
                <div class="form-group"><label>Final do Mandato (opcional):</label><input type="date" name="data_final_mandato"></div>
                
                <div class="form-group">
                    <label>Este governante governa um:</label>
                    <select id="gov_vinculo_tipo" onchange="alternarCamposVinculo()">
                        <option value="pais">País</option>
                        <option value="cidade">Cidade</option>
                    </select>
                </div>

                <div class="form-group" id="grupo_vinculo_pais">
                    <label>País Governado:</label>
                    <select name="pais_id">
                        <option value="">Nenhum / Selecione...</option>
                        <?php foreach ($paises as $p): ?>
                            <option value="<?php echo $p['id_pais']; ?>"><?php echo htmlspecialchars($p['nome_pais']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" id="grupo_vinculo_cidade" style="display:none;">
                    <label>Cidade Governada:</label>
                    <select name="cidade_id">
                        <option value="">Nenhum / Selecione...</option>
                        <?php foreach ($cidades as $c): ?>
                            <option value="<?php echo $c['id_cidade']; ?>"><?php echo htmlspecialchars($c['nome_cidade']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="salvar">Salvar Governante</button>
            </form>

            <h3 style="margin-top: 30px;">Governantes Cadastrados</h3>
            <table class="tabela-dados">
                <tr><th>Nome</th><th>Partido</th><th>Governa</th><th>Ação</th></tr>
                <?php foreach ($lista_governantes as $gov): ?>
                <tr>
                    <td><?php echo htmlspecialchars($gov['nome_governante']); ?></td>
                    <td><?php echo htmlspecialchars($gov['partido_politico_governante']); ?></td>
                    <td>
                        <?php 
                            if (!empty($gov['nome_pais'])) {
                                echo "País: " . htmlspecialchars($gov['nome_pais']);
                            } elseif (!empty($gov['nome_cidade'])) {
                                echo "Cidade: " . htmlspecialchars($gov['nome_cidade']);
                            } else {
                                echo "Nenhum";
                            }
                        ?>
                    </td>
                    <td>
                        <form action="backend/governante.php" method="POST" style="display:inline;" onsubmit="return confirmarExclusao(event, '<?php echo htmlspecialchars($gov['nome_governante']); ?>')">
                            <input type="hidden" name="acao" value="excluir">
                            <input type="hidden" name="id_governante" value="<?php echo $gov['id_governante']; ?>">
                            <button type="submit" class="btn-excluir">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </section>
    </main>
</body>
</html>