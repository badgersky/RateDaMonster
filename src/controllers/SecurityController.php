<?php

require_once 'AppController.php';

class SecurityController extends AppController {

    public function login() {
        if (!$this->isPost()) {
            return $this->render('login', ['title' => 'Login Page']);
        }
        
        die(var_dump($_POST));

        $username = $_POST['username'];
        $password = $_POST['password'];

        // TODO: get user from database
        // TODO: password_verify
        // TODO: start session and redirect
    }

    public function register() {
        if (!$this->isPost()) {
            return $this->render('register', ['title' => 'Register Account']);
        }

        die(var_dump($_POST));

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // TODO: validation
        // TODO: password_hash
        // TODO: saving to database
        // TODO: redirect to login
    }

    public function logout() {
        // TODO: session_destroy
        // TODO: redirect to login
    }
}