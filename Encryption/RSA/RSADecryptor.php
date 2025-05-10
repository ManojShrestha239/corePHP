<?php
/**
 * RSA Decryption Class
 * 
 * This class handles decryption operations using RSA private key
 */
class RSADecryptor {
    
    private $privateKey;
    
    /**
     * Constructor
     *
     * @param string $privateKey The RSA private key
     */
    public function __construct($privateKey) {
        $this->privateKey = $privateKey;
    }
    
    /**
     * Decrypt data with the private key
     *
     * @param string $encryptedData Base64 encoded encrypted data
     * @return string Decrypted data
     * @throws Exception If decryption fails
     */
    public function decrypt($encryptedData) {
        $key = openssl_pkey_get_private($this->privateKey);
        
        if (!$key) {
            throw new Exception('Invalid private key: ' . openssl_error_string());
        }
        
        // Check if data was encrypted in chunks
        if (strpos($encryptedData, '|') !== false) {
            $chunks = explode('|', $encryptedData);
            $decryptedChunks = [];
            
            foreach ($chunks as $chunk) {
                $binaryData = base64_decode($chunk);
                $decrypted = '';
                $success = openssl_private_decrypt($binaryData, $decrypted, $key, OPENSSL_PKCS1_OAEP_PADDING);
                
                if (!$success) {
                    throw new Exception('Decryption failed: ' . openssl_error_string());
                }
                
                $decryptedChunks[] = $decrypted;
            }
            
            // Join decrypted chunks
            return implode('', $decryptedChunks);
        } else {
            // Decode the base64 encoded data
            $binaryData = base64_decode($encryptedData);
            
            // Decrypt the data with the private key
            $decrypted = '';
            $success = openssl_private_decrypt($binaryData, $decrypted, $key, OPENSSL_PKCS1_OAEP_PADDING);
            
            if (!$success) {
                throw new Exception('Decryption failed: ' . openssl_error_string());
            }
            
            return $decrypted;
        }
    }
    
    /**
     * Sign data using the private key
     *
     * @param string $data The data to sign
     * @return string Base64 encoded signature
     * @throws Exception If signing fails
     */
    public function sign($data) {
        $key = openssl_pkey_get_private($this->privateKey);
        
        if (!$key) {
            throw new Exception('Invalid private key: ' . openssl_error_string());
        }
        
        // Create signature
        $signature = '';
        $success = openssl_sign($data, $signature, $key, OPENSSL_ALGO_SHA256);
        
        if (!$success) {
            throw new Exception('Signing failed: ' . openssl_error_string());
        }
        
        // Return base64 encoded signature
        return base64_encode($signature);
    }
}