<?php
require_once __DIR__ . '/Model.php';
class Category extends Model {
    public function all(){ return $this->pdo->query('SELECT * FROM categories')->fetchAll(PDO::FETCH_ASSOC); }
    public function find($id){ $stmt=$this->pdo->prepare('SELECT * FROM categories WHERE id=?'); $stmt->execute([$id]); return $stmt->fetch(PDO::FETCH_ASSOC); }
    public function create($name){ $stmt=$this->pdo->prepare('INSERT INTO categories (name) VALUES (?)'); $stmt->execute([$name]); }
    public function update($id,$name){ $stmt=$this->pdo->prepare('UPDATE categories SET name=? WHERE id=?'); $stmt->execute([$name,$id]); }
    public function delete($id){ $stmt=$this->pdo->prepare('DELETE FROM categories WHERE id=?'); $stmt->execute([$id]); }
    public function getPaginated($limit, $offset)
{
    $stmt = $this->pdo->prepare("
        SELECT * FROM categories
        ORDER BY id DESC
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function countAll()
{
    return $this->pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
}

}


