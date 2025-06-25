<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

$cuentas_autorizadas = [
    '68020274' => ['tipo' => 'VIP', 'expira' => '2025-10-25', 'max_posiciones' => 10],
];

$account = $_POST['account'] ?? $_GET['account'] ?? '0';
$broker = $_POST['broker'] ?? $_GET['broker'] ?? '';
$ea_version = $_POST['ea_version'] ?? $_GET['ea_version'] ?? '';

if (isset($cuentas_autorizadas[$account])) {
    $licencia = $cuentas_autorizadas[$account];
    $fecha_expira = strtotime($licencia['expira']);

    if (time() <= $fecha_expira) {
        echo json_encode([
            'status' => 'VALIDA',
            'cuenta' => $account,
            'tipo' => $licencia['tipo'],
            'expira' => $licencia['expira'],
            'max_posiciones' => $licencia['max_posiciones'],
            'mensaje' => 'Licencia válida',
            'servidor_tiempo' => date('Y-m-d H:i:s')
        ]);
    } else {
        echo json_encode([
            'status' => 'EXPIRADA',
            'cuenta' => $account,
            'expira' => $licencia['expira'],
            'mensaje' => 'Licencia expirada'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'INVALIDA',
        'cuenta' => $account,
        'mensaje' => 'Cuenta no autorizada'
    ]);
}
?>
