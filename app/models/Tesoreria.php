<?php

class Tesoreria
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function registerPayment($data)
    {
        $this->db->beginTransaction();
        try {
            // 1. Create Payment record
            $sql = "INSERT INTO pagos (factura_id, fecha_pago, monto, forma_pago, referencia) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $data['factura_id'],
                $data['fecha_pago'],
                $data['monto'],
                $data['forma_pago'],
                $data['referencia']
            ]);

            // 2. Update Invoice balance
            $stmtU = $this->db->prepare("UPDATE facturas SET saldo_pendiente = saldo_pendiente - ? WHERE id = ?");
            $stmtU->execute([$data['monto'], $data['factura_id']]);

            // 3. Check if paid in full
            $stmtC = $this->db->prepare("SELECT saldo_pendiente FROM facturas WHERE id = ?");
            $stmtC->execute([$data['factura_id']]);
            $res = $stmtC->fetch();

            if ($res['saldo_pendiente'] <= 0) {
                $stmtS = $this->db->prepare("UPDATE facturas SET estatus = 'Pagada' WHERE id = ?");
                $stmtS->execute([$data['factura_id']]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
