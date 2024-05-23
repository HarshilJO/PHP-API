<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With,Authorization,Content-Type');
// $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

// // Create token payload as a JSON string
// $payload = json_encode(['user_id' => 123]);

// // Encode Header to Base64Url String
// $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

// // Encode Payload to Base64Url String
// $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

// // Create Signature Hash
// $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'abC123!', true);

// // Encode Signature to Base64Url String
// $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

// // Create JWT
// $token = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

// // echo $jwt;

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
//     $uname = $data['username'];
//     $pass=$data['password'];
//       echo $e->getMessage();
//     // $stmt = $pdo->prepare("INSERT INTO items ( name, description) VALUES (:name,:description)");
//   $stmt = $pdo->prepare("SELECT * FROM admin WHERE username=$uname AND password=$pass");
//     $stmt->bindParam(':username', $uname);
//     $stmt->bindParam(':passwrod', $pass);
//     $stmt->execute();
  
//     $row= $stmt->fetch(PDO::FETCH_ASSOC);
//   if($row){
       
//       echo json_encode(['data' => ['token']]);
//   }
//     // $stmt = $pdo->prepare("INSERT INTO items (id, name, description) VALUES (105,:name,'description')");
   
    
//     echo json_encode(['message' => "Success"]);
// }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data from the request body
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Check if username and password keys exist in the decoded JSON
    if (isset($data['username']) && isset($data['password'])) {
        // Assign username and password variables
        $uname = $data['username'];
        $pass = $data['password'];
        
        // Prepare SQL statement to prevent SQL injection
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username=:username AND password=:password");
        $stmt->bindParam(':username', $uname);
        $stmt->bindParam(':password', $pass);
        
        // Execute the prepared statement
        $stmt->execute();
        
        // Fetch the result row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if a row was found
        if ($row) {
            
            $token = $row['token'];
            $id = $row['id'];
            $un=$row['username'];
            $status=http_response_code(200);
            echo json_encode(['message' => 'Success', 'data' => ['token' => $token,'username' => $un,'id'=>$id],'status'=>$status]);
        } else {
            $stat=http_response_code(401);
            // If no row was found, echo an error message
            echo json_encode(['message' => 'Invalid username or password','error'=>'Invalid username or password','stat'=>$stat]);
        }
    } else {
        // If username or password keys are missing in the JSON, echo an error message
        echo json_encode(['message' => 'Username or password not provided']);
    }
} else {
    // If the request method is not POST, echo an error message
    echo json_encode(['message' => 'Invalid request method']);
}




?>
