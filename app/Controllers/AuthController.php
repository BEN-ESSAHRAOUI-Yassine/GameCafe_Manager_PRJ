<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;

class AuthController extends Controller {

    // GET /login
    public function loginForm(): void {
        $this->view('auth/login');
    }

    // POST /login
    public function login(): void {
        $email    = trim($this->post('email', ''));
        $password = $this->post('password', '');
        $errors   = [];
        //if ($_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        //   $errors[] = "Invalid CSRF token.";
        //}
        if (empty($email) || empty($password)) {
            $errors[] = 'Email et mot de passe obligatoires.';
        }

        if (empty($errors)) {
            $user = User::findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role']    = $user['role'];
                $_SESSION['name']    = $user['name'];
                $this->redirect($user['role'] === 'admin' ? '/sessions/dashboard' : 'games/index');
            }
            $errors[] = 'Email ou mot de passe incorrect.';
        }

        $this->view('auth/login', ['errors' => $errors]);
    }

    // GET /register
    public function registerForm(): void {
        $this->view('auth/register');
    }

    // POST /register
    public function register(): void {
        $errors = [];
        //if ($_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
        //   $errors[] = "Invalid CSRF token.";
        //}
        $name     = trim($this->post('name', ''));
        $email    = trim($this->post('email', ''));
        $phone    = trim($this->post('phone', ''));
        $password = $this->post('password', '');
        //$confirm  = $this->post('confirm_password', '');
        $confirm  = $this->post('password_confirm', '');

        if (empty($name))     $errors[] = 'Nom obligatoire.';
        if (empty($email))    $errors[] = 'Email obligatoire.';
        if (empty($password)) $errors[] = 'Mot de passe obligatoire.';
        if ($password !== $confirm)
            $errors[] = 'Les mots de passe ne correspondent pas.';
        if (strlen($password) < 8)
            $errors[] = 'Mot de passe minimum 8 caractères.';
        if (User::findByEmail($email))
            $errors[] = 'Cet email est déjà utilisé.';

        if (!empty($errors)) {
            $this->view('auth/register', ['errors' => $errors]);
            return;
        }

        User::create(['name' => $name, 'email' => $email, 'phone' => $phone, 'password' => $password]);
        $this->redirect('/login');
    }

    public function home(): void {
    if (isset($_SESSION['user_id'])) {
        $this->redirect('/games/index'); // or dashboard
    } else {
        $this->redirect('/login');
    }
}
    // POST /logout
    public function logout(): void {
        session_destroy();
        $this->redirect('/login');
    }
}