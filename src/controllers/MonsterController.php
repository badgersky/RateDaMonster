<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/MonsterRepository.php';
require_once __DIR__.'/../repositories/RatingRepository.php';

class MonsterController extends AppController {

    public function monsters() {
        session_start();
        $monsterRepository = new MonsterRepository();
        $ratingRepository = new RatingRepository();
        
        $monsters = $monsterRepository->getMonsters();

        foreach ($monsters as &$monster) {
            $avg = $ratingRepository->getAverageRating($monster['id']);
            $monster['avg_rating'] = $avg ? round($avg, 1) : 'No ratings';
        }

        $this->render('monsters', [
            'monsters' => $monsters,
            'title' => 'Monster List'
        ]);
    }

    public function monster($id) {
        if ($this->isPost()) {
            session_start();
            
            if (!isset($_SESSION['user_id'])) {
                $url = "http://$_SERVER[HTTP_HOST]";
                header("Location: {$url}/login");
                exit();
            }

            $userId = $_SESSION['user_id'];
            $rating = (int)($_POST['rating'] ?? 0);

            if ($rating >= 1 && $rating <= 10) {
                $ratingRepository = new RatingRepository();
                $ratingRepository->addRating($userId, (int)$id, $rating);
            }

            header("Location: /monsters");
            exit();
        }

        header("Location: /monsters");
        exit();
    }
}