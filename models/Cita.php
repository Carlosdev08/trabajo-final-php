<?php
namespace App\Models;

class Cita extends BaseModel
{
    public function getAllByUser(int $idUser): array
    {
        $sql = 'SELECT c.*, ud.nombre, ud.apellidos 
                FROM citas c 
                JOIN users_data ud ON c.idUser = ud.idUser 
                WHERE c.idUser = :idUser 
                ORDER BY c.fecha_cita DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idUser' => $idUser]);
        return $stmt->fetchAll();
    }

    public function getAllWithUser(): array
    {
        $sql = 'SELECT c.*, ud.nombre, ud.apellidos 
                FROM citas c 
                JOIN users_data ud ON c.idUser = ud.idUser 
                ORDER BY c.fecha_cita DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function create(array $data): int
    {
        $sql = 'INSERT INTO citas (idUser, fecha_cita, motivo_cita) 
                VALUES (:idUser, :fecha_cita, :motivo_cita)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':idUser' => $data['idUser'],
            ':fecha_cita' => $data['fecha_cita'],
            ':motivo_cita' => $data['motivo_cita'] ?? null,
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $idCita, array $data): bool
    {
        $sql = 'UPDATE citas SET fecha_cita = :fecha_cita, motivo_cita = :motivo_cita 
                WHERE idCita = :idCita';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idCita' => $idCita,
            ':fecha_cita' => $data['fecha_cita'],
            ':motivo_cita' => $data['motivo_cita'] ?? null,
        ]);
    }

    public function delete(int $idCita): bool
    {
        $sql = 'DELETE FROM citas WHERE idCita = :idCita';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':idCita' => $idCita]);
    }

    public function findById(int $idCita): ?array
    {
        $sql = 'SELECT c.*, ud.nombre, ud.apellidos 
                FROM citas c 
                JOIN users_data ud ON c.idUser = ud.idUser 
                WHERE c.idCita = :idCita';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idCita' => $idCita]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function canModify(int $idCita, int $idUser): bool
    {
        $sql = 'SELECT COUNT(*) FROM citas 
                WHERE idCita = :idCita AND idUser = :idUser AND fecha_cita >= CURDATE()';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idCita' => $idCita, ':idUser' => $idUser]);
        return $stmt->fetchColumn() > 0;
    }
}


// ========== app/Controllers/HomeController.php ==========
?>