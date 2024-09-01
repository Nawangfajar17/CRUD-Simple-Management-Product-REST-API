<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../db/Database.php';

$database = new Database();
$db = $database->connect();

$query = 'SELECT p.id, p.name, p.description, p.price, c.name as category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id';
$stmt = $db->prepare($query);
$stmt->execute();

$num = $stmt->rowCount();

if($num > 0) {
    $products_arr = array();
    $products_arr['data'] = array();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $product_item = array(
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category_name' => $category_name
        );

        array_push($products_arr['data'], $product_item);
    }

    echo json_encode($products_arr);

} else {
    echo json_encode(array('message' => 'No Products Found'));
}
?>
