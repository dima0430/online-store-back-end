<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/product.php';


$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$stmt = $product->read();
$num = $stmt->rowCount();


if ($num>0) {

    $products_arr=array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        $product_item=array(
            "id" => $idProduct,
            "name" => $name,
            "description" =>$description,
            "price" => $price,
            "image"=> $image,
            "brand" =>$brand,
            "count"=>$count,
            "category_id" => $idCategory,
            "category_name"=>$category_name 
        );

        array_push($products_arr, $product_item);
    }


    http_response_code(200);


    echo json_encode($products_arr,JSON_UNESCAPED_UNICODE);
}

else {

    http_response_code(404);

    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}  