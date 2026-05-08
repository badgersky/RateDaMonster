<?php

require_once 'AppController.php';
require_once __DIR__.'/../repositories/MonsterRepository.php';

class MonsterController extends AppController {

    public function monsters() {
        $monsterRepository = new MonsterRepository();
        $monsters = $monsterRepository->getMonsters();

        $this->render('monsters', [
            'monsters' => $monsters,
            'title' => 'Monster List'
        ]);
    }

    public function monster($id) {
        $monsterRepository = new MonsterRepository();
        $monster = $monsterRepository->getMonster($id);

        if (!$monster) {
            die("Monster not found!");
        }

        if ($this->isPost()) {
            $rating = $_POST['rating'] ?? 0;
            die("Received rating: " . $rating . " for Monster: " . $monster['name']);
        }

        $this->render('monster-details', [
            'monster' => $monster,
            'title' => 'Monster Details'
        ]);
    }
}