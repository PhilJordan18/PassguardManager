<?php

namespace Models\PasswordManager\Entities;

class Accounts
{
    public int $id;
    public int $user_id;
    public int $app_id;
    public string $username;
    public string $password;
    public string $last_updated;
}