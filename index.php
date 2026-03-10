<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semrush Authority & Traffic Checker</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background-blobs">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
    </div>

    <main class="container">
        <header>
            <h1>Semrush <span>Batch Checker</span></h1>
            <p>Obtenha Authority Score e Tráfego Orgânico em massa.</p>
        </header>

        <section class="glass-card">
            <div class="input-group">
                <label for="domain-list">Lista de Domínios (um por linha)</label>
                <textarea id="domain-list" placeholder="google.com&#10;semrush.com&#10;facebook.com"></textarea>
            </div>

            <div class="controls">
                <div class="select-group">
                    <label for="country">País / Base</label>
                    <select id="country">
                        <option value="br">Brasil (BR)</option>
                        <option value="us">Estados Unidos (US)</option>
                        <option value="uk">Reino Unido (UK)</option>
                        <option value="es">Espanha (ES)</option>
                        <option value="fr">França (FR)</option>
                        <option value="de">Alemanha (DE)</option>
                        <option value="it">Itália (IT)</option>
                        <option value="pt">Portugal (PT)</option>
                    </select>
                </div>
                <button id="start-check" class="btn-primary">
                    <span class="btn-text">Iniciar Verificação</span>
                    <div class="loader-inner"></div>
                </button>
            </div>
        </section>

        <div id="progress-container" class="hidden">
            <div class="progress-bar-wrapper">
                <div id="progress-bar" class="progress-bar"></div>
            </div>
            <p id="progress-text">Processando: 0/0</p>
        </div>

        <section id="results-section" class="glass-card hidden">
            <div class="results-header">
                <h2>Resultados</h2>
                <div class="actions">
                    <button id="export-csv" class="btn-secondary">Exportar CSV</button>
                    <button id="clear-results" class="btn-ghost">Limpar</button>
                </div>
            </div>
            <div class="table-container">
                <table id="results-table">
                    <thead>
                        <tr>
                            <th>Domínio</th>
                            <th>Authority Score (AS)</th>
                            <th>Tráfego Orgânico</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Linhas serão inseridas via JS -->
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>
