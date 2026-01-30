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
        $stmt = $this->db->query("SELECT * FROM terceros ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO terceros (nombre_razon_social, rfc, direccion, email, telefono, tipo) 
                VALUES (:nombre_razon_social, :rfc, :direccion, :email, :telefono, :tipo)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre_razon_social' => $data['nombre_razon_social'],
            ':rfc' => $data['rfc'],
            ':direccion' => $data['direccion'],
            ':email' => $data['email'],
            ':telefono' => $data['telefono'],
            ':tipo' => $data['tipo']
        ]);
    }
}
