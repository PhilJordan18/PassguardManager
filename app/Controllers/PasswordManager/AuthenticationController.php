<?php

namespace Controllers\PasswordManager;

use Controllers\Controller;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;

class AuthenticationController extends Controller
{
    #[Get("/")]
    public function authenticate(): Response
    {
        return $this->render('authentication');
    }
}