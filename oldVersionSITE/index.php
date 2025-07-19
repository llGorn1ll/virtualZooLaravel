<?php
require "vendor/core.php";
$cages = $link->query("SELECT * FROM cages");
// Получаем общее количество животных
$animal_count = $link->query("SELECT COUNT(*) as cnt FROM animals")->fetch_assoc()['cnt'];
require "components/header.php";
?>
<div class="uppElements">
<h1>Виртуальный зоопарк</h1>
<p class="animal_count">В зоопарке на данный момент проживают <b><?= $animal_count ?></b> животных.</p>
</div>
<div class="cages">
<?php
foreach($cages as $cage){
?>
    <a href="cage.php?id=<?= $cage['id'] ?>">
        <div class="cageElement">
            <b>Клетка:</b> <?= htmlspecialchars($cage['name']) ?><br>
            <b>Вместимость:</b> <?= $cage['capacity'] ?> животных
        </div>
    </a>
<?php
}
?>
</div>
</body>
</html>