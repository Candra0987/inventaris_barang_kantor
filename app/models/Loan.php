<?php

require_once __DIR__ . '/Model.php';

class Loan extends Model 
{
    // Membuat permintaan peminjaman baru
    public function create($employee_id, $item_id, $quantity)
    {
        $sql = "INSERT INTO loans (employee_id, item_id, quantity, requested_at) 
                VALUES (?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$employee_id, $item_id, $quantity]);
    }

    // Mendapatkan semua peminjaman berdasarkan karyawan
    public function byEmployee($employee_id)
    {
        $sql = "SELECT loans.*, items.name AS item_name
                FROM loans
                JOIN items ON loans.item_id = items.id
                WHERE employee_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$employee_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mendapatkan semua peminjaman lengkap (item + karyawan)
    public function all()
    {
        $sql = "SELECT loans.*, 
                       items.name AS item_name, 
                       employees.name AS employee_name,
                       loans.requested_at
                FROM loans
                JOIN items ON loans.item_id = items.id
                JOIN employees ON loans.employee_id = employees.id
                ORDER BY loans.requested_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mencari peminjaman berdasarkan ID
    public function find($id)
    {
        $sql = "SELECT * FROM loans WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mengubah status peminjaman
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE loans 
                SET status = ?, processed_at = NOW() 
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$status, $id]);
    }

    // Menghapus peminjaman
    public function delete($id)
    {
        $sql = "DELETE FROM loans WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    // REKAP PEMINJAMAN FIXED
    public function getRecap($start = null, $end = null)
    {
        $sql = "SELECT 
                    e.name AS employee_name,
                    i.name AS item_name,
                    SUM(l.quantity) AS quantity
                FROM loans l
                JOIN employees e ON l.employee_id = e.id
                JOIN items i ON l.item_id = i.id
                WHERE 1";

        $params = [];

        // Gunakan kolom requested_at
        if ($start) {
            $sql .= " AND l.requested_at >= ?";
            $params[] = $start . " 00:00:00";
        }

        if ($end) {
            $sql .= " AND l.requested_at <= ?";
            $params[] = $end . " 23:59:59";
        }

        $sql .= " GROUP BY e.name, i.name";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAll() {
    $stmt = $this->pdo->query("
        SELECT l.*, e.name AS employee_name, i.name AS item_name 
        FROM loans l 
        JOIN employees e ON l.employee_id = e.id 
        JOIN items i ON l.item_id = i.id
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getPaginated($limit, $offset)
{
    $stmt = $this->pdo->prepare("
        SELECT loans.*, employees.name AS employee_name, items.name AS item_name
        FROM loans
        JOIN employees ON loans.employee_id = employees.id
        JOIN items ON loans.item_id = items.id
        ORDER BY loans.requested_at DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countAll()
{
    return $this->pdo->query("SELECT COUNT(*) FROM loans")->fetchColumn();
}


}
