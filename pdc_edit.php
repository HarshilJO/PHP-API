<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With,Authorization,Content-Type');
$host = 'localhost';
$db = 'sample';
$user = 'harshil';
$pass = 'Shreyu@18';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
     $id=$data['id'];
    $name = $data['name'];
    $price = $data['price'];
    $tax = $data['tax'];
    
    if($id !=null){
        $taxAmount = ($price * $tax) / 100;
    $mrp =$price +  $taxAmount;
        $stmt = $pdo->prepare("UPDATE product SET name = :name, price =:price ,tax=:tax,mrp=$mrp WHERE id=:id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':tax', $tax);
    $stmt->execute();
      
    }
    else{
        $taxAmount = ($price * $tax) / 100;
    $mrp =$price +  $taxAmount;
          $stmt = $pdo->prepare("INSERT INTO product(name,price,tax,mrp)  VALUES (:name,:price,:tax,$mrp)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':tax', $tax);
    $stmt->execute();
    }
    
    echo json_encode(['message' => "Success"]);
}


?>