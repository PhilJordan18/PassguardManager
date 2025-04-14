<?php

namespace Models\PasswordManager\Services;

use Models\PasswordManager\Brokers\UsersBroker;
use Models\PasswordManager\Entities\Users;
use Models\PasswordManager\Validators\UserValidator;
use Zephyrus\Application\Form;
use Zephyrus\Security\Cryptography;

class UserServices
{
    public static function readAll(): array {
        return Users::buildArray(new UsersBroker()->findAll());
    }

    public static function read(int $id): ?Users
    {
        return Users::build(new UsersBroker()->findById($id));
    }

    public static function insert(Form $form): Users
    {
        UserValidator::assert($form);
        $broker = new UsersBroker();
        $userId = $broker->insert(Users::build($form->buildObject()));
        return self::read($userId);
    }

    public static function update(Users $user, Form $form): Users
    {
        UserValidator::assert($form);
        $broker = new UsersBroker();
        $broker->update($user, Users::build($form->buildObject()));
        return self::read($user->id);
    }

    public static function remove(Users $old): \stdClass
    {
        return new UsersBroker()->delete($old);
    }

    public static function authenticate(string $username, string $password): ?Users
    {
        $broker = new UsersBroker();
        $userData = $broker->findByName($username);

        if ($userData) {
            $hashedPassword = Cryptography::hash($password);

            if ($hashedPassword === $userData->password) {
                return Users::build($userData);
            }
        }

        return null;
    }
}