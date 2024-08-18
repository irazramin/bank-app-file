<?php

namespace App\classes;
use App\Classes\Files;
use App\Classes\User;

class Login
{
    private Files $files;

    public function __construct(private string $email, private string $password) {
        $this->files = new Files("users.txt");
    }

    public function login() {
        $users = $this->files->getFileData();
        $users = (array) json_decode($users);

        foreach ($users as $user) {
            if($user->email == $this->email && password_verify($this->password, $user->password)) {
                return $user;
            }
        }

        return [];
    }

}