<?php
function rsa_encrypt($data, $publicKey)
{
    // Use OpenSSL to encrypt using RSA public key
    openssl_public_encrypt($data, $encrypted, $publicKey);
    return base64_encode($encrypted);
}

// Example RSA public key (this should be your generated public key)
$publicKey = "-----BEGIN PUBLIC KEY-----\n...Your public key...\n-----END PUBLIC KEY-----";
$data = "Sensitive RSA Data";

$encrypted_data = rsa_encrypt($data, $publicKey);
echo "Encrypted Data (RSA): $encrypted_data\n";
