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
            $this->errors[] = "Please fill all required fields.";
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

    private function getPasswordHash()
    {
        return sha1(strtoupper($this->username).":".strtoupper($this->password[0]));
    }

    public function saveToDb()
    {
        if (count($this->errors) !== 0)
            return account::STATUS_FAILED;

        if (!$this->validatePassword())
        {
            $this->errors[] = "Passwords do not match.";
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

        $passHash = $this->getPasswordHash();

        $stmt = $db->prepare("INSERT INTO account (username, sha_pass_hash, expansion) VALUES (:username, :password, 2)");
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $passHash);
        $stmt->execute();

        return account::STATUS_OK;
    }
}
