<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-Requested-With,Authorization,Content-Type");

$host = "localhost";
$db = "sample";
$user = "harshil";
$pass = "Shreyu@18";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["cust_id"];
    $pdc_name = $data["product_name"];
    $qty = $data["cquantity"];
    $tax = $data["tax"];
    $price = $data["price"];
    $taxAmount = ($price * $tax) / 100;
    $mrp = $price + $taxAmount;
    $tat = $mrp * $qty;

  $checkProductSql = "SELECT product FROM customer WHERE id = $id";
$checkProductResult = $conn->query($checkProductSql);




if ($checkProductResult->num_rows === 0) {
    
    $newJsonFromAngular = json_decode(
        '{"id":1, "product_name": "$pdc_name", "quantity": $qty, "GST": $tax, "Price": $mrp, "discount": 0, "total": $tat}',
        true
    );
    $newJson = json_encode([$newJsonFromAngular], JSON_UNESCAPED_UNICODE);

    $insertSql = "INSERT INTO customer (id, product, total) VALUES ($id, '$newJson', $tat)";
    if ($conn->query($insertSql) === true) {
        $status = http_response_code(200);
        echo json_encode([
            "message" => "Added successfully",
            "data" => "Success",
            "status" => $status,
        ]);
    } else {
        echo "Error inserting record: " . $conn->error;
    }
} else {
    // Product is not null, update data
    $row = $checkProductResult->fetch_assoc();
    $existingJson = json_decode($row["product"], true);

        foreach ($existingJson as $pd_id) {
            $pdc_id = $pd_id["id"] + 1;
        }
        $newJsonFromAngular = json_decode(
            "{\"id\":$pdc_id, \"product_name\": \"$pdc_name\", \"quantity\": $qty, \"GST\": $tax, \"Price\": $mrp, \"discount\": 0, \"total\": $tat}",
            true
        );

        $combinedJson = array_merge($existingJson, [$newJsonFromAngular]);
        $newJson = json_encode($combinedJson, JSON_UNESCAPED_UNICODE);

        $updateSql = "UPDATE `customer` SET `product` = '$newJson' WHERE `id` = $id";
        if ($conn->query($updateSql) === true) {
            $status = http_response_code(200);
            echo json_encode([
                "message" => "Added successfully",
                "data" => "Success",
                "status" => $status,
            ]);
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $total = 0;
        foreach ($combinedJson as $element) {
            $total += $element["total"];
        }

        $updateTotalSql = "UPDATE customer SET total = $total WHERE id = $id";
        if ($conn->query($updateTotalSql) === true) {
        } else {
            echo "Error updating total: " . $conn->error;
        }
    }
}

$conn->close();
?>
<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-Requested-With,Authorization,Content-Type");

$host = "localhost";
$db = "sample";
$user = "harshil";
$pass = "Shreyu@18";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["cust_id"];
    $pdc_name = $data["product_name"];
    $qty = $data["cquantity"];
    $tax = $data["tax"];
    $price = $data["price"];
    $taxAmount = ($price * $tax) / 100;
    $mrp = $price + $taxAmount;
    $tat = $mrp * $qty;

    // Check if product is null
    $checkProductSql = "SELECT product FROM customer WHERE id = $id";
    $checkProductResult = $conn->query($checkProductSql);

    if ($checkProductResult->num_rows === 0) {
        // Product is null, insert data
        $newJsonFromAngular = json_decode(
            "{\"id\":1, \"product_name\": \"$pdc_name\", \"quantity\": $qty, \"GST\": $tax, \"Price\": $mrp, \"discount\": 0, \"total\": $tat}",
            true
        );
        $newJson = json_encode([$newJsonFromAngular], JSON_UNESCAPED_UNICODE);

        $insertSql = "INSERT INTO customer (id, product, total) VALUES ($id, '$newJson', $tat)";
        if ($conn->query($insertSql) === true) {
            $status = http_response_code(200);
            echo json_encode([
                "message" => "Added successfully",
                "data" => "Success",
                "status" => $status,
            ]);
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    } else {
        // Product is not null, update data
        $row = $checkProductResult->fetch_assoc();
        $existingJson = json_decode($row["product"], true);

        foreach ($existingJson as $pd_id) {
            $pdc_id = $pd_id["id"] + 1;
        }
        $newJsonFromAngular = json_decode(
            "{\"id\":$pdc_id, \"product_name\": \"$pdc_name\", \"quantity\": $qty, \"GST\": $tax, \"Price\": $mrp, \"discount\": 0, \"total\": $tat}",
            true
        );

        $combinedJson = array_merge($existingJson, [$newJsonFromAngular]);
        $newJson = json_encode($combinedJson, JSON_UNESCAPED_UNICODE);

        $updateSql = "UPDATE `customer` SET `product` = '$newJson' WHERE `id` = $id";
        if ($conn->query($updateSql) === true) {
            $status = http_response_code(200);
            echo json_encode([
                "message" => "Added successfully",
                "data" => "Success",
                "status" => $status,
            ]);
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $total = 0;
        foreach ($combinedJson as $element) {
            $total += $element["total"];
        }

        $updateTotalSql = "UPDATE customer SET total = $total WHERE id = $id";
        if ($conn->query($updateTotalSql) === true) {
        } else {
            echo "Error updating total: " . $conn->error;
        }
    }
}

$conn->close();
?>
