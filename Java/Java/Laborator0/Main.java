/* Создать класс Matrix, содержащий двумерный массив n x m целого типа, организовать ввод-вывод массива,
поиск минимального и максимального элементов. Для ввода использовать класс Scanner,
а для вывода метод System.out.println(). */

import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        System.out.print("Введите количество строк: ");
        int n = scanner.nextInt();
        System.out.print("Введите количество столбцов: ");
        int m = scanner.nextInt();

        Matrix matrix = new Matrix(n, m);
        matrix.inputArray();
        matrix.printArray();

        System.out.println("Минимальный элемент в матрице: " + matrix.minElement());
        System.out.print("Максимальный элемент в матрице: " + matrix.maxElement());
    }
}