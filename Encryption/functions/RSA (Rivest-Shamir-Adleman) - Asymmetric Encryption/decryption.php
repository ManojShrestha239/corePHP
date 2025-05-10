<?php
function rsa_decrypt($encrypted_data, $privateKey)
{
    // Use OpenSSL to decrypt using RSA private key
    $encrypted = base64_decode($encrypted_data);
    openssl_private_decrypt($encrypted, $decrypted, $privateKey);
    return $decrypted;
}

// Example RSA private key (this should be your generated private key)
$privateKey = "-----BEGIN PRIVATE KEY-----\n...Your private key...\n-----END PRIVATE KEY-----";

$decrypted_data = rsa_decrypt($encrypted_data, $privateKey);
echo "Decrypted Data (RSA): $decrypted_data\n";
