<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração Global - Sistema BD Mundo</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <!-- CABEÇALHO -->
    <header>
        <h1>Administração Global</h1>
    </header>

    <main class="main-container">
        <!-- CONTINENTES -->
        <section class="crud-section">
            <h2>Gerenciamento de Continentes</h2>
            <div class="forms-container">
                <form action="backend/continente.php" method="POST" class="crud-form">
                    <input type="hidden" name="acao" value="cadastrar">
                    <div class="form-group">
                        <label for="cont_nome">Nome do Continente:</label>
                        <input type="text" id="cont_nome" name="nome" required placeholder="Ex: América do Sul">
                    </div>
                    <div class="form-group">
                        <label for="cont_populacao">População:</label>
                        <input type="number" id="cont_populacao" name="populacao" required placeholder="Ex: 430000000">
                    </div>
                    <div class="form-group">
                        <label for="cont_area">Área (em km²):</label>
                        <input type="number" step="0.01" id="cont_area" name="area" required placeholder="Ex: 17840000">
                    </div>
                    <button type="submit" class="salvar">Salvar Continente</button>
                </form>
            </div>
        </section>

        <!-- PAÍSES -->
        <section class="crud-section">
            <h2>Gerenciamento de Países</h2>
            <div class="forms-container">
                <form action="backend/pais.php" method="POST" class="crud-form">
                    <input type="hidden" name="acao" value="cadastrar"> <!-- O PHP irá receber requisições de vários campos, ele tem que saber qual é qual (Excluir, Cadastrar, Editar) -->
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="pais_nome">Nome do País:</label>
                            <input type="text" id="pais_nome" name="nome" required placeholder="Ex: Brasil">
                        </div>
                        <div class="form-group">
                            <label for="pais_continente">Continente:</label>
                            <select id="pais_continente" name="continente_id" required>
                                <option value="">Selecione um Continente...</option>
                                <?php foreach ($continentes as $c): ?>
                                    <option value="<?php echo $c['id_continente']; ?>">
                                        <?php echo htmlspecialchars($c['nome_continente']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pais_populacao">População:</label>
                            <input type="number" id="pais_populacao" name="populacao" required placeholder="Ex: 214000000">
                        </div>
                        <div class="form-group">
                            <label for="pais_area">Área (em km²):</label>
                            <input type="number" step="0.01" id="pais_area" name="area" required placeholder="Ex: 8515767">
                        </div>
                        <div class="form-group">
                            <label for="pais_idioma">Idioma Oficial:</label>
                            <input type="text" id="pais_idioma" name="idioma" required placeholder="Ex: Português">
                        </div>
                        <div class="form-group">
                            <label for="pais_clima">Clima Predominante:</label>
                            <input type="text" id="pais_clima" name="clima" required placeholder="Ex: Tropical">
                        </div>
                        <div class="form-group">
                            <label for="pais_regime">Regime Político:</label>
                            <input type="text" id="pais_regime" name="regime_politico" required placeholder="Ex: República Presidencialista">
                        </div>
                        <div class="form-group">
                            <label for="pais_moeda">Moeda:</label>
                            <input type="text" id="pais_moeda" name="moeda" placeholder="Real (R$)" required>
                        </div>
                    </div>
                    <button type="submit" class="salvar">Salvar País</button>
                </form>
            </div>
        </section>

        <!-- CIDADES -->
        <section class="crud-section">
            <h2>Gerenciamento de Cidades</h2>
            <div class="forms-container">
                <form action="backend/cidade.php" method="POST" class="crud-form">
                    <input type="hidden" name="acao" value="cadastrar">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="cidade_nome">Nome da Cidade:</label>
                            <input type="text" id="cidade_nome" name="nome" required placeholder="Ex: São José dos Campos">
                        </div>
                        <div class="form-group">
                            <label for="cidade_pais">País Pertencente:</label>
                            <select id="cidade_pais" name="pais_id" required>
                                <option value="">Selecione um País...</option>
                                <!-- Dinâmico via PHP -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cidade_populacao">População:</label>
                            <input type="number" id="cidade_populacao" name="populacao" required placeholder="Ex: 730000">
                        </div>
                        <div class="form-group">
                            <label for="cidade_area">Área (em km²):</label>
                            <input type="number" step="0.01" id="cidade_area" name="area" required placeholder="Ex: 1099.40">
                        </div>
                        <div class="form-group">
                            <label for="cidade_clima">Clima:</label>
                            <input type="text" id="cidade_clima" name="clima" required placeholder="Ex: Subtropical">
                        </div>
                        <div class="form-group">
                            <label for="cidade_fundacao">Data de Fundação:</label>
                            <input type="date" id="cidade_fundacao" name="data_fundacao" required>
                        </div>
                    </div>
                    <button type="submit" class="salvar">Salvar Cidade</button>
                </form>
            </div>
        </section>

        <!-- SEÇÃO: GOVERNANTES -->
        <section class="crud-section">
            <h2>Gerenciamento de Governantes</h2>
            <div class="forms-container">
                <form action="backend/governante.php" method="POST" class="crud-form">
                    <input type="hidden" name="acao" value="cadastrar">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="gov_nome">Nome do Governante:</label>
                            <input type="text" id="gov_nome" name="nome" required placeholder="Ex: Nome do Político">
                        </div>
                        <div class="form-group">
                            <label for="gov_partido">Partido Político:</label>
                            <input type="text" id="gov_partido" name="partido_politico" required placeholder="Ex: Partido XYZ">
                        </div>
                        <div class="form-group">
                            <label for="gov_nascimento">Data de Nascimento:</label>
                            <input type="date" id="gov_nascimento" name="data_nascimento" required>
                        </div>
                        <div class="form-group">
                            <label for="gov_idade">Idade:</label>
                            <input type="number" id="gov_idade" name="idade" required placeholder="Ex: 52">
                        </div>
                        <div class="form-group">
                            <label for="gov_inicio">Início do Mandato:</label>
                            <input type="date" id="gov_inicio" name="data_inicio_mandato" required>
                        </div>
                        <div class="form-group">
                            <label for="gov_fim">Fim do Mandato:</label>
                            <input type="date" id="gov_fim" name="data_final_mandato">
                        </div>
                        <div class="form-group">
                            <label for="gov_vinculo_tipo">Vincular a:</label>
                            <select id="gov_vinculo_tipo" name="tipo_vinculo" onchange="alternarCamposVinculo()" required>
                                <option value="">Escolha uma opção...</option>
                                <option value="pais">País</option>
                                <option value="cidade">Cidade</option>
                            </select>
                        </div>
                        <div class="form-group" id="grupo_vinculo_pais" style="display:none;">
                            <label for="gov_pais_id">Selecione o País:</label>
                            <select id="gov_pais_id" name="pais_id">
                                <option value="">Escolha o País...</option>
                            </select>
                        </div>
                        <div class="form-group" id="grupo_vinculo_cidade" style="display:none;">
                            <label for="gov_cidade_id">Selecione a Cidade:</label>
                            <select id="gov_cidade_id" name="cidade_id">
                                <option value="">Escolha a Cidade...</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="salvar">Salvar Governante</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>