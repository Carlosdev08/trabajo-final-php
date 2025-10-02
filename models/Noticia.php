<?php
namespace App\Models;

class Noticia extends BaseModel
{
    public function allWithAuthor(): array
    {
        $sql = 'SELECT n.*, ud.nombre, ud.apellidos
                FROM noticias n
                JOIN users_data ud ON ud.idUser = n.idUser
                ORDER BY n.fecha DESC, n.idNoticia DESC';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function create(array $data): int
    {
        $sql = 'INSERT INTO noticias (titulo, imagen, texto, fecha, idUser) 
                VALUES (:titulo, :imagen, :texto, :fecha, :idUser)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $data['titulo'],
            ':imagen' => $data['imagen'],
            ':texto' => $data['texto'],
            ':fecha' => $data['fecha'] ?? date('Y-m-d'),
            ':idUser' => $data['idUser'],
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $idNoticia, array $data): bool
    {
        $sql = 'UPDATE noticias SET 
                titulo = :titulo, 
                imagen = :imagen, 
                texto = :texto 
                WHERE idNoticia = :idNoticia';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':idNoticia' => $idNoticia,
            ':titulo' => $data['titulo'],
            ':imagen' => $data['imagen'],
            ':texto' => $data['texto'],
        ]);
    }

    public function delete(int $idNoticia): bool
    {
        $sql = 'DELETE FROM noticias WHERE idNoticia = :idNoticia';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':idNoticia' => $idNoticia]);
    }

    public function findById(int $idNoticia): ?array
    {
        $sql = 'SELECT n.*, ud.nombre, ud.apellidos 
                FROM noticias n 
                JOIN users_data ud ON n.idUser = ud.idUser 
                WHERE n.idNoticia = :idNoticia';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idNoticia' => $idNoticia]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getAll(): array
    {
        $sql = 'SELECT * FROM noticias ORDER BY fecha DESC, idNoticia DESC';
        return $this->pdo->query($sql)->fetchAll();
    }
}