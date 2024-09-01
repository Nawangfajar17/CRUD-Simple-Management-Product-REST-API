<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../db/Database.php';

$database = new Database();
$db = $database->connect();

$id = isset($_GET['id']) ? $_GET['id'] : die();

$query = 'SELECT p.id, p.name, p.description, p.price, c.name as category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE p.id = :id';
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();

if($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    extract($row);

    $product_item = array(
        'id' => $id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'category_name' => $category_name
    );

    echo json_encode($product_item);
} else {
    echo json_encode(array('message' => 'No Product Found'));
}
?>
