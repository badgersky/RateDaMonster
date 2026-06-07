<?php

require_once 'Repository.php';

class UserRepository extends Repository {

    public function getUsers(): ?array 
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM users;"
        );
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchUsersPaginated(string $search, int $limit, int $offset): array
    {
        $stmt = $this->database->connect()->prepare("
            SELECT id, username
            FROM users
            WHERE username ILIKE :search
            ORDER BY username
            LIMIT :limit OFFSET :offset
        ");

        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSearchUsers(string $search): int
    {
        $stmt = $this->database->connect()->prepare("
            SELECT COUNT(*)
            FROM users
            WHERE username ILIKE :search
        ");

        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function getUser(string $username): ?array 
    {
        $query = $this->database->connect()->prepare(
            "SELECT * FROM users WHERE username = :username;"
        );
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function addUser(string $username, string $password): void 
    {
        $query = $this->database->connect()->prepare(
            "INSERT INTO users (username, password, account_type_id) 
             VALUES (?, ?, ?);"
        );

        $query->execute([
            $username,
            $password,
            1
        ]);
    }

    public function deleteUser(int $id): void 
    {
    $query = $this->database->connect()->prepare(
        "DELETE FROM users WHERE id = :id;"
    );
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    }

    public function getUsersPaginated(int $limit, int $offset): array
    {
        $stmt = $this->database->connect()->prepare("
            SELECT id, username
            FROM users
            ORDER BY username
            LIMIT :limit OFFSET :offset
        ");

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUsers(): int
    {
        $stmt = $this->database->connect()->query("
            SELECT COUNT(*) FROM users
        ");

        return (int) $stmt->fetchColumn();
    }
}