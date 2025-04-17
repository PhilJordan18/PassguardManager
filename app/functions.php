<?php

/**
 * Add global project functions here ...
 */

function setSession(int $userId, string $token): void
{
    $_SESSION['user'] = [
        'id' => $userId,
        'token' => $token
    ];
}
