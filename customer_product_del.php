<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With,Authorization,Content-Type');
$host = 'localhost';
$db = 'sample';
$user = 'harshil';
$pass = 'Shreyu@18';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents('php://input'), true);
    $pid = $data['pid'];
    $id=   $data['id'];
$sql = "SELECT id, product FROM customer WHERE id = $id"; 
$result = $conn->query($sql);
$row=array();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $existingJson = json_decode($row['product'], true);
} else {
    die("Record not found");
}
$counter = 0;
foreach($existingJson as $element )
{
    
    if($element['id']==$pid){
        array_splice($existingJson,$counter);
    }
    $counter+=1;
}

$newJson = json_encode($existingJson, JSON_UNESCAPED_UNICODE);
$updateSql = "UPDATE `customer` SET `product` = '$newJson' WHERE `id` = $id"; 

if ($conn->query($updateSql) === TRUE) {
     $status=http_response_code(200);
    echo json_encode(['message' => 'Successfully Deleted','data'=>'Success','status'=>$status]);
} else {
    echo "Error updating record: " . $conn->error;

}


}

$conn->close();
?>