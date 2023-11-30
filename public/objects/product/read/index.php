<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// получаем соединение с базой данных 
include_once '../../../../config/i_default.cfg';
include_once '../../../../i_custom.cfg';
include_once '../../../../config/database.php';
// создание объекта товара 
include_once '../../product.php';

// получаем соединение с базой данных 
$database = new Database();
// параметры подключения
$database->set_host($i_cfg['db_host']);
$database->set_database($i_cfg['db_shema']);
$database->set_username($i_cfg['db_login']);
$database->set_password($i_cfg['db_pwd']);
// создать подключение
$db = $database->getConnection();

// инициализируем объект 
$product = new Product($db);
 
// запрашиваем товары 
$stmt = $product->read();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей 
if ($num > 0) {

    // массив товаров 
    $products_arr = array();
    $products_arr["records"] = array();

    // получаем содержимое нашей таблицы 
    // fetch() быстрее, чем fetchAll() 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // извлекаем строку 
        extract($row);

        $product_item = array(
            "id"          => $id,
            "name"        => $name,
            "description" => html_entity_decode($description),
            "price"       => $price,
            "amount"      => $amount,
            "created_at"  => $created_at,
            "updated_at"  => $updated_at
        );

        array_push($products_arr["records"], $product_item);
    }

    // устанавливаем код ответа - 200 OK 
    http_response_code(200);

    // выводим данные о товаре в формате JSON 
    echo json_encode($products_arr);
}
else {
    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Товары не найдены.", "status" => 0), JSON_UNESCAPED_UNICODE);
}
