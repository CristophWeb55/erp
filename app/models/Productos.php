<?php

class Productos
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM productos ORDER BY sku ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO productos (sku, descripcion, precio_venta, requiere_pedimento) 
                VALUES (:sku, :descripcion, :precio_venta, :requiere_pedimento)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':sku' => $data['sku'],
            ':descripcion' => $data['descripcion'],
            ':precio_venta' => $data['precio_venta'],
            ':requiere_pedimento' => $data['requiere_pedimento']
        ]);
    }
}
