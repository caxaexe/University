<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавление заклинания</title>
    <style>
        .step {
         margin-bottom: 5px;
        }
        .error {
            color: red;
        }
    </style>
    <script>
        function addStep() {
            const stepContainer = document.getElementById("steps-container"); // ссылка на <div id="steps-container">
            const stepCount = stepContainer.children.length + 1; // определяем номер нового шага
            
            const stepDiv = document.createElement("div"); 
            stepDiv.classList.add("step"); // создаётся новый <div> с классом "step"
            stepDiv.innerHTML = `<input type="text" name="steps[]" placeholder="Шаг ${stepCount}" required> ` + // создаёт текстовое поле для ввода шага
                                `<button type="button" onclick="removeStep(this)">Удалить</button>`; // кнопка, которая вызывает removeStep(this)
            stepContainer.appendChild(stepDiv); // новый шаг добавляется в <div id="steps-container">
        }

        function removeStep(button) {
            button.parentElement.remove(); // удаляет <div class="step">
        }

        function getError(fieldName) {
            const errors = <?php echo json_encode($_SESSION['errors'] ?? []); ?>;
            return errors[fieldName] || '';
        }

        function getOldValue(fieldName, index = null) {
            const oldData = <?php echo json_encode($_SESSION['old_data'] ?? []); ?>;
            if(oldData[fieldName]) {
                if(Array.isArray(oldData[fieldName]) && index !== null) {
                    return oldData[fieldName][index];
                }
                return oldData[fieldName];
            }
            return '';
        }
    </script>
</head>
<body>
    <h1>Добавление нового заклинания</h1>
    <form action="../src/handlers/handle_form.php" method="post">
        <label>Название заклинания: <input type="text" name="spell_name" required></label><br>
        <?php if(isset($_SESSION['errors']['spell_name'])): ?>
            <div class="error"><?php echo $_SESSION['errors']['spell_name']; ?></div>
        <?php endif; ?>

        <label>Категория заклинания:
            <select name="category" required>
                <option value="непростительное" <?php if(getOldValue('category') === 'непростительное') echo 'selected'; ?>>Непростительное</option>
                <option value="бытовое" <?php if(getOldValue('category') === 'бытовое') echo 'selected'; ?>>Бытовое</option>
                <option value="невербальное" <?php if(getOldValue('category') === 'невербальное') echo 'selected'; ?>>Невербальное</option>
                <option value="продвинутое" <?php if(getOldValue('category') === 'продвинутое') echo 'selected'; ?>>Продвинутое</option>
            </select>
        </label><br>
        <?php if(isset($_SESSION['errors']['category'])): ?>
            <div class="error"><?php echo $_SESSION['errors']['category']; ?></div>
        <?php endif; ?>

        <label>Описание заклинания:<br>
            <textarea name="description" rows="4" required><?php echo getOldValue('description'); ?></textarea>
        </label><br>
        <?php if(isset($_SESSION['errors']['description'])): ?>
            <div class="error"><?php echo $_SESSION['errors']['description']; ?></div>
        <?php endif; ?>

        <label>Тэги:
            <select name="tags[]" multiple>
                <option value="оборонительные" <?php if(is_array(getOldValue('tags')) && in_array('оборонительные', getOldValue('tags'))) echo 'selected';  ?>>Оборонительные</option>
                <option value="атакующие" <?php if(is_array(getOldValue('tags')) && in_array('атакующие', getOldValue('tags'))) echo 'selected';  ?>>Атакующие</option>
                <option value="трансфигурационные" <?php if(is_array(getOldValue('tags')) && in_array('трансфигурационные', getOldValue('tags'))) echo 'selected';  ?>>Трансфигурационные</option>
                <option value="целебные" <?php if(is_array(getOldValue('tags')) && in_array('целебные', getOldValue('tags'))) echo 'selected';  ?>>Целебные</option>
                <option value="призывные" <?php if(is_array(getOldValue('tags')) && in_array('призывные', getOldValue('tags'))) echo 'selected';  ?>>Призывные</option>
                <option value="разрушительные" <?php if(is_array(getOldValue('tags')) && in_array('разрушительные', getOldValue('tags'))) echo 'selected';  ?>>Разрушительные</option>
                <option value="контроль сознания" <?php if(is_array(getOldValue('tags')) && in_array('контроль сознания', getOldValue('tags'))) echo 'selected';  ?>>Контроль сознания</option>
            </select>
        </label><br>

        <label>Шаги выполнения заклинания:</label>
        <div id="steps-container">
            <?php if(isset($_SESSION['old_data']['steps']) && is_array($_SESSION['old_data']['steps'])): ?>
                <?php foreach($_SESSION['old_data']['steps'] as $index => $step): ?>
                    <div class="step">
                        <input type="text" name="steps[]" placeholder="Шаг <?php echo $index +1; ?>" value="<?php echo sanitizeInput($step); ?>" required
                        <button type="button" onclick="removeStep(this)">Удалить</button>>
                    </div>
                    <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button type="button" onclick="addStep()">Добавить шаг</button><br>
        <?php if(isset($_SESSION['errors']['steps'])): ?>
            <div class="error"><?php echo $_SESSION['errors']['steps']; ?></div>
        <?php endif; ?>
        
        <button type="submit">Отправить</button>
    </form>

    <?php
    // удаление сессионных переменных с ошибками и старыми данными после отображения
    unset($_SESSION['errors']);
    unset($_SESSION['old_data']);
    ?>
</body>
</html>