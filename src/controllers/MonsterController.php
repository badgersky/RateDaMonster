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
        
        $monsterRepository = new MonsterRepository();
        $ratingRepository = new RatingRepository();
        
        $userId = $_SESSION['user_id'] ?? null;

        if ($this->isPost()) {
            if (!$userId) {
                header("Location: /login");
                exit();
            }

            $data = [
                'rating' => (int)$_POST['rating'],
                'sourness' => (int)$_POST['sourness'],
                'sweetness' => (int)$_POST['sweetness'],
                'carbonation' => (int)$_POST['carbonation'],
                'energy_kick' => (int)$_POST['energy_kick']
            ];

            $ratingRepository->addRating($userId, (int)$id, $data);
            header("Location: /monsters/" . $id);
            exit();
        }

        $monster = $monsterRepository->getMonster((int)$id);
        
        if (!$monster) {
            header("Location: /monsters");
            exit();
        }

        $userRating = $userId ? $ratingRepository->getUserRating($userId, (int)$id) : null;
        $allRatings = $ratingRepository->getMonsterRatings((int)$id);

        $this->render('monster-details', [
            'monster' => $monster,
            'userRating' => $userRating,
            'allRatings' => $allRatings,
            'title' => $monster['name']
        ]);
    }
}