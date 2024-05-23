<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With,Authorization,Content-Type');
$host = 'localhost';
$db = 'sample';
$user = 'harshil';
$pass = 'Shreyu@18';
// product: [
//     id: 0,
//     product_name: '',
//     quantity: '',
//     GST: '',
//     Price: '',
//     discount:'',
//     total: ''
//   ]

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
    $name = $data['product_name'];
    $price = $data['price'];
    $tax = $data['tax'];
    $taxAmount = ($price * $tax) / 100;
    $mrp =$price +  $taxAmount;
    $quantity = $data['quantity'];
    // $disc = $data['discount'];
    $total=$price * $quantity ;
    $newProductData = [
    
    'product_name' => $name,
    'quantity' => $quantity,
    'GST' => $tax ,
    'Price' => $mrp,
    'discount' => 0,
    'total' => 0
];

$newProductJson = json_encode([$newProductData]);

// Escape the JSON string for SQL
$newProductJson = $conn->real_escape_string($newProductJson);

// Update the customer's product data in the database
$sql = "UPDATE customer SET product = CONCAT(product, ?, ',') WHERE id = $id";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $newProductJson, $customerId);


    // $stmt = $pdo->prepare("UPDATE product SET name = :name, price =:price ,tax=:tax WHERE id=:id");
    // $stmt->bindParam(':id', $id);
    // $stmt->bindParam(':name', $name);
    // $stmt->bindParam(':price', $price);
    // $stmt->bindParam(':tax', $tax);
    $stmt->execute();
    
    echo json_encode(['message' => "Success"]);
}


?>
