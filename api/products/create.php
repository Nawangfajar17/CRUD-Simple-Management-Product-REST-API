<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../db/Database.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if(isset($data->name) && isset($data->description) && isset($data->price) && isset($data->category_id)) {
    $query = 'INSERT INTO products (category_id, name, description, price) VALUES (:category_id, :name, :description, :price)';
    $stmt = $db->prepare($query);

    $stmt->bindParam(':category_id', $data->category_id);
    $stmt->bindParam(':name', $data->name);
    $stmt->bindParam(':description', $data->description);
    $stmt->bindParam(':price', $data->price);

    if($stmt->execute()) {
        echo json_encode(array('message' => 'Product Created'));
    } else {
        echo json_encode(array('message' => 'Product Not Created'));
    }
} else {
    echo json_encode(array('message' => 'Invalid Data'));
}
?>
