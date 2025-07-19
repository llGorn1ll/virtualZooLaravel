<?php
require "vendor/core.php";
// Получаем список клеток с количеством животных в каждой
$cages = $link->query("SELECT cages.*, COUNT(animals.id) as animal_count FROM cages LEFT JOIN animals ON cages.id = animals.cage_id GROUP BY cages.id");

if ($_POST) {
    $species = trim($_POST['species'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $cage_id = intval($_POST['cage_id'] ?? 0);
    $image = '';
    // Обработка загрузки изображения
    if (isset($_FILES['image']) && $_FILES['image']['name'] && $_FILES['image']['size'] < 1000000) {
        $img_dir = 'img/';
        $img_name = basename($_FILES['image']['name']);
        $img_path = $img_dir . uniqid() . '_' . $img_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $img_path)) {
            $image = $img_path;
        } else {
            $error = 'Ошибка загрузки изображения.';
        }
    } elseif (isset($_FILES['image']) && $_FILES['image']['name']) {
        $error = 'Изображение слишком большое (макс. 1 МБ).';
    }
    // Проверяем, есть ли место в клетке
    $cage = $link->query("SELECT cages.*, COUNT(animals.id) as animal_count FROM cages LEFT JOIN animals ON cages.id = animals.cage_id WHERE cages.id = $cage_id GROUP BY cages.id")->fetch_assoc();
    if (empty($error) && $cage && $cage['animal_count'] < $cage['capacity']) {
        $stmt = $link->prepare("INSERT INTO animals (species, name, age, description, cage_id, image) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssisis', $species, $name, $age, $description, $cage_id, $image);
        if ($stmt->execute()) {
            $success = "Животное успешно добавлено!";
        } else {
            $error = "Ошибка при добавлении животного: " . $link->error;
        }
        $stmt->close();
    } elseif (empty($error)) {
        $error = "В выбранной клетке нет свободных мест.";
    }
}
require "components/header.php";
?>
<nav>
    <?php if (!empty($success)) { echo '<p style="color:green">' . $success . '</p>'; } ?>
    <?php if (!empty($error)) { echo '<p style="color:red">' . $error . '</p>'; } ?>
    <form action="#" method="post" enctype="multipart/form-data">
        <label for="species">Вид животного</label><input type="text" name="species" id="species" required><br>
        <label for="name">Имя животного</label><input type="text" name="name" id="name" required><br>
        <label for="age">Возраст</label><input type="number" name="age" id="age" min="0" max="100" required><br>
        <label for="description">Описание</label><input type="text" name="description" id="description"><br>
        <label for="image">Изображение</label><input type="file" name="image" id="image" accept="image/*" required><br>
        <label for="cage_id">Клетка</label>
        <select name="cage_id" id="cage_id" required>
            <?php foreach($cages as $cage) {
                $free = $cage['capacity'] - $cage['animal_count'];
                if ($free > 0) {
            ?>
                <option value="<?= $cage['id'] ?>">
                    <?= htmlspecialchars($cage['name']) ?> (Свободно мест: <?= $free ?>)
                </option>
            <?php }} ?>
        </select><br>
        <button>Добавить животное</button>
    </form>
</nav>
</body>
</html>
