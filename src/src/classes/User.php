<?php

namespace App\classes;

use App\classes\Files;

class User
{
    protected string $name;
    protected string $email;
    protected string $password;

    private Files $userFile;

    public function getName(): string {
        return $this->name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): string {
        return $this->password;
    }

}