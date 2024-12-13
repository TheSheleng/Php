<?php
// Задача 1: N непарних чисел, их среднее значение и обратный порядок
$N = 10; // Количество чисел
$oddNumbers = [];
$sum = 0;
for ($i = 1; count($oddNumbers) < $N; $i += 2) {
    $oddNumbers[] = $i;
    $sum += $i;
}
$average = $sum / $N;
echo "<p>Среднее значение: $average</p>";
echo "<div>";
foreach (array_reverse($oddNumbers) as $num) {
    echo "<span style=\"font-size: {$num}px; color: red;\">$num</span> ";
}
echo "</div>";

// Задача 2: Подсчет 4-значных чисел
$mirrorCount = 0;
$allEvenCount = 0;
$allOddCount = 0;
$decreasingCount = 0;
for ($i = 1000; $i <= 9999; $i++) {
    $digits = str_split($i);
    if ($digits === array_reverse($digits)) $mirrorCount++;
    if (array_reduce($digits, function ($carry, $d) {
        return $carry && $d % 2 === 0;
    }, true)) $allEvenCount++;
    if (array_reduce($digits, function ($carry, $d) {
        return $carry && $d % 2 !== 0;
    }, true)) $allOddCount++;
    $sortedDigits = $digits;
    usort($sortedDigits, function ($a, $b) {
        return $b <=> $a;
    });
    if ($digits === $sortedDigits) $decreasingCount++;
}
echo "<p>Дзеркальні: $mirrorCount, Всі парні: $allEvenCount, Всі непарні: $allOddCount, Убывающие: $decreasingCount</p>";

// Задача 3: 10 кругов в один ряд
echo "<div style=\"display: flex; gap: 10px;\">";
for ($i = 0; $i < 10; $i++) {
    echo "<div style=\"width: 50px; height: 50px; border-radius: 50%; background-color: blue;\"></div>";
}
echo "</div>";

// Задача 4: Перевод из двоичной в шестнадцатеричную систему
$binary = "1101";
echo "<p>Ввод: " . $binary. "</p>";
$hex = dechex(bindec($binary));
echo "<p>Шестнадцатеричное представление: $hex</p><br>";

// Задача 5: Перевод в римскую систему
function toRoman($num) {
    $map = [
        'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
        'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
        'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
    ];
    $result = "";
    foreach ($map as $roman => $int) {
        while ($num >= $int) {
            $result .= $roman;
            $num -= $int;
        }
    }
    return $result;
}
$number = 1987;
echo "<p>Ввод: " . $number. "</p>";
echo "<p>Римское представление: " . toRoman($number) . "</p><br>";

// Задача 6: Календарь на текущий месяц
$month = date('m');
$year = date('Y');
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$today = date('j');
echo "<table border=1 style=\"border-collapse: collapse;\">";
echo "<tr>";
for ($d = 1; $d <= $daysInMonth; $d++) {
    $isWeekend = date('N', strtotime("$year-$month-$d")) >= 6;
    $style = $isWeekend ? "color: red;" : "";
    if ($d == $today) $style .= "border: 2px solid blue;";
    echo "<td style=\"$style\" onmouseover=\"this.style.backgroundColor='red'; this.style.color='white';\" onmouseout=\"this.style.backgroundColor=''; this.style.color='';\">$d</td>";
    if (date('N', strtotime("$year-$month-$d")) == 7) echo "</tr><tr>";
}
echo "</tr></table>";

// Задача 7: Отображение изображений
echo "<div style=\"display: flex; flex-wrap: wrap; gap: 10px;\">";
for ($i = 1; $i <= 10; $i++) {
    echo "<img src=\"img/$i.jpg\" style=\"width: 200px; height: 150px;\">";
}
echo "</div>";
?>
