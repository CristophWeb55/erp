<?php

class Terceros
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM terceros WHERE activo = 1 ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO terceros (nombre_razon_social, rfc, direccion, email, telefono, tipo, imagen_url) 
                VALUES (:nombre_razon_social, :rfc, :direccion, :email, :telefono, :tipo, :imagen_url)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre_razon_social' => $data['nombre_razon_social'],
            ':rfc' => $data['rfc'],
            ':direccion' => $data['direccion'],
            ':email' => $data['email'],
            ':telefono' => $data['telefono'],
            ':tipo' => $data['tipo'],
            ':imagen_url' => $data['imagen_url'] ?? null
        ]);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM terceros WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE terceros SET nombre_razon_social = :nombre_razon_social, rfc = :rfc, 
                direccion = :direccion, email = :email, telefono = :telefono, tipo = :tipo, imagen_url = :imagen_url 
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre_razon_social' => $data['nombre_razon_social'],
            ':rfc' => $data['rfc'],
            ':direccion' => $data['direccion'],
            ':email' => $data['email'],
            ':telefono' => $data['telefono'],
            ':tipo' => $data['tipo'],
            ':imagen_url' => $data['imagen_url'] ?? null
        ]);
    }

    public function getProveedores()
    {
        $stmt = $this->db->query("SELECT * FROM terceros WHERE tipo IN ('Proveedor', 'Ambos') AND activo = 1 ORDER BY nombre_razon_social ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("UPDATE terceros SET activo = 0 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
