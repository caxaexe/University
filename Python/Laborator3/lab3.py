# задание 1а - анализ
i = sum = 0
while i <= 4:
 sum += i
 i = i+1
print(sum)
# в переменной sum хранится сумма чисел от 0 до 4, соответственно она равнаяется 10

# задание 1b - анализ
for char in 'PYTHON STRING':
 if char == ' ':
    break
 print(char, end='')
 if char == 'O':
    continue
 print('*', end='')
# символ равен пробелу - цикл прерывается, равен О - продолжается, игнорируя следующую часть кода
 

print()
print("--------------------------------------------------")
print()


# задание 2a - написать код с использованием операторов if, elif, else
answer = input("Выберите одну из философских школ : киренская, стоицизм или кинизм - ") 
if answer == "Киренская" or  answer == "киренская":
  print("Киренская школа отрицала науки о природе как не дающие надежных знаний и бесполезные для счастливой жизни. Основной раздел философии - этика, основной раздел этики - учение об удовольствии как основе счастливой жизни.")
elif answer == "Стоицизм" or answer == "стоицизм":
  print("Стоицизм - это образ мысли, опирающийся на здравый смысл. Принцип стоицизма : есть вещи, которые мы можем контролировать и есть вещи, которые контролировать мы не можем. Что мы можем контролировать - своим мысли и действия.")
elif answer == "Кинизм" or answer == "кинизм":
  print("Киники стремились жить в соответствии с природой и отвергали материальные блага, ценности и общественные нормы. Это направление предлагало особый взгляд на жизнь, основанный на простоте, аскетизме и презрении к условностям общества.")
else:
  print("Повторите еще раз.")


print()
print("--------------------------------------------------")
print()


# задание 2b - создать словарь и список, счетчик, который определит количество одного элемента в двух коллекциях, использовать for или while и условный оператор
myList = [5, 31, 5, 27, 19, 8, 27, 5]
myDict = {'a':31, 'b':5, 'c':27, 'd':5, 'e':8, 'f':5}

count = 0
number = int(input("Введите число, количество которого вы хотите узнать : ")) 

for i in myList + list(myDict.values()):
  if i == number:
    count += 1

print("Элемент", number, "встречается", count, "раз.")

# myList = [5, 31, 5, 27, 19, 8, 27, 5]
# myDict = {'a':31, 'b':5, 'c':27, 'd':5, 'e':8, 'f':5}
# listDict = list(myDict.values())
# print(myList, listDict, sep='\n')

# number = int(input("Введите число, количество которого вы хотите узнать : "))

# print("Число", number, "встречается", myList.count(number) + listDict.count(number), "раз.")



print()
print("--------------------------------------------------")
print()


# задание 2c - использовать lambda функцию :c
numbers = [1, 56, 87, 16, 55, 36, 89, 2]
oddNumbers = list(filter(lambda x: (x % 2 != 0), numbers))
evenNumbers = list(filter(lambda x: (x % 2 == 0), numbers))
print("Нечётные числа в списке :", oddNumbers)
print("Чётные числа в списке:", evenNumbers)


print()
print("--------------------------------------------------")
print()


# задание 3 - использовать функции : с параметрами, без параметров, и которое возвращает какое-то значение. Функции должны быть в отдельном файле, импортировать его в главный.

import lab3functions as f
f.menu()

