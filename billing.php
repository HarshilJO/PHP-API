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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$data = json_decode(file_get_contents('php://input'), true);
$cust_id = $data['cust_id'];

    $sql = "SELECT * FROM customer where id=$cust_id";
$tot_sql = "SELECT total FROM customer where id=$cust_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $data = array();
    $jsonArray = array();
    while ($row = $result->fetch_assoc()) {
           $data = json_decode($row['product'], true);
        $row['product'] = $data;
          $jsonArray[] = $row;
    }
    
     $status=http_response_code(200);
    echo json_encode(['message' => 'Success', 'data' => $jsonArray,'status'=>$status]);
}else {
    // $status=http_response_code(200);
    //  echo json_encode(['message' => 'no entry found', 'data' => [],'status'=>$status]);
}


}
// Close the database connection
$conn->close();

} catch (PDOException $e) {
    // Handle database connection errors
    echo "Error: " . $e->getMessage();
}


?>
