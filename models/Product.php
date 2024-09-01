<?php
class Product {
    private $conn;
    private $table = 'products';

    public $id;
    public $category_id;
    public $name;
    public $description;
    public $price;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Baca semua produk
    public function read() {
        $query = 'SELECT p.id, p.name, p.description, p.price, c.name as category_name FROM ' . $this->table . ' p 
                  LEFT JOIN categories c ON p.category_id = c.id';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Baca satu produk
    public function read_single() {
        $query = 'SELECT p.id, p.name, p.description, p.price, c.name as category_name FROM ' . $this->table . ' p 
                  LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 0,1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }

    // Membuat produk baru
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET category_id = :category_id, name = :name, description = :description, price = :price';
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Memperbarui produk
    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET category_id = :category_id, name = :name, description = :description, price = :price WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Menghapus produk
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
