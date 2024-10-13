$(document).ready(function () {
    $('#user_id').change(function () {
        const user_id = $(this).val();
        if (user_id) {
            $.ajax({
                url: 'process.php',
                method: 'POST',
                data: { action: 'fetch_cars', user_id: user_id },
                success: function (response) {
                    const tbody = $('#carTable tbody');
                    tbody.empty(); // Очищаем таблицу

                    if (response.status === 'success') {
                        response.data.forEach(function (car) {
                            tbody.append(`
                                <tr>
                                    <td>${car.car_brand}</td>
                                    <td>${car.car_number}</td>
                                    <td><button class="delete-btn" data-id="${car.ID}">Удалить</button></td>
                                </tr>
                            `);
                        });
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });

    // Добавление автомобиля
    $('#carForm').submit(function (e) {
        e.preventDefault();
        const user_id = $('#user_id').val();
        const car_brand = $('#car_brand').val();
        const car_number = $('#car_number').val();

        if (user_id) {
            $.ajax({
                url: 'process.php',
                method: 'POST',
                data: {
                    action: 'add_car',
                    user_id: user_id,
                    car_brand: car_brand,
                    car_number: car_number
                },
                success: function (response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        $('#user_id').trigger('change'); // Обновить список машин
                    } else {
                        alert(response.message);
                    }
                }
            });
        } else {
            alert('Выберите пользователя перед добавлением автомобиля');
        }
    });

    // Удаление автомобиля
    $(document).on('click', '.delete-btn', function () {
        const car_id = $(this).data('id');

        if (confirm('Вы уверены, что хотите удалить этот автомобиль?')) {
            $.ajax({
                url: 'process.php',
                method: 'POST',
                data: { action: 'delete_car', car_id: car_id },
                success: function (response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        $('#user_id').trigger('change'); // Обновить список машин
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });
});
