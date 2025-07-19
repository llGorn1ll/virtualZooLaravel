<?php
require "vendor/core.php";
$cage_id = intval($_GET['id'] ?? 0);
// Обработка удаления животного
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_animal_id'])) {
    $animal_id = intval($_POST['delete_animal_id']);
    // Получаем путь к изображению
    $img = $link->query("SELECT image FROM animals WHERE id = $animal_id AND cage_id = $cage_id")->fetch_assoc();
    if ($img && !empty($img['image']) && file_exists($img['image'])) {
        unlink($img['image']);
    }
    $link->query("DELETE FROM animals WHERE id = $animal_id AND cage_id = $cage_id");
}
// Обработка удаления клетки
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_cage'])) {
    // Проверяем, есть ли животные в клетке
    $count = $link->query("SELECT COUNT(*) as cnt FROM animals WHERE cage_id = $cage_id")->fetch_assoc()['cnt'];
    if ($count == 0) {
        $link->query("DELETE FROM cages WHERE id = $cage_id");
        header('Location: index.php');
        exit;
    } else {
        $cage_delete_error = 'Клетка не пуста! Сначала удалите всех животных.';
    }
}
// Обработка изменения параметров клетки
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_cage'])) {
    $new_name = trim($_POST['new_name'] ?? '');
    $new_capacity = intval($_POST['new_capacity'] ?? 0);
    $animal_count = $link->query("SELECT COUNT(*) as cnt FROM animals WHERE cage_id = $cage_id")->fetch_assoc()['cnt'];
    if ($new_name && $new_capacity >= $animal_count && $new_capacity > 0) {
        $stmt = $link->prepare("UPDATE cages SET name = ?, capacity = ? WHERE id = ?");
        $stmt->bind_param('sii', $new_name, $new_capacity, $cage_id);
        $stmt->execute();
        $stmt->close();
        // Обновим данные клетки после изменения
        $cage = $link->query("SELECT * FROM cages WHERE id = $cage_id")->fetch_assoc();
        $cage_edit_success = 'Параметры клетки успешно изменены!';
    } else {
        $cage_edit_error = 'Вместимость не может быть меньше количества животных (' . $animal_count . ') и должна быть больше 0.';
    }
}
$cage = $link->query("SELECT * FROM cages WHERE id = $cage_id")->fetch_assoc();
if (!$cage) {
    echo "Клетка не найдена.";
    exit;
}
$animals = $link->query("SELECT * FROM animals WHERE cage_id = $cage_id");
require "components/header.php";
?>
<a href="index.php" style="display:inline-block; margin-bottom:15px;">&larr; Назад к списку клеток</a>
<h2>Клетка: <?= htmlspecialchars($cage['name']) ?> <?php if (isset($_SESSION['user']['id'])){ ?>(Вместимость: <?= $cage['capacity'] ?>)<?php } ?></h2>
<?php if (!empty($cage_delete_error)) { echo '<p style="color:red">' . $cage_delete_error . '</p>'; } ?>
<?php if (!empty($cage_edit_success)) { echo '<p style="color:green">' . $cage_edit_success . '</p>'; } ?>
<?php if (!empty($cage_edit_error)) { echo '<p style="color:red">' . $cage_edit_error . '</p>'; } ?>
<?php if (isset($_SESSION['user']['id'])){ ?>
<form method="post" style="margin-bottom:20px;">
    <label>Название: <input type="text" name="new_name" value="<?= htmlspecialchars($cage['name']) ?>" required></label><br>
    <label>Вместимость: <input type="number" name="new_capacity" value="<?= $cage['capacity'] ?>" min="1" required></label><br>
    <button type="submit" name="edit_cage">Изменить параметры</button>
</form>


<form method="post" style="margin-bottom:20px;">
    <button type="submit" name="delete_cage" onclick="return confirm('Удалить клетку?')">Удалить клетку</button>
</form><?php } ?>
<?php if ($animals->num_rows == 0) { ?>
    <p class="noAnimals">В этой клетке пока нет животных.</p>
<?php } else { ?>
    <ul>
    <?php foreach($animals as $animal) { ?>
        <a href="animal.php?id=<?= $animal['id'] ?>" style="text-decoration:none;color:inherit;">
            <li style="cursor:pointer; width:280px; display:inline-block; vertical-align:top; margin:10px;">
                <?php if (!empty($animal['image'])) { ?>
                    <img src="<?= htmlspecialchars($animal['image']) ?>" alt="img" style="width:280px; height:280px; object-fit:cover; display:block; margin-bottom:5px;">
                <?php } ?>
                <div style="width:180px; word-break:break-word; white-space:normal;">
                    <b><?= htmlspecialchars($animal['species']) ?></b> — <?= htmlspecialchars($animal['name']) ?>, возраст: <?= $animal['age'] ?><br>
                    <i><?= htmlspecialchars($animal['description']) ?></i><br>
                </div>
            </li>
        </a>
    <?php } ?>
    </ul>
<?php } ?>
</body>
</html> 