<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

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

// подготовка объекта 
$product = new Product($db);

// установим свойство ID записи для чтения 
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

// прочитаем детали товара для редактирования 
$product->readOne();

if ($product->name != null) {

    // создание массива 
    $product_arr = array(
        "id" =>  $product->id,
        "name" => $product->name,
        "description" => $product->description,
        "price" => $product->price,
        "amount" => $product->amount,
        "created_at" => $product->created_at,
        "updated_at" => $product->updated_at,
    );

    // код ответа - 200 OK 
    http_response_code(200);

    // вывод в формате json 
    echo json_encode($product_arr);
}

else {
    // код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщим пользователю, что товар не существует 
    echo json_encode(array("message" => "Товар не существует.", "status" => 0), JSON_UNESCAPED_UNICODE);
}
