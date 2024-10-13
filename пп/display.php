<?php
// display.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wpcn_ab_request-2";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

$users = $conn->query("SELECT * FROM wpcn_users");
$cars = $conn->query("SELECT * FROM wpcn_ab_request");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Обработка изменения автомобиля
    if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        $car_id = $_POST['car_id'];
        $car_brand = $_POST['car_brand'];
        $car_number = $_POST['car_number'];

        $stmt = $conn->prepare("UPDATE wpcn_ab_request SET car_brand = ?, car_number = ? WHERE ID = ?");
        $stmt->bind_param("ssi", $car_brand, $car_number, $car_id);

        if ($stmt->execute()) {
            echo "Автомобиль успешно изменен!";
        } else {
            echo "Ошибка при изменении автомобиля: " . $stmt->error;
        }
        $stmt->close();
        exit;
    }

    // Обработка удаления автомобиля
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $car_id = $_POST['car_id'];

        $stmt = $conn->prepare("DELETE FROM wpcn_ab_request WHERE ID = ?");
        $stmt->bind_param("i", $car_id);

        if ($stmt->execute()) {
            echo "Автомобиль успешно удален!";
        } else {
            echo "Ошибка при удалении автомобиля: " . $stmt->error;
        }
        $stmt->close();
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Отображение информации</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="css/styles2.css">
</head>
<body>

    <h1>Список пользователей</h1>
    <form method="GET">
        <label for="user_id">Выберите пользователя:</label>
        <select name="user_id" onchange="this.form.submit()">
            <option value="">-- Выберите --</option>
            <?php while ($row = $users->fetch_assoc()): ?>
                <option value="<?= $row['ID'] ?>" <?= ($row['ID'] == $user_id) ? 'selected' : '' ?>>
                    <?= $row['user_login'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php if ($user_id > 0): ?>
        <h2>Автомобили пользователя</h2>
        <table border="1">
            <tr>
                <th>Марка автомобиля</th>
                <th>Номер автомобиля</th>
                <th>Действия</th>
            </tr>
            <?php
            $car_query = $conn->prepare("SELECT ID, car_brand, car_number FROM wpcn_ab_request WHERE user_id = ?");
            $car_query->bind_param("i", $user_id);
            $car_query->execute();
            $result = $car_query->get_result();
            while ($car = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $car['car_brand'] ?></td>
                    <td><?= $car['car_number'] ?></td>
                    <td>
                        <button class="edit" data-id="<?= $car['ID'] ?>" data-brand="<?= $car['car_brand'] ?>" data-number="<?= $car['car_number'] ?>">Изменить</button>
                        <button class="delete" data-id="<?= $car['ID'] ?>">Удалить</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    <!-- Модальное окно для изменения данных автомобиля -->
    <div class="modal" id="editModal">
        <h2>Изменить автомобиль</h2>
        <form id="editForm">
            <input type="hidden" name="car_id" id="editCarId">
            <input type="text" name="car_brand" id="editCarBrand" placeholder="Марка автомобиля">
            <input type="text" name="car_number" id="editCarNumber" placeholder="Номер автомобиля">
            <button type="submit">Сохранить изменения</button>
        </form>
    </div>

    <script>
        // Удаление автомобиля
        document.querySelectorAll('.delete').forEach(button => {
            button.addEventListener('click', function() {
                const carId = this.dataset.id;

                if (confirm('Вы уверены, что хотите удалить этот автомобиль?')) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', 'display.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            alert('Автомобиль удален');
                            location.reload();
                        } else {
                            alert('Ошибка при удалении автомобиля');
                        }
                    };
                    xhr.send('action=delete&car_id=' + carId);
                }
            });
        });

        // Открытие модального окна для редактирования
        document.querySelectorAll('.edit').forEach(button => {
            button.addEventListener('click', function() {
                const carId = this.dataset.id;
                const carBrand = this.dataset.brand;
                const carNumber = this.dataset.number;

                document.getElementById('editCarId').value = carId;
                document.getElementById('editCarBrand').value = carBrand;
                document.getElementById('editCarNumber').value = carNumber;

                document.getElementById('editModal').classList.add('active');
            });
        });

        // Обработка изменения автомобиля
        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const carId = document.getElementById('editCarId').value;
            const carBrand = document.getElementById('editCarBrand').value;
            const carNumber = document.getElementById('editCarNumber').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'display.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert('Изменения сохранены');
                    location.reload();
                } else {
                    alert('Ошибка при изменении автомобиля');
                }
            };
            xhr.send('action=edit&car_id=' + carId + '&car_brand=' + encodeURIComponent(carBrand) + '&car_number=' + encodeURIComponent(carNumber));
        });

        // Закрытие модального окна при клике вне его
        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('editModal')) {
                document.getElementById('editModal').classList.remove('active');
            }
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
