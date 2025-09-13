<?php require_once 'components/header.php'; ?>

<main class="container">
    <h2>Регистрация</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="/register.php" method="POST" class="auth-form">
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username" id="username" required minlength="3">

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required minlength="6">

        <label for="confirm_password">Повторите пароль:</label>
        <input type="password" name="confirm_password" id="confirm_password" required minlength="6">

        <button type="submit">Зарегистрироваться</button>
    </form>
    <p>Уже есть аккаунт? <a href="/login.php">Войдите</a></p>
</main>

<?php require_once 'components/footer.php'; ?>
