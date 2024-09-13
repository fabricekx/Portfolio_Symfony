<?php

namespace App\Service;

class EncryptionService
{
    private string $encryptionKey;
    private string $cipher = 'aes-256-cbc'; // Algorithme de chiffrement

    public function __construct(string $encryptionKey)
    {
        $this->encryptionKey = $encryptionKey;
    }

    public function encrypt(string $data): string
    {
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encrypted = openssl_encrypt($data, $this->cipher, $this->encryptionKey, 0, $iv);

        // Retourne l'IV (initialization vector) et le texte chiffré encodés en base64
        return base64_encode($iv . $encrypted);
    }

    public function decrypt(string $encryptedData): string
    {
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $data = base64_decode($encryptedData);
        $iv = substr($data, 0, $ivLength);
        $encrypted = substr($data, $ivLength);

        return openssl_decrypt($encrypted, $this->cipher, $this->encryptionKey, 0, $iv);
    }
}
