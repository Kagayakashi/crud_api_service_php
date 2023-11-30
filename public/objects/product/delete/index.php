<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

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

// получаем id товара 
$data = json_decode(file_get_contents("php://input"));

// установим id товара для удаления 
$product->id = $data->id;

// удаление товара 
if ($product->delete()) {

    // код ответа - 200 ok 
    http_response_code(200);

    // сообщение пользователю 
    echo json_encode(array("message" => "Товар был удалён.", "status" => 1), JSON_UNESCAPED_UNICODE);
}

// если не удается удалить товар 
else {

    // код ответа - 500 Сервис не доступен 
    http_response_code(500);

    // сообщим об этом пользователю 
    echo json_encode(array("message" => "Не удалось удалить товар.", "status" => 0));
}
