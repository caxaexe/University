<?php require_once 'components/header.php'; ?>

<main class="container">
    <h1>Добро пожаловать в PokeManager!</h1>
    <p>Изучайте доступных покемонов:</p>

    <!-- Форма поиска и фильтрации -->
    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Поиск по имени..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">

        <select name="type">
            <option value="">Все типы</option>
            <?php
            $types = ['Огонь', 'Вода', 'Трава', 'Электричество', 'Психический', 'Боевой', 'Лед', 'Дракон']; // можешь расширить
            foreach ($types as $typeOption) {
                $selected = (isset($_GET['type']) && $_GET['type'] === $typeOption) ? 'selected' : '';
                echo "<option value=\"$typeOption\" $selected>$typeOption</option>";
            }
            ?>
        </select>

        <select name="generation">
            <option value="">Все поколения</option>
            <?php for ($i = 1; $i <= 9; $i++): // заменишь диапазон под нужное кол-во поколений ?>
                <option value="<?= $i ?>" <?= (isset($_GET['generation']) && $_GET['generation'] == $i) ? 'selected' : '' ?>>
                    Поколение <?= $i ?>
                </option>
            <?php endfor; ?>
        </select>

        <button type="submit">Фильтровать</button>
    </form>

    <div class="pokemon-list">
        <?php
        require_once __DIR__ . '/../core/Database.php';
        $db = Database::connect();

        $search = $_GET['search'] ?? '';
        $type = $_GET['type'] ?? '';
        $generation = $_GET['generation'] ?? '';

        $conditions = [];
        $params = [];

        if (!empty($search)) {
            $conditions[] = "name LIKE :search";
            $params['search'] = '%' . $search . '%';
        }
        if (!empty($type)) {
            $conditions[] = "type = :type";
            $params['type'] = $type;
        }
        if (!empty($generation)) {
            $conditions[] = "generation = :generation";
            $params['generation'] = $generation;
        }

        $sql = "SELECT * FROM pokemons";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $sql .= " ORDER BY generation, name";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $pokemons = $stmt->fetchAll();

        if ($pokemons):
            foreach ($pokemons as $pokemon): ?>
                <div class="pokemon-card">
                    <h3><?= htmlspecialchars($pokemon['name']) ?></h3>
                    <p>Тип: <?= htmlspecialchars($pokemon['type']) ?></p>
                    <p>Уровень: <?= (int)$pokemon['level'] ?></p>
                    <p>Поколение: <?= (int)$pokemon['generation'] ?></p>
                </div>
            <?php endforeach;
        else: ?>
            <p>Покемоны не найдены по выбранным фильтрам.</p>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'components/footer.php'; ?>
