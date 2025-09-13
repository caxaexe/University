def newton_interpolation(x_values, y_values, x):
    n = len(x_values)
    # Построение таблицы разделённых разностей
    divided_diff = [y for y in y_values]
    for i in range(1, n):
        for j in range(n-1, i-1, -1):
            divided_diff[j] = (divided_diff[j] - divided_diff[j-1]) / (x_values[j] - x_values[j-i])

    # Вычисление значения полинома
    result = divided_diff[0]
    mult_term = 1.0
    for i in range(1, n):
        mult_term *= (x - x_values[i-1])
        result += divided_diff[i] * mult_term
    return result

# Данные
x_points = [0.135, 0.876, 1.336, 2.301, 2.851]
y_points = [2.382, -0.212, -1.305, -3.184, -4.365]

# Пример использования
x_to_find = 1.5  # Подставь любое значение
y_result = newton_interpolation(x_points, y_points, x_to_find)
print(f"Newton interpolation at x={x_to_find}: y={y_result}")
