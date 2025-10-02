<?php
namespace App\Models;


class UserData extends BaseModel
{
    public function create(array $data): int
    {
        $sql = 'INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo)
VALUES (:nombre, :apellidos, :email, :telefono, :fecha_nacimiento, :direccion, :sexo)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $data['nombre'],
            ':apellidos' => $data['apellidos'],
            ':email' => $data['email'],
            ':telefono' => $data['telefono'],
            ':fecha_nacimiento' => $data['fecha_nacimiento'],
            ':direccion' => $data['direccion'] ?? null,
            ':sexo' => $data['sexo'] ?? null,
        ]);
        return (int) $this->pdo->lastInsertId();
    }


    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users_data WHERE idUser = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE users_data SET 
                nombre = :nombre, 
                apellidos = :apellidos, 
                email = :email, 
                telefono = :telefono, 
                fecha_nacimiento = :fecha_nacimiento, 
                direccion = :direccion, 
                sexo = :sexo 
                WHERE idUser = :id';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $data['nombre'],
            ':apellidos' => $data['apellidos'],
            ':email' => $data['email'],
            ':telefono' => $data['telefono'],
            ':fecha_nacimiento' => $data['fecha_nacimiento'],
            ':direccion' => $data['direccion'] ?? null,
            ':sexo' => $data['sexo'] ?? null,
        ]);
    }

    public function getAll(): array
    {
        $sql = 'SELECT ud.*, ul.usuario, ul.rol 
                FROM users_data ud 
                LEFT JOIN users_login ul ON ud.idUser = ul.idUser 
                ORDER BY ud.nombre, ud.apellidos';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM users_data WHERE idUser = :id';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}