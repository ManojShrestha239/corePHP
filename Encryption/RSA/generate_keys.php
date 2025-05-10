<?php
require_once 'RSAGenerator.php';
header('Content-Type: application/json');
$rsa = new RSAGenerator();
$keys = $rsa->generateKeyPair(2048);
echo json_encode($keys);
