<?php
function ecc_encrypt($data, $publicKey)
{
    // Use OpenSSL to encrypt using ECC public key
    openssl_public_encrypt($data, $encrypted, $publicKey);
    return base64_encode($encrypted);
}

// Example ECC public key (this should be your generated public key)
$publicKey = "-----BEGIN PUBLIC KEY-----\n...Your public key...\n-----END PUBLIC KEY-----";
$data = "Sensitive ECC Data";

$encrypted_data = ecc_encrypt($data, $publicKey);
echo "Encrypted Data (ECC): $encrypted_data\n";
