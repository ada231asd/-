<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wpcn_ab_request-2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
    exit();
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 'fetch_cars' && isset($_POST['user_id'])) {
        $user_id = (int)$_POST['user_id'];
        $sql = "SELECT car_brand, car_number, ID FROM wpcn_ab_request WHERE user_id = $user_id";
        $result = $conn->query($sql);

        if ($result) {
            $cars = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode(["status" => "success", "data" => $cars]);
        } else {
            echo json_encode(["status" => "error", "message" => "Ошибка выполнения запроса: " . $conn->error]);
        }

    } elseif ($action == 'add_car' && isset($_POST['user_id'], $_POST['car_brand'], $_POST['car_number'])) {
        $user_id = (int)$_POST['user_id'];
        $car_brand = $_POST['car_brand'];
        $car_number = $_POST['car_number'];

        $sql = "INSERT INTO wpcn_ab_request (user_id, car_brand, car_number, done) VALUES ($user_id, '$car_brand', '$car_number', 3)";
        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Автомобиль добавлен"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Ошибка добавления автомобиля: " . $conn->error]);
        }

    } elseif ($action == 'delete_car' && isset($_POST['car_id'])) {
        $car_id = (int)$_POST['car_id'];

        $sql = "DELETE FROM wpcn_ab_request WHERE ID = $car_id";
        if ($conn->query($sql)) {
            echo json_encode(["status" => "success", "message" => "Автомобиль удален"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Ошибка удаления автомобиля: " . $conn->error]);
        }
    }
}

$conn->close();
?>
