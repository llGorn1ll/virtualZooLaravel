<?php
require "vendor/core.php";

// Обработка формы создания клетки
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $capacity = intval($_POST['cageCapacity'] ?? 0);
    if ($name && $capacity > 0) {
        $stmt = $link->prepare("INSERT INTO cages (name, capacity) VALUES (?, ?)");
        $stmt->bind_param('si', $name, $capacity);
        if ($stmt->execute()) {
            $success = "Клетка успешно добавлена!";
        } else {
            $error = "Ошибка при добавлении клетки: " . $link->error;
        }
        $stmt->close();
    } else {
        $error = "Заполните все поля корректно.";
    }
}

require "components/header.php";
?>
<nav>
    <?php if (!empty($success)) { echo '<p style="color:green">' . $success . '</p>'; } ?>
    <?php if (!empty($error)) { echo '<p style="color:red">' . $error . '</p>'; } ?>
    <form action="#" method="post">
        <label for="name">Название клетки </label><input type="text" name="name" id="name" required><br>
        <label for="cageCapacity">Вместимость клетки </label><input type="number" name="cageCapacity" id="cageCapacity" min="1" max="100" required><br>
        <button>Создать</button>
    </form>
</nav>
</body>
</html>
