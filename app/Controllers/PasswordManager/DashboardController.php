<?php

namespace Controllers\PasswordManager;

use Controllers\Controller;
use Zephyrus\Network\Router\Get;

class DashboardController extends Controller
{
    #[Get("/dashboard")]
    public function index(): void
    {
        $this->render("dashboard", ['title' => 'PasswordManager/dashboard']);
    }
}