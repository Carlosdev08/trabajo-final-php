<?php
namespace App\Models;

class UserLogin extends BaseModel
{
    public function create(array $data): int
    {
        $sql = 'INSERT INTO users_login (idUser, usuario, password, rol)
                VALUES (:idUser, :usuario, :password, :rol)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idUser' => $data['idUser'],
            ':usuario' => $data['usuario'],
            ':password' => password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]),
            ':rol' => $data['rol'] ?? 'user',
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function findByUsuario(string $usuario): ?array
    {
        $stmt = $this->pdo->prepare('SELECT ul.*, ud.nombre, ud.apellidos 
                                     FROM users_login ul 
                                     JOIN users_data ud ON ul.idUser = ud.idUser 
                                     WHERE ul.usuario = :u');
        $stmt->execute([':u' => $usuario]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function updatePassword(int $idLogin, string $newPassword): bool
    {
        $sql = 'UPDATE users_login SET password = :password WHERE idLogin = :idLogin';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idLogin' => $idLogin,
            ':password' => password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12])
        ]);
    }

    public function update(int $idLogin, array $data): bool
    {
        $sql = 'UPDATE users_login SET usuario = :usuario, rol = :rol WHERE idLogin = :idLogin';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idLogin' => $idLogin,
            ':usuario' => $data['usuario'],
            ':rol' => $data['rol'] ?? 'user',
        ]);
    }

    public function delete(int $idLogin): bool
    {
        $sql = 'DELETE FROM users_login WHERE idLogin = :idLogin';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':idLogin' => $idLogin]);
    }

    public function getUsersWithData(): array
    {
        $sql = 'SELECT ul.*, ud.nombre, ud.apellidos, ud.email, ud.telefono, ud.direccion, ud.fecha_nacimiento, ud.sexo 
                FROM users_login ul 
                LEFT JOIN users_data ud ON ul.idUser = ud.idUser 
                ORDER BY ul.idLogin DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}