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
   $conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $json_data = $data;
     $status=http_response_code(200);
    echo json_encode(['message' => 'Success', 'data' => $json_data,'status'=>$status]);
} else {
    echo "No records found";
}


$conn->close();

} catch (PDOException $e) {
    
    echo "Error: " . $e->getMessage();
}


?>
