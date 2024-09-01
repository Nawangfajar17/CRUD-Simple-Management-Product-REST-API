<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../db/Database.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if(isset($data->id) && isset($data->name) && isset($data->description) && isset($data->price) && isset($data->category_id)) {
    $query = 'UPDATE products SET name = :name, description = :description, price = :price, category_id = :category_id WHERE id = :id';
    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $data->id);
    $stmt->bindParam(':name', $data->name);
    $stmt->bindParam(':description', $data->description);
    $stmt->bindParam(':price', $data->price);
    $stmt->bindParam(':category_id', $data->category_id);

    if($stmt->execute()) {
        echo json_encode(array('message' => 'Product Updated'));
    } else {
        echo json_encode(array('message' => 'Product Not Updated'));
    }
} else {
    echo json_encode(array('message' => 'Invalid Data'));
}
?>
