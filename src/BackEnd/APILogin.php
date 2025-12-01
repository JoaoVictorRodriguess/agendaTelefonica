<?php
header("Content-Type: application/json");

// Só aceitar POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

// Checa token de API
$api_token = $_POST['api_token'] ?? '';
if ($api_token !== 'TokendeTeste') {
    echo json_encode(['auth_token' => false]);
    exit;
}

$usuario = trim($_POST['api_usuario'] ?? '');
$senha   = $_POST['api_senha'] ?? '';

// validação básica
if ($usuario === '' || $senha === '') {
    echo json_encode(['logou' => false, 'error' => 'dados_incompletos']);
    exit;
}

// Conecta ao BD
require_once __DIR__ . '/AgendaDBConnect.php';
if (!isset($conn) || !$conn) {
    echo json_encode(['logou' => false, 'error' => 'db_connection_failed', 'db_error' => mysqli_connect_error()]);
    exit;
}

// Usa prepared statement corretamente
$sql = "SELECT senha, perfil FROM usuarios WHERE usuario = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    echo json_encode(['logou' => false, 'error' => 'prepare_failed', 'db_error' => mysqli_error($conn)]);
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $usuario);
if (!mysqli_stmt_execute($stmt)) {
    echo json_encode(['logou' => false, 'error' => 'execute_failed', 'db_error' => mysqli_stmt_error($stmt)]);
    exit;
}

// obtém resultado
$res = mysqli_stmt_get_result($stmt);
if (!$res) {
    echo json_encode(['logou' => false, 'error' => 'get_result_failed', 'db_error' => mysqli_error($conn)]);
    exit;
}

$row = mysqli_fetch_assoc($res);
$response = ['logou' => false];

if ($row) {
    $hash = $row['senha'];
    $perfil = $row['perfil'] ?? 'usuario';
    if (password_verify($senha, $hash)) {
        // gerar chave (se chave.php faz isso, você pode incluir)
        if (file_exists(__DIR__ . '/chave.php')) {
            require_once __DIR__ . '/chave.php'; // espera que gere $chave
        } else {
            $chave = bin2hex(random_bytes(16));
        }
        $response['logou'] = true;
        $response['chave'] = $chave;
        $response['perfil'] = $perfil;
    } else {
        $response['logou'] = false;
        $response['error'] = 'senha_invalida';
    }
} else {
    $response['logou'] = false;
    $response['error'] = 'usuario_nao_encontrado';
}

echo json_encode($response);
exit;
?>
