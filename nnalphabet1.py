# -*- coding: utf-8 -*-
# Создание двуслойной нейронной сети
# для обучения с помощью набора прописных букв.

# Commented out IPython magic to ensure Python compatibility.
import numpy
# библиотека scipy.special содержит сигмоиду - expit ()
import scipy.special
# библиотека для графического отображения массивов import
import matplotlib.pyplot
# размещение графики в данном блокноте, а не в отдельном окне
# %matplotlib inline
from matplotlib import image
from matplotlib import pyplot as plt
from PIL import Image
import csv
import os
import sys
from fpdf import FPDF
import img2pdf
from PyPDF2 import PdfMerger

im_marker = sys.argv[1]
# im_marker = input()
# Список всех файлов в каталоге с помощью os.listdir
filepath = "C:/xampp/htdocs/www/neuropropisi/upload_files/"
files = os.listdir(filepath)
if files:
    files = [os.path.join(filepath, file) for file in files]
    files = [file for file in files if os.path.isfile(file)]
    imagefile = max(files, key=os.path.getctime)

im = Image.open(imagefile)
pixels = list(im.getdata())
im_file = [im_marker]
for pixel in pixels:
    im_file.append(str(pixel[1]))
with open("C:/xampp/htdocs/www/neuropropisi/received_files/propisi.csv", "w", encoding="utf-8") as w_file:
    file_writer = csv.writer(w_file, delimiter=',')
    file_writer.writerow(im_file)


# определение класса нейронной сети
class neuralNetwork:

    # инициализировать нейронную сеть
    def __init__(self, inputnodes, hiddennodes, outputnodes, learningrate):
        # задать количество входных узлов и узлов в скрытом и выходном слоях
        self.inodes = inputnodes
        self.hnodes = hiddennodes
        self.onodes = outputnodes

        # Матрицы весовых коэффициентов связей
        # wih (между входным и скрытым слоями)и
        # who (между скрытым и выходным слоями).
        # Весовые коэффициенты связей между узлом i и узлом j
        # следующего слоя обозначены как  w_i_j
        # w11 w21
        # w12 w22 и т.д.
        self.wih = numpy.random.normal(0.0, pow(self.inodes, -0.5), (self.hnodes, self.inodes))
        self.who = numpy.random.normal(0.0, pow(self.hnodes, -0.5), (self.onodes, self.hnodes))

        # коэффициент скорости обучения
        self.lr = learningrate

        # использование сигмоиды в качестве функции активации
        self.activation_function = lambda x: scipy.special.expit(x)

        pass

    # тренировка нейронной сети
    def train(self, inputs_list, targets_list):
        # преобразование списка входных значений
        # в двухмерный массив
        inputs = numpy.array(inputs_list, ndmin=2).T
        targets = numpy.array(targets_list, ndmin=2).T

        # рассчитать входящие сигналы для скрытого слоя
        hidden_inputs = numpy.dot(self.wih, inputs)
        # рассчитать исходящие сигналы для скрытого слоя
        hidden_outputs = self.activation_function(hidden_inputs)

        # рассчитать входящие сигналы для выходного слоя
        final_inputs = numpy.dot(self.who, hidden_outputs)
        # рассчитать исходящие сигналы для выходного слоя
        final_outputs = self.activation_function(final_inputs)

        # ошибки выходного слоя (целевое значение - фактическое значение)
        output_errors = targets - final_outputs
        # ошибки скрытого слоя - это ошибки output_errors
        # распределенные пропорционально весовым коэффициентам связей
        # и рекомбинированные на скрытых узлах
        hidden_errors = numpy.dot(self.who.T, output_errors)

        # обновить весовые коэффициенты для связей между скрытым и выходным слоями
        self.who += self.lr * numpy.dot((output_errors * final_outputs * (1.0 - final_outputs)),
                                        numpy.transpose(hidden_outputs))

        # обновить весовые коэффициенты для связей между входным и скрытым слоями
        self.wih += self.lr * numpy.dot((hidden_errors * hidden_outputs * (1.0 - hidden_outputs)),
                                        numpy.transpose(inputs))

        return output_errors  # возврат ошибок выходного слоя
        # pass

    # опрос нейронной сети
    def query(self, inputs_list):
        # преобразовать список входных значений в двухмерный массив
        inputs = numpy.array(inputs_list, ndmin=2).T

        # рассчитать входящие сигналы для скрытого слоя
        hidden_inputs = numpy.dot(self.wih, inputs)
        # рассчитать исходящие сигналы для скрытого слоя
        hidden_outputs = self.activation_function(hidden_inputs)

        # рассчитать входящие сигналы для выходного слоя
        final_inputs = numpy.dot(self.who, hidden_outputs)
        # рассчитать исходящие сигналы для выходного слоя
        final_outputs = self.activation_function(final_inputs)

        return final_outputs


# количество входных, скрытых и выходных узлов
input_nodes = 2500
hidden_nodes = 200
output_nodes = 7

# коэффициент скорости обучения
learning_rate = 0.1

# создать экземпляр нейронной сети
n = neuralNetwork(input_nodes, hidden_nodes, output_nodes, learning_rate)

# загрузить в список обучающий набор данных CSV-файла набора MNIST0
training_data_file = open('C:/xampp/htdocs/www/neuropropisi/model/mprop_abvgde50.csv', 'r')
training_data_list = training_data_file.readlines()
training_data_file.close()

# тренировка нейронной сети

# переменная epochs указывает, сколько раз тренировочный
# набор данных используется для тренировки сети
epochs = 100
error_epochs = []  # ошибки за эпоху

for e in range(epochs):
    # перебрать все записи в тренировочном наборе данных
    sum_error = 0  # суммирование ошибок по всем записям
    for record in training_data_list:
        # получить список значений из записи, используя символы
        # запятой ',' в качестве разделителей
        all_values = record.split(',')
        # масштабировать и сместить входные значения
        inputs = (numpy.asfarray(all_values[1:]) / 255.0 * 0.99) + 0.01
        # создать целевые выходные значения (все равны 0.01,
        # за исключением желаемого маркерного значения, равного 0.99)
        targets = numpy.zeros(output_nodes) + 0.01
        # all_values[0] - целевое маркерное значение для данной записи
        targets[int(all_values[0])] = 0.99
        errors = n.train(inputs, targets)  # ошибки выходного слоя на текущей эпохе
        e = numpy.linalg.norm(errors)  # норма L2 вектора ошибок
        sum_error = sum_error + e  # суммирование ошибок по всем записям
        pass
    error_epochs.append(sum_error / 100)  # ошибки за эпоху
    pass

# matplotlib.pyplot.plot(error_epochs)
# matplotlib.pyplot.show()

# загрузить в список тестовый набор данных из CSV-файла набора MNIST
test_data_file = open("C:/xampp/htdocs/www/neuropropisi/received_files/propisi.csv", 'r')
test_data_list = test_data_file.readlines()
test_data_file.close()
test_data_list.remove('\n')

# тестирование нейронной сети

# журнал оценок работы сети, первоначально пустой
scorecard = []

# перебрать все записи в тестовом наборе данных
for record in test_data_list:
    # получить список значений из записи, используя символы
    # запятой ','в качестве разделителей
    all_values = record.split(',')
    # правильный ответ - первое значение
    correct_label = int(all_values[0])
    # масштабировать и сместить входные значения
    inputs = (numpy.asfarray(all_values[1:]) / 255.0 * 0.99) + 0.01
    # опрос сети
    outputs = n.query(inputs)
    # индекс наибольшего значения является маркерным значением
    label = numpy.argmax(outputs)
    # добавить оценку ответа сети в конец списка
    if label == correct_label:
        # в случае правильного ответа сети добавить к списку значение 1
        scorecard.append(1)
    else:
        # в случае неправильного ответа сети добавить к списку значение 0
        scorecard.append(0)
        pass

    pass

# рассчитать показатель эффективности в виде доли правильных ответов
scorecard_array = numpy.asarray(scorecard)
effect = round((scorecard_array.sum() / scorecard_array.size) * 100.0, 2)

# тестирование нейронной сети
# получить первую тестовую запись
all_values = test_data_list[0].split(',')

alf = 'АБВГДЕЖЗИКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ'
count = 0
for c in range(1, len(alf)+1):
    if int(all_values[0]) == c:
        alf_sym = c - 1
        print("Ваша буква -", alf[alf_sym])
        count += 1
        break
if count == 0:
    print("Символ не распознан")

marker = int(all_values[0])
image_array = numpy.asfarray(all_values[1:]).reshape((50, 50))
matplotlib.pyplot.imshow(image_array, cmap='Greys', interpolation='None')
ver = n.query((numpy.asfarray(all_values[1:]) / 255.0 * 0.99) + 0.01)
print(ver)
# Соответствие проверяемого символа с эталоном
proverka = round(*ver[marker] * 100.0, 2)
print("Соответствие проверяемого символа с эталоном - " + str(proverka) + "% \n")
plt.show()

# открытие в режиме записи
f = open('C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt', 'w', encoding='utf-8')
# запись в файл
f.write("Эффективность распознавания составила " + str(effect) + "% \n")
if count == 0:
    f.write("Символ не распознан \n")
else:
    f.write("Ваша буква - " + alf[alf_sym] + "\n")
    f.write("Соответствие проверяемого символа с эталоном - " + str(proverka) + "% \n")
    if proverka >= 70.0:
        f.write("Оценка - 5 (отлично)")
    elif 40.0 <= proverka < 70.0:
        f.write("Оценка - 4 (хорошо)")
    elif 20.0 <= proverka < 40.0:
        f.write("Оценка - 3 (удовлетворительно)")
    elif 10.0 <= proverka < 20.0:
        f.write("Оценка - 2 (плохо)")
    elif proverka < 10.0:
        f.write("Оценка - 1 (очень плохо)")
# закрытие файла
f.close()

# конвертация в pdf
pdf = FPDF()
pdf.add_page()
# Добавление шрифта для работы с кириллицей
pdf.add_font('DejaVu', '', 'font/DejaVuSansCondensed.ttf', uni=True)
# Шрифт и его размер
pdf.set_font('DejaVu', size=15)
# Открываем txt-файл в режиме для чтения
with open("C:/xampp/htdocs/www/neuropropisi/received_files/propisi.txt", "r", encoding='utf-8-sig') as f:
    pdf.cell(200, 10, txt="Результаты:", ln=1, align='C')
    pdf.cell(200, 10, txt="", ln=1, align='C')
    l = [line.strip('\n') for line in f]
    # Циклом проходимся по данным из txt-файла
    for i in l:
        # Заполняем pdf-файл данными из txt-файла
        pdf.cell(200, 10, txt=i, ln=1, align='L')
    pdf.cell(200, 10, txt="", ln=1, align='C')
    pdf.cell(200, 10, txt="Тестируемое изображение (следующая страница):", ln=1, align='C')
# Сохранение итогового PDF-файла
pdf.output("C:/xampp/htdocs/www/neuropropisi/received_files/Result_pdf.pdf")

a4_page_size = [img2pdf.in_to_pt(4.5), img2pdf.in_to_pt(4.5)]
layout_function = img2pdf.get_layout_fun(a4_page_size)
pdf = img2pdf.convert(imagefile, layout_fun=layout_function)
with open('C:/xampp/htdocs/www/neuropropisi/received_files/Result_image.pdf', 'ab') as file_image:
     file_image.write(pdf)
first_pdf = "C:/xampp/htdocs/www/neuropropisi/received_files/Result_pdf.pdf"
second_pdf = "C:/xampp/htdocs/www/neuropropisi/received_files/Result_image.pdf"
output_file = "C:/xampp/htdocs/www/neuropropisi/received_files/Result_output.pdf"
# объединяем файлы
pdfs = [first_pdf, second_pdf]
merger = PdfMerger()
for pdf in pdfs:
    merger.append(pdf)
merger.write(output_file)
merger.close()

