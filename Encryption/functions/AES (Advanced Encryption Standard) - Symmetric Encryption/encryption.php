<?php
function aes_encrypt($data, $key)
{
    // AES-256-CBC encryption
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc')); // Generate a random IV
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv); // Encrypt the data
    return base64_encode($encrypted . '::' . $iv); // Return IV with encrypted data
}

$data = "Sensitive data";
$key = "1234567890abcdef1234567890abcdef"; // 256-bit key (32 bytes)

$encrypted_data = aes_encrypt($data, $key);
echo "Encrypted Data: $encrypted_data\n";
