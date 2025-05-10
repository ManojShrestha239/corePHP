<?php
function ecc_decrypt($encrypted_data, $privateKey)
{
    // Use OpenSSL to decrypt using ECC private key
    $encrypted = base64_decode($encrypted_data);
    openssl_private_decrypt($encrypted, $decrypted, $privateKey);
    return $decrypted;
}

// Example ECC private key (this should be your generated private key)
$privateKey = "-----BEGIN PRIVATE KEY-----\n...Your private key...\n-----END PRIVATE KEY-----";

$decrypted_data = ecc_decrypt($encrypted_data, $privateKey);
echo "Decrypted Data (ECC): $decrypted_data\n";
