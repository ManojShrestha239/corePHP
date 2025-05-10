<?php
function aes_decrypt($encrypted_data, $key)
{
    list($encrypted_data, $iv) = explode('::', base64_decode($encrypted_data), 2); // Extract IV and encrypted data
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv); // Decrypt the data
}

$decrypted_data = aes_decrypt($encrypted_data, $key);
echo "Decrypted Data: $decrypted_data\n";
