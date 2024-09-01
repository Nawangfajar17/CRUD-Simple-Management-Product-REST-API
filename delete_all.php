<?php
require '../db/connection.php';

// Hapus semua data dari tabel categories
$stmt = $pdo->prepare("DELETE FROM categories");
$stmt->execute();

// Atur ulang nilai AUTO_INCREMENT ke 1
$pdo->exec("ALTER TABLE categories AUTO_INCREMENT = 1");

header('Location: index.php');
?>
