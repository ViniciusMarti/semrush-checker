<?php
header('Content-Type: application/json');

$apiKey = 'a1e822113be6a4ca7d7ccd58fb78b227';
$domain = $_GET['domain'] ?? '';
$database = $_GET['database'] ?? 'us';

if (empty($domain)) {
    echo json_encode(['error' => 'Domain is required']);
    exit;
}

// Limpar o domínio (remover http/https e barras extras)
$domain = preg_replace('#^https?://#', '', $domain);
$domain = trim($domain, '/');

$url = "https://api.semrush.com/?type=domain_rank&key={$apiKey}&export_columns=As,Ot&domain={$domain}&database={$database}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200 || !$response) {
    echo json_encode(['error' => 'Failed to fetch data from Semrush', 'raw' => $response]);
    exit;
}

// O Semrush retorna CSV com a primeira linha sendo cabeçalho
// Exemplo: 
// Authority Score;Organic Traffic
// 55;1234
$lines = explode("\n", trim($response));
if (count($lines) < 2) {
    echo json_encode(['error' => 'No data found for this domain', 'raw' => $response]);
    exit;
}

$headers = explode(';', $lines[0]);
$values = explode(';', $lines[1]);

$result = [
    'domain' => $domain,
    'as' => (int)($values[0] ?? 0),
    'traffic' => (int)($values[1] ?? 0)
];

echo json_encode($result);
?>
