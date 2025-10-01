<?php
require_once __DIR__ . "/../utils/functions.php"; // for getDatabaseConnection()

class Friend
{
    public static function all()
    {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->query("SELECT * FROM friends ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("SELECT * FROM friends WHERE id = :id");
        $stmt->execute([":id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("
            INSERT INTO friends (name, gender, phone, city, email, created_at)
            VALUES (:name, :gender, :phone, :city, :email, NOW())
        ");
        return $stmt->execute([
            ":name"   => $data["name"],
            ":gender" => $data["gender"],
            ":phone"  => $data["phone"],
            ":city"   => $data["city"],
            ":email"  => $data["email"],
        ]);
    }

    public static function update($id, $data)
    {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("
            UPDATE friends 
            SET name = :name, gender = :gender, phone = :phone, city = :city, email = :email
            WHERE id = :id
        ");
        return $stmt->execute([
            ":id"     => $id,
            ":name"   => $data["name"],
            ":gender" => $data["gender"],
            ":phone"  => $data["phone"],
            ":city"   => $data["city"],
            ":email"  => $data["email"],
        ]);
    }

    public static function delete($id)
    {
        $pdo = getDatabaseConnection();
        $stmt = $pdo->prepare("DELETE FROM friends WHERE id = :id");
        return $stmt->execute([":id" => $id]);
    }
}
