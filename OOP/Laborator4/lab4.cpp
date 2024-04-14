/* Разработать шаблонный класс Товар. Предусмотреть варианты хранения информации:
    - наименование товара, инвентарный номер, цена, фирма–производитель;
    - наименование товара, имя модели, цена, номер телефона фирмы;
В классе должен быть конструктор. Предусмотреть член–функцию для печати элементов класса. Создать список, предусмотреть операцию вставки.*/

#include <iostream>
#include <string>
using namespace std;

template <typename T> // параметр T представляет собой обобщенный тип данных, может быть заменен на любой тип данных
class Product {
public:
    Product(const T& name, const T& info, const T& price, const T& firm)
        : name(name), info(info), price(price), firm(firm) {}

    void print1() const {
        cout << "\nНаименование товара: " << name << endl;
        cout << "Инвентарный номер: " << info << endl;
        cout << "Цена: " << price << " лей" << endl;
        cout << "Фирма-производитель: " << firm << endl;
    }
    
    void print2() const {
        cout << "\nНаименование товара: " << name << endl;
        cout << "Имя модели: " << info << endl;
        cout << "Цена: " << price << " лей" << endl;
        cout << "Номер телефона фирмы: " << firm << endl;
    }

private:
    T name;
    T info;
    T price;
    T firm;
};

int main() {
    Product<string> product1("Товар A", "12345", "100", "Фирма X");
    product1.print1();

    Product<string> product2("Товар B", "Модель Y", "200", "1234567890");
    product2.print2();

    return 0;
}
