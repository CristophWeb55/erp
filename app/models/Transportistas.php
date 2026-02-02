<?php

class Transportistas
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM transportistas ORDER BY nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActive()
    {
        $stmt = $this->db->query("SELECT * FROM transportistas WHERE activo = 1 ORDER BY nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM transportistas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO transportistas (nombre, rfc, telefono, correo, activo)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['rfc'] ?? '',
            $data['telefono'] ?? '',
            $data['correo'] ?? '',
            $data['activo'] ?? 1
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE transportistas
            SET nombre = ?, rfc = ?, telefono = ?, correo = ?, activo = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['nombre'],
            $data['rfc'] ?? '',
            $data['telefono'] ?? '',
            $data['correo'] ?? '',
            $data['activo'] ?? 1,
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM transportistas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
