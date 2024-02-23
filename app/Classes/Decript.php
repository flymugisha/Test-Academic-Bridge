<?php

namespace App\classes;

use Exception;

class Decript
{

    public $ENC_METHOD = "AES-256-CBC"; // THE ENCRYPTION METHOD.
    public $ENC_KEY = "SOME_RANDOM_KEY"; // ENCRYPTION KEY
    public $ENC_IV = "SOME_RANDOM_IV"; // ENCRYPTION IV.
    public $ENC_SALT = "xS$"; // THE SALT FOR PASSWORD ENCRYPTION ONLY.
    // THIS FUNCTION WILL ENCRYPT THE PASSED STRING
    public function Encrypt($string)
    {
        try {
            $output = false;
            $key = hash('sha256', $this->ENC_KEY);
            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hash('sha256', $this->ENC_IV), 0, 16);
            $output = openssl_encrypt($string, $this->ENC_METHOD, $key, 0, $iv);
            $output = base64_encode($output);
            return $output;
        } catch (Exception $e) {
            return "Caught exception: " . $e->getMessage();
        }
    }

    // THIS FUNCTION WILL DECRYPT THE ENCRYPTED STRING.
    public function Decrypt($string)
    {
        try {
            $output = false;
            // hash
            $key = hash('sha256', $this->ENC_KEY);
            // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
            $iv = substr(hash('sha256', $this->ENC_IV), 0, 16);

            $output = openssl_decrypt(base64_decode($string), $this->ENC_METHOD, $key, 0, $iv);
            return $output;
        } catch (Exception $e) {
            return "Caught exception: " . $e->getMessage();
        }
    }
}
