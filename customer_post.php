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


//  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $data = json_decode(file_get_contents('php://input'), true);
//   $name = $data['name'];
//     $address = $data['address'];
//     $mobile = $data['mobile'];
    
    
//       $sql = "SELECT * FROM customer";
//     $result = $conn->query($sql);
//     if ($result->num_rows > 0) {
//     $data_customer = array();
//     while ($row = $result->fetch_assoc()) {
//         $data_customer[] = $row;
//     }

//     if($data_customer['mobile'] == $mobile){
        
//          $status=http_response_code(400);
//     echo json_encode(['message' => 'Duplicate Entry','status'=>$status]);}
    
    
    
//     $stmt = $pdo->prepare("INSERT INTO customer(name,mobile,address)  VALUES (:name,:mobile,:address)");
//      $stmt->bindParam(':name', $name);
//     $stmt->bindParam(':address', $address);
//     $stmt->bindParam(':mobile', $mobile);
    
//     $stmt->execute();
    
//     echo json_encode(['message' => "Success"]);
// }





 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id = $data['id'];
    $name = $data['name'];
    $address = $data['address'];
    $mobile = $data['mobile'];
    $email = $data['email'];
   
    
  if($id == null)
  {
    $stmt = $pdo->prepare("INSERT INTO customer (name,email,address,mobile) VALUES (:name,:email,:address,:mobile)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':mobile', $mobile);
    $stmt->execute();
    $status=http_response_code(200);
    echo json_encode(['message' => 'Successfully added','status'=>$status]);
  }
  else
  {
       $stmt = $pdo->prepare("UPDATE customer SET name = :name , email = :email , address = :address , mobile = :mobile WHERE id = :id");
       $stmt->bindParam(':id',$id);
        $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':mobile', $mobile);
    
    if($stmt->execute()){
    $status=http_response_code(200);
    echo json_encode(['message' => 'Successfully Updated','status'=>$status]);
    }
    else{
        echo "Error updating";
        
    }
    
  
  }
  
    }   
 



?>
