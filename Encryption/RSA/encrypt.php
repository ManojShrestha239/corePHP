<?php
require_once 'RSAEncryptor.php';
$publicKey = $_GET['publicKey'] ?? '';
$message = $_GET['message'] ?? '';
$encryptor = new RSAEncryptor($publicKey);
try {
    echo $encryptor->encrypt($message);
} catch (Exception $e) {
    echo 'Encryption error: ' . $e->getMessage();
}
