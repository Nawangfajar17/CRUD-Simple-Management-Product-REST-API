<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../db/Database.php';

$database = new Database();
$db = $database->connect();

$id = isset($_GET['id']) ? $_GET['id'] : die();

$query = 'SELECT id, name, description FROM categories WHERE id = :id';
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();

if($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    extract($row);

    $category_item = array(
        'id' => $id,
        'name' => $name,
        'description' => $description
    );

    echo json_encode($category_item);
} else {
    echo json_encode(array('message' => 'No Category Found'));
}
?>
