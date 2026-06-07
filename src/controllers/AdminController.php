<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/UserRepository.php';
require_once __DIR__.'/../repositories/MonsterRepository.php';

class AdminController extends AppController {

    private function checkAdmin() {
        session_start();
        if (!isset($_SESSION['account_type_id']) || (int)$_SESSION['account_type_id'] !== 2) {
            header("Location: /monsters");
            exit();
        }
    }

    public function users()
    {
        $this->checkAdmin();

        $userRepository = new UserRepository();
        $perPage = 25;

        $page = isset($_GET['page'])
            ? max(1, (int)$_GET['page'])
            : 1;

        $offset = ($page - 1) * $perPage;

        $users = $userRepository->getUsersPaginated($perPage, $offset);

        $totalUsers = $userRepository->countUsers();
        $totalPages = ceil($totalUsers / $perPage);

        $this->render('admin-users', [
            'users' => $users,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'title' => 'Users List'
        ]);
    }

    public function adminMonsters() {
        $this->checkAdmin();
        $monsterRepository = new MonsterRepository();
        $this->render('admin-monsters', ['monsters' => $monsterRepository->getMonsters(false), 'title' => 'Monster List']);
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
        $types = $monsterRepository->getMonsterTypes();

        $this->render('add-monster', [
            'monster' => $monster, 
            'types' => $types, 
            'title' => 'Add Monster'
        ]);
    }

    public function deleteUser(int $id) {
        $this->checkAdmin();
        
        $userRepository = new UserRepository();
        $userRepository->deleteUser($id);

        header("Location: /admin/users");
        exit();
    }

    public function deleteMonster(int $id) {
        $this->checkAdmin();
        
        $monsterRepository = new MonsterRepository();
        $monsterRepository->deleteMonster($id);
    
        header("Location: /admin/monsters");
        exit();
    }
}