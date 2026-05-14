<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/MonsterRepository.php';
require_once __DIR__.'/../repositories/RatingRepository.php';

class MonsterController extends AppController {

    public function monsters() {
        session_start();
        $monsterRepository = new MonsterRepository();

        $monsters = $monsterRepository->getMonsters();

        $this->render('monsters', [
            'monsters' => $monsters,
            'title' => 'Monster List'
        ]);
    }

    public function monster($id) {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
            exit();
        }

        $monsterRepository = new MonsterRepository();
        $ratingRepository = new RatingRepository();
        $userId = $_SESSION['user_id'];

        if ($this->isPost()) {
            $data = [
                'rating' => (int)$_POST['rating'],
                'sourness' => (int)$_POST['sourness'],
                'sweetness' => (int)$_POST['sweetness'],
                'carbonation' => (int)$_POST['carbonation'],
                'energy_kick' => (int)$_POST['energy_kick']
            ];

            $ratingRepository->addRating($userId, (int)$id, $data);
            header("Location: /monsters");
            exit();
        }

        $monster = $monsterRepository->getMonster($id);
        $userRating = $ratingRepository->getUserRating($userId, (int)$id);

        $this->render('monster-details', [
            'monster' => $monster,
            'userRating' => $userRating
        ]);
    }
}