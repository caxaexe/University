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
    </script>
</head>
<body>
    <form action="#" method="post">
        <label>Название заклинания: <input type="text" name="spell_name" required></label><br>
        <label>Категория заклинания:
            <select name="category" required>
                <option value="непростительное"></option>
                <option value="бытовое"></option>
                <option value="невербальное"></option>
                <option value="продвинутое"></option>
            </select>
        </label><br>
        <label>Описание заклинания:<br>
            <textarea name="description" rows="4" required></textarea>
        </label><br>
        <label>Тэги:
            <select name="tags[]" multiple>
                <option value="оборонительные">Оборонительные</option>
                <option value="атакующие">Атакующие</option>
                <option value="трансфигурационные">Трансфигурационные</option>
                <option value="целебные">Целебные</option>
                <option value="призывные">Призывные</option>
                <option value="разрушительные">Разрушительные</option>
                <option value="контроль сознания">Контроль сознания</option>
            </select>
        </label>
        <label>Шаги произнесения заклинания:</label>
        <div id="steps-container"></div>
        <button type="button" onclick="addStep()">Добавить шаг</button><br>
        <button type="submit">Отправить</button>
    </form>
</body>
</html>