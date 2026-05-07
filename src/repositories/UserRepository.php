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
}