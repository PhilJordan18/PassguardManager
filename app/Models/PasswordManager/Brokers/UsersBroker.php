<?php

namespace Models\PasswordManager\Brokers;

use Models\PasswordManager\Entities\Users;
use Zephyrus\Database\DatabaseBroker;
use Zephyrus\Security\Cryptography;

class UsersBroker extends DatabaseBroker
{
    public function findAll(): array {
        return $this->select("SELECT * FROM users");
    }

    public function findById(int $id): ?\stdClass {
        return $this->selectSingle("SELECT * FROM users WHERE id = ?", [$id]);
    }

    public function insert(Users $user): int
    {
        $hashedPassword = Cryptography::hashPassword($user->password);
        return $this->selectSingle(
            "INSERT INTO users(firstname, lastname, username, password, email, phone_number, created_at, updated_at)
         VALUES(?, ?, ?, ?, ?, ?, NOW(), NOW())
         RETURNING id",
            [
                $user->firstName,
                $user->lastName,
                $user->username,
                $hashedPassword,
                $user->email,
                $user->phone_number
            ]
        )->id;
    }

    public function update(Users $old, Users $new): int {
        $updatedPassword = !empty($new->password) ? Cryptography::hash($new->password) : $old->password;
        $this->query("UPDATE users SET firsname = ?, lastname = ?, username = ?, password = ?, email = ?, phone_number = ?, updated_at = NOW()
                                        WHERE id = ?",
        [
            $new->firstName,
            $new->lastName,
            $new->username,
            $updatedPassword,
            $new->email,
            $new->phone_number,
            $new->updated_at,
            $old->id
        ]);

        return $this->getLastAffectedCount();
    }

    public function delete(Users $old): int  {
        $this->query("DELETE FROM users WHERE id = ?", [$old->id]);
        return $this->getLastAffectedCount();
    }

}