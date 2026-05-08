<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/UserRepository.php';
require_once __DIR__.'/../repositories/MonsterRepository.php';

class AdminController extends AppController {

    private function checkAdmin() {
        session_start();
        if ($_SESSION['username'] !== 'admin') {
            header("Location: /monsters");
            exit();
        }
    }

    public function users() {
        $this->checkAdmin();
        $userRepository = new UserRepository();
        $this->render('admin-users', ['users' => $userRepository->getUsers(), 'title' => 'Users List']);
    }

    public function adminMonsters() {
        $this->checkAdmin();
        $monsterRepository = new MonsterRepository();
        $this->render('admin-monsters', ['monsters' => $monsterRepository->getMonsters(), 'title' => 'Monster List']);
    }

    public function addMonster($id = null) {
        $this->checkAdmin();
        $monsterRepository = new MonsterRepository();

        if ($this->isPost()) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $image_url = $_POST['image_url'];
            $type_id = (int)$_POST['type_id'];

            if ($id) {
                $monsterRepository->updateMonster((int)$id, $name, $description, $image_url, $type_id);
            } else {
                $monsterRepository->addMonster($name, $description, $image_url, $type_id);
            }

            header("Location: /admin/monsters");
            exit();
        }

        $monster = $id ? $monsterRepository->getMonster((int)$id) : null;
        $this->render('add-monster', ['monster' => $monster, 'title' => 'Add Monster']);
    }

    public function deleteUser(int $id) {
    $this->checkAdmin();
    
    $userRepository = new UserRepository();
    $userRepository->deleteUser($id);

    header("Location: /admin/users");
    exit();
    }
}