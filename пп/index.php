<?php
// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wpcn_ab_request-2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$users = $conn->query("SELECT ID, user_login FROM wpcn_users");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Управление автомобилями</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Список пользователей</h1>
        <form id="userForm">
            <label for="user_id">Выберите пользователя:</label>
            <select name="user_id" id="user_id">
                <option value="">-- Выберите --</option>
                <?php while ($row = $users->fetch_assoc()): ?>
                    <option value="<?= $row['ID'] ?>"><?= $row['user_login'] ?></option>
                <?php endwhile; ?>
            </select>
        </form>

        <h2>Автомобили пользователя</h2>
        <table id="carTable">
            <thead>
                <tr>
                    <th>Марка автомобиля</th>
                    <th>Номер автомобиля</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <h2>Добавить новый автомобиль</h2>
        <form id="carForm">
            <label for="car_brand">Марка автомобиля:</label>
            <input type="text" id="car_brand" name="car_brand" required>

            <label for="car_number">Номер автомобиля:</label>
            <input type="text" id="car_number" name="car_number" required>

            <button type="submit">Добавить автомобиль</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>

<?php
$conn->close();
?>
