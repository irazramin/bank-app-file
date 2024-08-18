<?php

namespace App\classes;

use App\Classes\Files;

class Validator
{

    private array $errors;
    private static array $fields = ["name", "email", "password"];

    private Files $files;
    public function __construct(private array $field_data, private string $type) {
        $this->errors = [];
        $this->files = new Files("users.txt");
    }

    public function validateForm(): bool|array
    {
//        foreach (self::$fields as $field) {
//            if(!array_key_exists($field, $this->field_data)) {
//               trigger_error("The field '{$field}' does not exist in the form");
//               return false;
//            }
//        }

        if ($this->type == 'registration') {
            $this->validateName();
        }

        $this->validateEmail();
        $this->validatePassword();
//        $this->userCheck();

        return $this->errors;
    }

    private function validateName(): void {
        if($this->field_data["name"] == '' && isset($this->field_data["name"])) {
            $this->errors["name"] = "Name is required";
        }
    }

    private function validateEmail(): void {
        $email = $this->field_data["email"];

        if($email == '') {
            $this->errors["email"] = "Email is required";
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors["email"] = "Please enter a valid email address";
        }
    }

    private function validatePassword(): void {
        $password = $this->field_data["password"];
        if($password == '') {
            $this->errors["password"] = "Password field is required";
        }
        else if(strlen($password) < 8) {
            $this->errors["password"] = "Password must be at least 8 characters long";
        }
    }

    private function userCheck ():void {
        $users = $this->files->getFileData();
        $users = (array) json_decode($users, true);

        foreach ($users as $user) {
            if ($user["email"] == $this->field_data["email"]) {
                $this->errors["auth_error"] = "This email is already taken";
            }
        }
    }
}

