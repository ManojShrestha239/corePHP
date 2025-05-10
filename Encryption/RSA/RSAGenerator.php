<?php
/**
 * RSA Key Generator Class
 * 
 * This class handles generation of RSA key pairs
 */
class RSAGenerator {
    
    /**
     * Generate a new RSA key pair
     *
     * @param int $bits The key length in bits (default: 2048)
     * @return array Associative array with 'publicKey' and 'privateKey'
     */
    public function generateKeyPair($bits = 2048) {
        // Create a new key pair
        $config = [
            'private_key_bits' => $bits,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ];
        
        // Generate new key pair
        $resource = openssl_pkey_new($config);
        
        if (!$resource) {
            throw new Exception('Failed to generate RSA key pair: ' . openssl_error_string());
        }
        
        // Extract private key
        openssl_pkey_export($resource, $privateKey);
        
        // Extract public key
        $keyDetails = openssl_pkey_get_details($resource);
        $publicKey = $keyDetails['key'];
        
        return [
            'publicKey' => $publicKey,
            'privateKey' => $privateKey
        ];
    }
    
    /**
     * Save RSA keys to files
     *
     * @param string $publicKey The public key
     * @param string $privateKey The private key
     * @param string $publicKeyFile Path to save public key
     * @param string $privateKeyFile Path to save private key
     * @return bool True if keys are saved successfully
     */
    public function saveKeysToFiles($publicKey, $privateKey, $publicKeyFile = 'public.key', $privateKeyFile = 'private.key') {
        $pubResult = file_put_contents($publicKeyFile, $publicKey);
        $privResult = file_put_contents($privateKeyFile, $privateKey);
        
        return ($pubResult !== false && $privResult !== false);
    }
    
    /**
     * Load RSA keys from files
     *
     * @param string $publicKeyFile Path to public key file
     * @param string $privateKeyFile Path to private key file
     * @return array Associative array with 'publicKey' and 'privateKey'
     */
    public function loadKeysFromFiles($publicKeyFile = 'public.key', $privateKeyFile = 'private.key') {
        $publicKey = file_exists($publicKeyFile) ? file_get_contents($publicKeyFile) : null;
        $privateKey = file_exists($privateKeyFile) ? file_get_contents($privateKeyFile) : null;
        
        return [
            'publicKey' => $publicKey,
            'privateKey' => $privateKey
        ];
    }
}