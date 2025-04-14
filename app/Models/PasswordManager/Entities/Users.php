<?php

namespace Models\PasswordManager\Entities;

use Models\Core\Entity;

class Users extends Entity
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $username;
    public string $password;
    public string $email;
    public string $phone_number;
    public string $created_at;
    public string $updated_at;
}