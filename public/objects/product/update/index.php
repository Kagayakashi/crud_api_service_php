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

// получаем данные товара для редактирования 
$data = json_decode(file_get_contents("php://input"));

// убеждаемся, что данные не пусты 
if (
	!empty($data->id) &&
    !empty($data->name) &&
    !empty($data->price) &&
    !empty($data->description) &&
    !empty($data->amount)
) {
	// установим значения свойств товара
	$product->id = $data->id;
	$product->name = $data->name;
	$product->price = $data->price;
	$product->description = $data->description;
	$product->amount = $data->amount;
	$product->updated_at = date('Y-m-d H:i:s');

	// обновление товара 
	if ($product->update()) {

	    // установим код ответа - 200 ok 
	    http_response_code(200);

	    // сообщим пользователю 
	    echo json_encode(array("message" => "Товар был обновлён.", "status" => 1), JSON_UNESCAPED_UNICODE);
	}
	// если не удается обновить товар, сообщим пользователю 
	else {

	    // код ответа - 500 Сервис не доступен 
	    http_response_code(500);

	    // сообщение пользователю 
	    echo json_encode(array("message" => "Невозможно изменить товар.", "status" => 0), JSON_UNESCAPED_UNICODE);
	}
}

// сообщим пользователю что данные неполные 
else {

    // установим код ответа - 400 неверный запрос 
    http_response_code(400);

    // сообщим пользователю 
    echo json_encode(array("message" => "Невозможно изменить товар. Данные неполные."), JSON_UNESCAPED_UNICODE);
}
