<?php
require "vendor/core.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $stmt = $link->prepare("SELECT * FROM users WHERE login = ?");
    $stmt->bind_param('s', $login);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user) {
        $_SESSION['user']['id'] = $user['id'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Пользователь не найден!";
    }
}
require "components/header.php";
?>
<h1>Вход</h1>
<?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
<form action="#" method="post">
    <label for="login">Логин</label>
    <input type="text" name="login" id="login" required>
    <button>Войти</button>
</form>
