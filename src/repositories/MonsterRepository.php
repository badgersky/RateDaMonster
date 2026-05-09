<?php

require_once 'Repository.php';

class MonsterRepository extends Repository {

    public function getMonster(int $id): ?array 
    {
        $stmt = $this->database->connect()->prepare(
            'SELECT * FROM monsters WHERE id = :id'
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $monster = $stmt->fetch(PDO::FETCH_ASSOC);
        return $monster ?: null;
    }

    public function getMonsters(): array 
    {
        $stmt = $this->database->connect()->prepare(
            'SELECT m.*, ROUND(AVG(r.rating), 1) as avg_rating 
            FROM monsters m 
            LEFT JOIN ratings r ON m.id = r.monster_id 
            GROUP BY m.id 
            ORDER BY RANDOM()'
        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMonster(string $name, string $description, string $image_url, int $type_id): void 
    {
        $stmt = $this->database->connect()->prepare(
            'INSERT INTO monsters (name, description, image_url, monster_type_id) 
             VALUES (?, ?, ?, ?)'
        );

        $stmt->execute([
            $name,
            $description,
            $image_url,
            $type_id
        ]);
    }

    public function updateMonster(int $id, string $name, string $description, string $image_url, int $type_id): void 
    {
        $stmt = $this->database->connect()->prepare(
            'UPDATE monsters 
             SET name = :name, 
                 description = :description, 
                 image_url = :image_url, 
                 monster_type_id = :type_id 
             WHERE id = :id'
        );

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $image_url, PDO::PARAM_STR);
        $stmt->bindParam(':type_id', $type_id, PDO::PARAM_INT);

        $stmt->execute();
    }

    public function deleteMonster(int $id): bool 
    {
        $stmt = $this->database->connect()->prepare(
            'DELETE FROM monsters WHERE id = :id'
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}