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
            'SELECT * FROM monsters ORDER BY name ASC'
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

    public function deleteMonster(int $id): bool 
    {
        $stmt = $this->database->connect()->prepare(
            'DELETE FROM monsters WHERE id = :id'
        );
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}