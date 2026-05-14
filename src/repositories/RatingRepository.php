<?php

require_once 'Repository.php';

class RatingRepository extends Repository {

    public function addRating(int $userId, int $monsterId, array $data): void 
    {
        $query = $this->database->connect()->prepare(
            "INSERT INTO ratings (user_id, monster_id, rating, sourness, sweetness, carbonation, energy_kick) 
             VALUES (?, ?, ?, ?, ?, ?, ?)
             ON CONFLICT (user_id, monster_id) 
             DO UPDATE SET 
                rating = EXCLUDED.rating,
                sourness = EXCLUDED.sourness,
                sweetness = EXCLUDED.sweetness,
                carbonation = EXCLUDED.carbonation,
                energy_kick = EXCLUDED.energy_kick"
        );

        $query->execute([
            $userId,
            $monsterId,
            $data['rating'],
            $data['sourness'],
            $data['sweetness'],
            $data['carbonation'],
            $data['energy_kick']
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

    public function getUserRating(int $userId, int $monsterId): ?array
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM ratings WHERE user_id = :user_id AND monster_id = :monster_id;"
        );
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->bindParam(':monster_id', $monsterId, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : null;
    }

    public function getMonsterRatings(int $monsterId): ?array 
    {
        $query = $this->database->connect()->prepare(
            "SELECT 
                AVG(rating) as avg_rating,
                AVG(sourness) as avg_sourness,
                AVG(sweetness) as avg_sweetness,
                AVG(carbonation) as avg_carbonation,
                AVG(energy_kick) as avg_kick
            FROM ratings 
            WHERE monster_id = :id"
        );
        $query->bindParam(':id', $monsterId, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return ($result && $result['avg_rating'] !== null) ? $result : null;
    }
}