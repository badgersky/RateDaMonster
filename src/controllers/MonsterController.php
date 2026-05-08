<?php

require_once 'AppController.php';

class MonsterController extends AppController {

    public function monsters() {
        $this->render('monsters', ['title' => 'Monster List']);
    }

    public function monster($id) {
        if ($this->isPost()) {
            $rating = $_POST['rating'] ?? 0;
            die("Received rating: " . $rating . " for Monster ID: " . $id);
        }

        $this->render('monster-details', ['title' => 'Monster Details', 'id' => $id]);
    }
}