<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/UserRepository.php';

class SecurityController extends AppController {

    public function login() {
        if (!$this->isPost()) {
            return $this->render('login', ['title' => 'Login']);
        }

        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            return $this->render('login', ['messages' => ['Please fill all fields!']]);
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUser($username);

        if (!$user) {
            return $this->render('login', ['messages' => ['Username or password is wrong!']]);
        }

        if (!password_verify($password, $user['password'])) {
            return $this->render('login', ['messages' => ['Username or password is wrong!']]);
        }

        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['account_type_id'] = $user['account_type_id'];

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/monsters");
    }

    public function register() {
        if (!$this->isPost()) {
            return $this->render('register', ['title' => 'Register']);
        }

        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmedPassword = $_POST['confirmedPassword'];

        if (empty($username) || empty($password) || empty($confirmedPassword)) {
            return $this->render('register', ['messages' => ['All fields are required!']]);
        }

        if ($password !== $confirmedPassword) {
            return $this->render('register', ['messages' => ['Passwords do not match!']]);
        }

        if (!$this->isStrongPassword($password)) {
            return $this->render('register', [
                'messages' => ['Password does not meet security requirements.']
            ]);
        }

        $userRepository = new UserRepository();
        
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $userRepository->addUser($username, $hashedPassword);
        } catch (PDOException $e) {
            return $this->render('register', ['messages' => ['Username already taken!']]);
        }

        return $this->render('login', ['messages' => ['Registration successful!']]);
    }

    public function logout() {
        session_start();
        session_destroy();
        
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
    }

    private function isStrongPassword(string $password): bool
    {
        return strlen($password) >= 8
            && preg_match('/[A-Z]/', $password)
            && preg_match('/[a-z]/', $password)
            && preg_match('/\d/', $password)
            && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
    }
}