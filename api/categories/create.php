<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../db/Database.php';

$database = new Database();
$db = $database->connect();

$data = json_decode(file_get_contents("php://input"));

if(isset($data->name) && isset($data->description)) {
    $query = 'INSERT INTO categories (name, description) VALUES (:name, :description)';
    $stmt = $db->prepare($query);

    $stmt->bindParam(':name', $data->name);
    $stmt->bindParam(':description', $data->description);

    if($stmt->execute()) {
        echo json_encode(array('message' => 'Category Created'));
    } else {
        echo json_encode(array('message' => 'Category Not Created'));
    }
} else {
    echo json_encode(array('message' => 'Invalid Data'));
}
?>
