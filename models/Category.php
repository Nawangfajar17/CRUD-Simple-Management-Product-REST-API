<?php
class Category {
    private $conn;
    private $table = 'categories';

    public $id;
    public $name;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Baca semua kategori
    public function read() {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Baca satu kategori
    public function read_single() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ? LIMIT 0,1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }

    // Membuat kategori baru
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name, description = :description';
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Memperbarui kategori
    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET name = :name, description = :description WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':id', $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Menghapus kategori
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
