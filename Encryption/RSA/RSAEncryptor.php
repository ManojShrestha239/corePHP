<?php
/**
 * RSA Encryption Class
 * 
 * This class handles encryption operations using RSA public key
 */
class RSAEncryptor {
    
    private $publicKey;
    
    /**
     * Constructor
     *
     * @param string $publicKey The RSA public key
     */
    public function __construct($publicKey) {
        $this->publicKey = $publicKey;
    }
    
    /**
     * Encrypt data with the public key
     *
     * @param string $data The data to encrypt
     * @return string Base64 encoded encrypted data
     * @throws Exception If encryption fails
     */
    public function encrypt($data) {
        $key = openssl_pkey_get_public($this->publicKey);
        
        if (!$key) {
            throw new Exception('Invalid public key: ' . openssl_error_string());
        }
        
        $keyDetails = openssl_pkey_get_details($key);
        $keySize = $keyDetails['bits'] / 8;
        
        // Maximum bytes that can be encrypted (key size - padding)
        $maxBytes = $keySize - 42; // For OPENSSL_PKCS1_OAEP_PADDING
        
        if (strlen($data) > $maxBytes) {
            // For longer messages, encrypt in chunks or use hybrid encryption
            // Here we'll use a simple chunking approach
            $chunks = str_split($data, $maxBytes);
            $encryptedChunks = [];
            
            foreach ($chunks as $chunk) {
                $encrypted = '';
                $success = openssl_public_encrypt($chunk, $encrypted, $key, OPENSSL_PKCS1_OAEP_PADDING);
                
                if (!$success) {
                    throw new Exception('Encryption failed: ' . openssl_error_string());
                }
                
                $encryptedChunks[] = base64_encode($encrypted);
            }
            
            // Join chunks with a delimiter
            return implode('|', $encryptedChunks);
        } else {
            // Encrypt the data with the public key
            $encrypted = '';
            $success = openssl_public_encrypt($data, $encrypted, $key, OPENSSL_PKCS1_OAEP_PADDING);
            
            if (!$success) {
                throw new Exception('Encryption failed: ' . openssl_error_string());
            }
            
            // Return base64 encoded encrypted data
            return base64_encode($encrypted);
        }
    }
    
    /**
     * Verify a signature using the public key
     *
     * @param string $data The original data
     * @param string $signature Base64 encoded signature
     * @return bool True if signature is valid
     */
    public function verify($data, $signature) {
        $key = openssl_pkey_get_public($this->publicKey);
        
        if (!$key) {
            throw new Exception('Invalid public key: ' . openssl_error_string());
        }
        
        // Decode the signature from base64
        $binarySignature = base64_decode($signature);
        
        // Verify the signature
        $result = openssl_verify($data, $binarySignature, $key, OPENSSL_ALGO_SHA256);
        
        return $result === 1;
    }
}