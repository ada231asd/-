<?php
// edit.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wpcn_ab_request-2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $car_brand = $_POST['car_brand'];
    $car_number = $_POST['car_number'];

    $sql = "INSERT INTO wpcn_ab_request (user_id, car_brand, car_number, done) VALUES (?, ?, ?, 3)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $car_brand, $car_number);

    if ($stmt->execute()) {
        echo "Запись успешно добавлена!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }
    $stmt->close();
}

$result = $conn->query("SELECT * FROM wpcn_users");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование информации</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Добавить автомобиль</h1>
    <form method="POST">
        <label for="user_id">Выберите пользователя:</label>
        <select name="user_id" required>
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?= $row['ID'] ?>"><?= $row['user_login'] ?></option>
            <?php endwhile; ?>
        </select>
        <br>
        <label for="car_brand">Марка автомобиля:</label>
        <input type="text" name="car_brand" required>
        <br>
        <label for="car_number">Номер автомобиля:</label>
        <input type="text" name="car_number" required>
        <br>
        <button type="submit">Добавить</button>
    </form>
    <script>
        document.getElementById('carForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Остановить отправку формы

            const formData = new FormData(this);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'edit.php', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = xhr.responseText;
                    document.body.insertAdjacentHTML('afterbegin', response); // Добавить ответ на страницу
                    document.getElementById('carForm').reset(); // Сбросить форму
                } else {
                    alert('Ошибка при добавлении автомобиля.');
                }
            };
            xhr.send(formData); // Отправить данные формы
        });
    </script>
</body>

</html>

<?php
$conn->close();
?>
