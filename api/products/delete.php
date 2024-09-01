<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../db/Database.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if(isset($data->id)) {
    $query = 'DELETE FROM products WHERE id = :id';
    $stmt = $db->prepare($query);

    $stmt->bindParam(':id', $data->id);

    if($stmt->execute()) {
        echo json_encode(array('message' => 'Product Deleted'));
    } else {
        echo json_encode(array('message' => 'Product Not Deleted'));
    }
} else {
    echo json_encode(array('message' => 'Invalid Data'));
}
?>
