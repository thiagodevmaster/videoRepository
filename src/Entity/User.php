<?php

namespace Alura\Mvc\Entity;

class User
{
    private int $id;

    public function __construct(private string $email, private string $password)
    {
        $this->email = $this->setEmail($email);
        $this->password = $this->setPassword($password);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setEmail(string $email): void
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->email = $email;
        }
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setPassword(string $password): string
    {
        $newPassword = password_hash($password, PASSWORD_ARGON2ID);

        return $newPassword;
    }

}