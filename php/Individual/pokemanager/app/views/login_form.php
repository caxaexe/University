<?php require_once 'components/header.php'; ?>

<main class="container">
    <h2>Вход в систему</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="/login.php" method="POST" class="auth-form">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Пароль:</label>
        <input type="password" name="password" id="password" required minlength="6">

        <button type="submit">Войти</button>
    </form>
    <p>Нет аккаунта? <a href="/register.php">Зарегистрируйтесь</a></p>
</main>

<?php require_once 'components/footer.php'; ?>
