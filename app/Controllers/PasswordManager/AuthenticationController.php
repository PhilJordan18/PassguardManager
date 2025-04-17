<?php

namespace Controllers\PasswordManager;

use Controllers\Controller;
use DateMalformedStringException;
use Models\PasswordManager\Services\TokenServices;
use Models\PasswordManager\Services\UserServices;
use Models\PasswordManager\Validators\UserValidator;
use Random\RandomException;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Post;

class AuthenticationController extends Controller
{
    #[Get("/authentication")]
    public function authenticate(): Response
    {
        return $this->render('PasswordManager/authentication');
    }

    /**
     * @throws DateMalformedStringException
     * @throws RandomException
     */
    #[Post("/login")]
    public function login(): Response
    {
        $form = $this->buildForm();
        UserValidator::assertLogin($form);

        if (!$form->verify()) {
            return $this->render('PasswordManager/authentication', [
                'error' => 'Champs invalides, réessayer!'
            ]);
        }

        $username = $form->getValue('username');
        $password = $form->getValue('password');

        $user = UserServices::login($username, $password);

        if (!$user) {
            return $this->render('PasswordManager/authentication', [
                'error' => 'Nom d utilisateur ou mot de passe incorrect'
            ]);
        }

        $token = TokenServices::generateToken($user->id);
        setSession($user->id, $token);
        return $this->redirect('/dashboard');
    }

    /**
     * @throws DateMalformedStringException
     * @throws RandomException
     */
    #[Post("/register")]
    public function register(): Response
    {
        $form = $this->buildForm();
        UserValidator::assert($form);

        if (!$form->verify()) {
            return $this->render('PasswordManager/authentication', [
                'error' => 'Veillez remplir tous les champs'
            ]);
        }

        $newUser = UserServices::register($form);
        $token = TokenServices::generateToken($newUser->id);
        setSession($newUser->id, $token);
        return $this->redirect('/dashboard');
    }
}