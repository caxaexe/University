import java.util.Scanner;

public class Matrix {
    private final int[][] array;

    public Matrix(int n, int m) {
        array = new int[n][m];
    }

    public void inputArray() {
        Scanner scanner = new Scanner(System.in);
        System.out.print("Введите элементы матрицы " + array.length + "x" + array[0].length + ": ");
        for (int i = 0; i < array.length; i++) {
            for (int k = 0; k < array[i].length; k++) {
                array[i][k] = scanner.nextInt();
            }
        }
    }

    public void printArray() {
        System.out.println("Матрица:");
        for (int[] row : array) {
            for (int element : row) {
                System.out.print(element + " ");
            }
            System.out.println();
        }
    }

    public int minElement() {
        int min = array[0][0];
        for (int[] row : array) {
            for (int element : row) {
                if (element < min) {
                    min = element;
                }
            }
        }
        return min;
    }

    public int maxElement() {
        int max = array[0][0];
        for (int[] row : array) {
            for (int element : row) {
                if (element > max) {
                    max = element;
                }
            }
        }
        return max;
    }
}
