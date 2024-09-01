<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../db/Database.php';

$database = new Database();
$db = $database->connect();

$query = 'SELECT id, name, description FROM categories';
$stmt = $db->prepare($query);
$stmt->execute();

$num = $stmt->rowCount();

if($num > 0) {
    $categories_arr = array();
    $categories_arr['data'] = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = array(
            'id' => $id,
            'name' => $name,
            'description' => $description
        );

        array_push($categories_arr['data'], $category_item);
    }

    echo json_encode($categories_arr);

} else {
    echo json_encode(array('message' => 'No Categories Found'));
}
?>
