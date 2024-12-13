<?php
// Задание 1 и 2: Конкатенация и вывод текста с переменными
$name = "John"; // Задайте имя
$age = 25; // Задайте возраст

echo "Hello! My name is '$name'.<br>";
echo "I’m $age.<br><br>";

// Задание 3: Операции с числами
$a = 10;
$b = 20;
$rez = $a + $b;
echo "'$a' + '$b' = '$rez'.<br><br>";

// Задание 4: Поменять местами два числа без третьей переменной
$a = $a + $b; // $a = 30
$b = $a - $b; // $b = 10
$a = $a - $b; // $a = 20
echo "a = $a, b = $b<br><br>";

// Задание 5: Вопросы с вариантами ответов
?>
<form>
    <p>1. Выберите правильный вариант:</p>
    <input type="radio" name="q1" value="1"> Вариант 1<br>
    <input type="radio" name="q1" value="2"> Вариант 2 (правильный)<br>
    <input type="radio" name="q1" value="3"> Вариант 3<br>
    <input type="radio" name="q1" value="4"> Вариант 4<br>

    <p>2. Выберите все правильные варианты:</p>
    <input type="checkbox" name="q2[]" value="1"> Вариант 1<br>
    <input type="checkbox" name="q2[]" value="2"> Вариант 2 (правильный)<br>
    <input type="checkbox" name="q2[]" value="3"> Вариант 3<br>
    <input type="checkbox" name="q2[]" value="4"> Вариант 4 (правильный)<br>

    <p>3. Введите ваш ответ:</p>
    <textarea name="q3"></textarea><br>

    <button type="submit">Отправить</button>
</form>

<?php
// Задание 6: Стили для тега
$tag = "div";
$background_color = "lightblue";
$color = "black";
$width = "200px";
$height = "100px";

echo "<$tag style=\"background-color: $background_color; color: $color; width: $width; height: $height;\">Это $tag с заданными стилями.</$tag>";
?>
