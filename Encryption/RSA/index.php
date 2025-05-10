<?php
// Include required files
require_once 'RSAGenerator.php';
require_once 'RSAEncryptor.php';
require_once 'RSADecryptor.php';

// Set header for proper display
header('Content-Type: text/html; charset=utf-8');

// Function to display results
function displaySection($title, $content)
{
    echo "<div style='margin: 20px 0; padding: 10px; border: 1px solid #ccc; border-radius: 5px;'>";
    echo "<h3>$title</h3>";
    echo "<pre style='background-color: #f5f5f5; padding: 10px; border-radius: 3px; overflow-x: auto;'>";
    echo htmlspecialchars($content);
    echo "</pre></div>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>RSA Encryption Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <?php
    // Demo of RSA Encryption
    echo "<h1>RSA Encryption Demo</h1>";

    // Step 1: Generate RSA key pair
    echo "<h2>Step 1: Generating RSA Keys</h2>";
    $rsaGenerator = new RSAGenerator();
    $keyPair = $rsaGenerator->generateKeyPair(2048); // 2048 bits for security

    displaySection("Public Key", $keyPair['publicKey']);
    displaySection("Private Key", $keyPair['privateKey']);

    // Step 2: Encrypt a message
    echo "<h2>Step 2: Encrypting Message</h2>";
    $plaintext = "This is a secret message that needs to be encrypted using RSA.";
    displaySection("Original Message", $plaintext);

    $encryptor = new RSAEncryptor($keyPair['publicKey']);
    $encryptedData = $encryptor->encrypt($plaintext);
    displaySection("Encrypted Message (Base64 Encoded)", $encryptedData);

    // Step 3: Decrypt the message
    echo "<h2>Step 3: Decrypting Message</h2>";
    $decryptor = new RSADecryptor($keyPair['privateKey']);
    $decryptedData = $decryptor->decrypt($encryptedData);
    displaySection("Decrypted Message", $decryptedData);

    // Step 4: Digital Signature Example
    echo "<h2>Step 4: Digital Signature Example</h2>";
    $message = "This message will be digitally signed with RSA.";
    displaySection("Message to Sign", $message);

    // Sign with private key
    $signature = $decryptor->sign($message);
    displaySection("Digital Signature (Base64 Encoded)", $signature);

    // Verify with public key
    $verified = $encryptor->verify($message, $signature);
    displaySection("Signature Verification Result", $verified ? "Signature Valid ✓" : "Signature Invalid ✗");

    // Try with tampered message
    $tamperedMessage = $message . " (tampered)";
    $verifiedTampered = $encryptor->verify($tamperedMessage, $signature);
    displaySection("Tampered Message", $tamperedMessage);
    displaySection("Tampered Message Verification Result", $verifiedTampered ? "Signature Valid ✓" : "Signature Invalid ✗");
    ?>
</body>

</html>