<?php
require_once 'RSADecryptor.php';
$privateKey = $_GET['privateKey'] ?? '';
$encrypted = $_GET['encrypted'] ?? '';
$decryptor = new RSADecryptor($privateKey);
try {
    echo $decryptor->decrypt($encrypted);
} catch (Exception $e) {
    echo 'Decryption error: ' . $e->getMessage();
}
