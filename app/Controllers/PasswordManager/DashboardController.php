<?php

namespace Controllers\PasswordManager;

use Controllers\Controller;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;

class DashboardController extends Controller
{
    #[Get("/dashboard")]
    public function index(): Response
    {
        return $this->render("PasswordManager/dashboard");
    }
}