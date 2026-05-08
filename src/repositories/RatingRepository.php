<?php

require_once 'Repository.php';

class RatingRepository extends Repository {

    public function addRating(int $userId, int $monsterId, int $rating): void 
    {
        $query = $this->database->connect()->prepare(
            "INSERT INTO ratings (user_id, monster_id, rating) 
             VALUES (?, ?, ?)
             ON CONFLICT (user_id, monster_id) 
             DO UPDATE SET rating = EXCLUDED.rating;"
        );

        $query->execute([
            $userId,
            $monsterId,
            $rating
        ]);
    }

    public function getAverageRating(int $monsterId): ?float 
    {
        $query = $this->database->connect()->prepare(
            "SELECT AVG(rating) as average FROM ratings WHERE monster_id = :id;"
        );
        $query->bindParam(':id', $monsterId, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['average'] ? (float)$result['average'] : null;
    }

    public function getUserRating(int $userId, int $monsterId): ?int 
    {
        $query = $this->database->connect()->prepare(
            "SELECT rating FROM ratings WHERE user_id = :user_id AND monster_id = :monster_id;"
        );
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->bindParam(':monster_id', $monsterId, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['rating'] : null;
    }
}