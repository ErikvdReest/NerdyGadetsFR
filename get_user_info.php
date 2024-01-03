<?php
if (!isset($_SESSION['userData'])) {
    http_response_code(401);
    exit();
}

$userData = $_SESSION['userData'];

header('Content-Type: application/json');
echo json_encode($userData);

