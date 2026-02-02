<?php

class Vehiculos
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $stmt = $this->db->query("
            SELECT v.*, t.nombre as transportista_nombre
            FROM vehiculos v
            LEFT JOIN transportistas t ON v.transportista_id = t.id
            ORDER BY v.placas ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActive()
    {
        $stmt = $this->db->query("SELECT * FROM vehiculos WHERE activo = 1 ORDER BY placas ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM vehiculos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO vehiculos (placas, marca_modelo, tipo, transportista_id, activo)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['placas'],
            $data['marca_modelo'] ?? '',
            $data['tipo'] ?? '',
            $data['transportista_id'] ?: null,
            $data['activo'] ?? 1
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE vehiculos
            SET placas = ?, marca_modelo = ?, tipo = ?, transportista_id = ?, activo = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['placas'],
            $data['marca_modelo'] ?? '',
            $data['tipo'] ?? '',
            $data['transportista_id'] ?: null,
            $data['activo'] ?? 1,
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM vehiculos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
