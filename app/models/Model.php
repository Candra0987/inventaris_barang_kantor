<?php

class Model
{
    protected $pdo;

    public function __construct()
    {
        $cfg = require __DIR__ . '/../../config/database.php';

        $dsn = "mysql:host={$cfg['host']};dbname={$cfg['db']};charset={$cfg['charset']}";

        $this->pdo = new PDO(
            $dsn,
            $cfg['user'],
            $cfg['pass'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
    public function getRecapFiltered($start, $end)
{
    $query = "SELECT e.name AS employee_name, i.name AS item_name, SUM(l.quantity) AS quantity
              FROM loans l
              JOIN employees e ON l.employee_id = e.id
              JOIN items i ON l.item_id = i.id
              WHERE l.loan_date BETWEEN :start AND :end
              GROUP BY l.employee_id, l.item_id";

    $stmt = $this->pdo->prepare($query);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
