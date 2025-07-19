<?php
require "vendor/core.php";
$animal_id = intval($_GET['id'] ?? 0);
// Обработка изменения информации о животном
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_animal'])) {
    $species = trim($_POST['species'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $animal = $link->query("SELECT * FROM animals WHERE id = $animal_id")->fetch_assoc();
    $image = $animal['image'] ?? '';
    // Обработка загрузки нового изображения
    if (isset($_FILES['image']) && $_FILES['image']['name'] && $_FILES['image']['size'] < 1000000) {
        $img_dir = 'img/';
        $img_name = basename($_FILES['image']['name']);
        $img_path = $img_dir . uniqid() . '_' . $img_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $img_path)) {
            if (!empty($image) && file_exists($image)) {
                unlink($image);
            }
            $image = $img_path;
        } else {
            $edit_error = 'Ошибка загрузки изображения.';
        }
    } elseif (isset($_FILES['image']) && $_FILES['image']['name']) {
        $edit_error = 'Изображение слишком большое (макс. 1 МБ).';
    }
    if (empty($edit_error) && $species && $name && $age >= 0) {
        $stmt = $link->prepare("UPDATE animals SET species=?, name=?, age=?, description=?, image=? WHERE id=?");
        $stmt->bind_param('ssissi', $species, $name, $age, $description, $image, $animal_id);
        $stmt->execute();
        $stmt->close();
        $edit_success = 'Информация о животном обновлена!';
        // Обновим данные
        $animal = $link->query("SELECT * FROM animals WHERE id = $animal_id")->fetch_assoc();
    } elseif (empty($edit_error)) {
        $edit_error = 'Заполните все поля корректно.';
    }
}
// Обработка удаления животного
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_animal_id'])) {
    $animal = $link->query("SELECT * FROM animals WHERE id = $animal_id")->fetch_assoc();
    if ($animal && !empty($animal['image']) && file_exists($animal['image'])) {
        unlink($animal['image']);
    }
    $cage_id = $animal['cage_id'] ?? 0;
    $link->query("DELETE FROM animals WHERE id = $animal_id");
    header('Location: cage.php?id=' . intval($cage_id));
    exit;
}
$animal = $link->query("SELECT * FROM animals WHERE id = $animal_id")->fetch_assoc();
require "components/header.php";
if (!$animal) {
    echo '<p>Животное не найдено.</p>';
    echo '</body></html>';
    exit;
}
?>
<div class="animal-card fade-in animal-card-max">
    <h2 class="animal-title">
        <?= htmlspecialchars($animal['name']) ?>
    </h2>
    <?php if (!empty($animal['image'])) { ?>
        <img src="<?= htmlspecialchars($animal['image']) ?>" alt="img" class="animal-photo animal-img-center">
    <?php } ?>
    <div class="animal-info-center">
        <b>Вид:</b> <?= htmlspecialchars($animal['species']) ?><br>
        <b>Возраст:</b> <?= $animal['age'] ?><br>
        <b>Описание:</b> <?= htmlspecialchars($animal['description']) ?><br>
    </div>
    <?php if (isset($_SESSION['user']['id'])){ ?>
        <?php if (!empty($edit_success)) { echo '<p class="success">' . $edit_success . '</p>'; } ?>
        <?php if (!empty($edit_error)) { echo '<p class="animal-error">' . $edit_error . '</p>'; } ?>
        <form method="post" enctype="multipart/form-data" class="animal-form-margin">
            <label>Вид: <input type="text" name="species" value="<?= htmlspecialchars($animal['species']) ?>" required></label><br>
            <label>Имя: <input type="text" name="name" value="<?= htmlspecialchars($animal['name']) ?>" required></label><br>
            <label>Возраст: <input type="number" name="age" value="<?= $animal['age'] ?>" min="0" max="100" required></label><br>
            <label>Описание: <input type="text" name="description" value="<?= htmlspecialchars($animal['description']) ?>"></label><br>
            <label>Новое изображение: <input type="file" name="image" accept="image/*"></label><br>
            <button type="submit" name="edit_animal">Сохранить изменения</button>
        </form>
        <form method="post" class="animal-form-margin">
            <input type="hidden" name="delete_animal_id" value="<?= $animal['id'] ?>">
            <button type="submit" onclick="return confirm('Удалить животное?')">Удалить животное</button>
        </form>
    <?php } ?>
    <div class="animal-link-bottom">
        <a href="cage.php?id=<?= $animal['cage_id'] ?>">Вернуться к клетке</a>
    </div>
</div>
</body>
</html> 