<?php

class account
{
    const STATUS_OK         = 0;
    const STATUS_FAILED     = 1;

    private $username;
    private $password = [];

    private $errors = [];

    public function __construct(array $post)
    {
        if ($this->validateDataArray($post))
        {
            $this->username = $post['username'];
            $this->password[0] = $post['password'];
            $this->password[1] = $post['password_repeat'];
        }
        else
        {
            $this->errors[] = "Please fill all required fields.";
        }
    }

    private function validateDataArray(array $data)
    {
        return isset($data['username']) && isset($data['password']) && isset($data['password_repeat']);
    }

    private function validatePassword()
    {
        return count($this->password) == 2 && $this->password[0] === $this->password[1];
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPasswords()
    {
        return $this->password;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    private static function generateSalt()
    {
        return random_bytes(32);
    }

    private static function getVerifier($username, $password, $salt)
    {
        // algorithm constants
        $g = gmp_init(7);
        $N = gmp_init('894B645E89E1535BBDAD5B8B290650530801B18EBFBF5E8FAB3C82872A3E9BB7', 16);

        // calculate first hash
        $h1 = sha1(strtoupper($username . ':' . $password), true);

        // calculate second hash
        $h2 = sha1($salt . $h1, true);

        // convert to integer (little-endian)
        $h2 = gmp_import($h2, 1, GMP_LSW_FIRST);

        // g^h2 mod N
        $verifier = gmp_powm($g, $h2, $N);

        // convert back to a byte array (little-endian)
        $verifier = gmp_export($verifier, 1, GMP_LSW_FIRST);

        // pad to 32 bytes, remember that zeros go on the end in little-endian!
        $verifier = str_pad($verifier, 32, chr(0), STR_PAD_RIGHT);

        return $verifier;
    }

    function verifyLogin($salt, $verifier)
    {
        // re-calculate the verifier using the provided username + password and the stored salt
        $checkVerifier = account::getVerifier($this->username, $this->password[0], $salt);

        // compare it against the stored verifier
        return ($verifier === $checkVerifier);
    }

    public function saveToDb()
    {
        if (count($this->errors) !== 0)
        {
            return account::STATUS_FAILED;
        }

        if (!$this->validatePassword())
        {
            $this->errors[] = "Passwords do not match.";
            return account::STATUS_FAILED;
        }

        if (strlen($this->password[0]) > 16)
        {
            $this->errors[] = "Password must be at most 16 characters long.";
            return account::STATUS_FAILED;
        }

        $db = new MySQL(new Config());
        $stmt = $db->prepare("SELECT * FROM account WHERE username LIKE :username");
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();

        if ($stmt->fetch())
        {
            $this->errors[] = "The username you've entered already exists.";
            return account::STATUS_FAILED;
        }

        $salt = account::generateSalt();
        $verifier = account::getVerifier($this->username, $this->password[0], $salt);

        $stmt = $db->prepare("INSERT INTO account (username, salt, verifier, expansion) VALUES (:username, :salt, :verifier, 2)");
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":salt", $salt);
        $stmt->bindParam(":verifier", $verifier);
        $res = $stmt->execute();

        if (!$res)
        {
            $err = $stmt->errorInfo();
            $this->errors[] = "Error " . $err[0] . " occurred: " . $err[2];
            return account::STATUS_FAILED;
        }

        return account::STATUS_OK;
    }
}
