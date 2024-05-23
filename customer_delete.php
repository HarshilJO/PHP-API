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
    $id = $data['id'];
    $stmt = $pdo->prepare("DELETE FROM customer WHERE id = :id;");
    $stmt->bindParam(':id', $id);
   
    if ( $stmt->execute()) {
     $status=http_response_code(200);
    echo json_encode(['message' => 'Successfully Deleted','data'=>'Success','status'=>$status]);
} else {
    echo "Error updating record: ";

}
    
  
}


?>