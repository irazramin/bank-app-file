<?php
namespace App\classes;
use App\classes\Files;
use App\classes\User;

class Registration
{
    private Files $files;

    public function __construct(private User $user) {
        $this->files = new Files("../users.txt");

    }
    public function register(): void
    {
        $users = $this->files->getFileData();
        $users = (array) json_decode($users);

        $users[] = [
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail(),
            'password' => $this->user->getPassword(),
            'balance' => 0,
            'role'=> 'user'
        ];

        $convertIntoString = json_encode($users);
        $this->files->saveData($convertIntoString);
    }
}