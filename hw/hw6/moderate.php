<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Модерація повідомлень</title>
</head>
<body>
<h1>Введіть своє повідомлення</h1>
<form action="moderate.php" method="POST">
    <textarea name="message" rows="4" cols="50" placeholder="Введіть повідомлення..."></textarea><br><br>
    <button type="submit">Надіслати</button>
</form>

<?php
if (isset($_GET['message'])) {
    echo '<h2>Модероване повідомлення:</h2>';
    echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
}
?>
</body>
</html>

<?php
// Функція для перевірки на нецензурні слова
function checkProfanity($message) {
    $badWords = ['поганий_слово1', 'поганий_слово2']; // Список нецензурних слів
    foreach ($badWords as $word) {
        if (stripos($message, $word) !== false) {
            return true;
        }
    }
    return false;
}

// Функція для перевірки на образи
function checkOffensiveContent($message) {
    $offensivePatterns = [
        '/(расизм|дискримінація|неповажний_термін)/i',  // можна додати різні патерни для перевірки
        '/(сексизм|гендерна_дискримінація)/i',
    ];

    foreach ($offensivePatterns as $pattern) {
        if (preg_match($pattern, $message)) {
            return true;
        }
    }
    return false;
}

// Функція для перевірки на заклики до насильства
function checkViolence($message) {
    $violencePatterns = [
        '/(теракт|насильство|напад|вбивство)/i'
    ];

    foreach ($violencePatterns as $pattern) {
        if (preg_match($pattern, $message)) {
            return true;
        }
    }
    return false;
}

// Функція для перевірки на спам
function checkSpam($message) {
    $spamPatterns = [
        '/(купити|реклама|розсилка|фішинг)/i'
    ];

    foreach ($spamPatterns as $pattern) {
        if (preg_match($pattern, $message)) {
            return true;
        }
    }
    return false;
}

// Функція для фільтрації забороненого змісту
function filterMessage($message) {
    if (checkProfanity($message) || checkOffensiveContent($message) || checkViolence($message) || checkSpam($message)) {
        return ''; // Повідомлення містить заборонений зміст, тому повертаємо порожній рядок
    }
    return $message;
}

// Обробка форми
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = trim($_POST['message']);

    // Фільтруємо повідомлення
    $filteredMessage = filterMessage($message);

    // Якщо повідомлення не містить забороненого змісту, зберігаємо його у файл
    if (!empty($filteredMessage)) {
        $userLogin = 'user'; // Можна отримати логін користувача, наприклад, через сесію
        $date = date('Y-m-d_H-i-s');
        $filename = $userLogin . '_' . $date . '.txt';

        // Зберігаємо повідомлення у файл
        file_put_contents($filename, $filteredMessage);

        // Перенаправляємо назад на головну сторінку з повідомленням
        header('Location: moderate.php?message=' . urlencode($filteredMessage));
        exit();
    } else {
        // Якщо повідомлення містить заборонений зміст
        echo '<p>Ваше повідомлення містить заборонений зміст і не може бути надіслане.</p>';
    }
}
?>
