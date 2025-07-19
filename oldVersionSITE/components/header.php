<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Виртуальный зоопарк</title>
</head>
<body>
    <header>
        <ul>
            <li><a href="index.php">Главная страница</a></li>
            <?php if (isset($_SESSION['user']['id'])){ ?>
                <li><a href="addAnimal.php">Добавить клетку</a></li>
                <li><a href="addBox.php">Добавить животного</a></li>
                <li><a href="vendor/logout.php">Выйти</a></li>
            <?php  } ?>
          
          
        </ul>
      

    </header>