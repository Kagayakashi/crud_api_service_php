<?php
class Product {

    // подключение к базе данных и таблице 'products' 
    private $conn;
    private $table_name = "products";

    // свойства объекта 
    public $id;
    public $name;
    public $description;
    public $price;
    public $amount;
    public $created_at;
    public $updated_at;

    // конструктор для соединения с базой данных 
    public function __construct($db){
        $this->conn = $db;
    }

    // метод read() - получение товаров 
	function read(){

	    // выбираем все записи 
	    $query = "SELECT
	                id, name, description, price, amount, created_at, updated_at
	            FROM
	                " . $this->table_name . "
	            ORDER BY
	                created_at DESC";

	    // подготовка запроса 
	    $stmt = $this->conn->prepare($query);

	    // выполняем запрос 
	    $stmt->execute();

	    return $stmt;
	}

	// метод create - создание товаров 
	function create(){

	    // запрос для вставки (создания) записей 
	    $query = "INSERT INTO
	                " . $this->table_name . "
	            SET
	                name=:name,
	                price=:price,
	                description=:description,
	                amount=:amount";

	    // подготовка запроса 
	    $stmt = $this->conn->prepare($query);

	    // очистка 
	    $this->name = htmlspecialchars(strip_tags($this->name));
	    $this->price = htmlspecialchars(strip_tags($this->price));
	    $this->description = htmlspecialchars(strip_tags($this->description));
	    $this->amount = htmlspecialchars(strip_tags($this->amount));

	    // привязка значений 
	    $stmt->bindParam(":name", $this->name);
	    $stmt->bindParam(":price", $this->price);
	    $stmt->bindParam(":description", $this->description);
	    $stmt->bindParam(":amount", $this->amount);

	    // выполняем запрос 
	    if ($stmt->execute()) {
	        return true;
	    }

	    return false;
	}

	// используется при заполнении формы обновления товара 
	function readOne() {

	    // запрос для чтения одной записи (товара) 
	    $query = "SELECT
	                id, name, description, price, amount, created_at, updated_at
	            FROM
	                " . $this->table_name . "
	            WHERE
	                id = ?
	            LIMIT
	                0,1";

	    // подготовка запроса 
	    $stmt = $this->conn->prepare( $query );

	    // привязываем id товара, который будет обновлен 
	    $stmt->bindParam(1, $this->id);

	    // выполняем запрос 
	    $stmt->execute();

	    // получаем извлеченную строку 
	    $row = $stmt->fetch(PDO::FETCH_ASSOC);

	    // установим значения свойств объекта 
	    $this->name = $row['name'];
	    $this->price = $row['price'];
	    $this->description = $row['description'];
	    $this->amount = $row['amount'];
	    $this->created_at = $row['created_at'];
	    $this->updated_at = $row['updated_at'];
	}

	// метод update() - обновление товара 
	function update(){

	    // запрос для обновления записи (товара) 
	    $query = "UPDATE
	                " . $this->table_name . "
	            SET
	                name = :name,
	                price = :price,
	                description = :description,
	                amount = :amount,
	                updated_at = :updated_at
	            WHERE
	                id = :id";

	    // подготовка запроса 
	    $stmt = $this->conn->prepare($query);

	    // очистка 
	    $this->name=htmlspecialchars(strip_tags($this->name));
	    $this->price=htmlspecialchars(strip_tags($this->price));
	    $this->description=htmlspecialchars(strip_tags($this->description));
	    $this->amount=htmlspecialchars(strip_tags($this->amount));
	    $this->id=htmlspecialchars(strip_tags($this->id));
	    $this->updated_at=htmlspecialchars(strip_tags($this->updated_at));

	    // привязываем значения 
	    $stmt->bindParam(':name', $this->name);
	    $stmt->bindParam(':price', $this->price);
	    $stmt->bindParam(':description', $this->description);
	    $stmt->bindParam(':amount', $this->amount);
	    $stmt->bindParam(':updated_at', $this->updated_at);
	    $stmt->bindParam(':id', $this->id);

	    // выполняем запрос 
	    if ($stmt->execute()) {
	        return true;
	    }

	    return false;
	}

	// метод delete - удаление товара 
	function delete(){

	    // запрос для удаления записи (товара) 
	    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

	    // подготовка запроса 
	    $stmt = $this->conn->prepare($query);

	    // очистка 
	    $this->id=htmlspecialchars(strip_tags($this->id));

	    // привязываем id записи для удаления 
	    $stmt->bindParam(1, $this->id);

	    // выполняем запрос 
	    if ($stmt->execute()) {
	        return true;
	    }

	    return false;
	}
}
