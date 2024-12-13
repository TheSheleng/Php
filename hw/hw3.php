<?php
session_start();

if (!isset($_SESSION['step'])) {
    $_SESSION['step'] = 1;
    $_SESSION['score'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['answers'])) {
    $answers = $_GET['answers'];
    $correctAnswersStep1 = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J']; // Правильні відповіді 1-ї сторінки
    $correctAnswersStep2 = [
        ["A", "C"], ["B", "D"], ["A", "B"], ["C", "D"], ["A", "D"],
        ["B", "C"], ["A", "C"], ["B", "D"], ["A", "B"], ["C", "D"]
    ]; // Правильні відповіді 2-ї сторінки
    $correctAnswersStep3 = ["answer1", "answer2", "answer3", "answer4", "answer5", "answer6", "answer7", "answer8", "answer9", "answer10"];

    if ($_SESSION['step'] == 1) {
        foreach ($answers as $index => $answer) {
            if ($answer === $correctAnswersStep1[$index]) {
                $_SESSION['score'] += 1;
            }
        }
        $_SESSION['step'] = 2;
    } elseif ($_SESSION['step'] == 2) {
        foreach ($answers as $index => $userAnswers) {
            $correctAnswers = $correctAnswersStep2[$index];
            if (!array_diff($correctAnswers, $userAnswers) && !array_diff($userAnswers, $correctAnswers)) {
                $_SESSION['score'] += 3;
            }
        }
        $_SESSION['step'] = 3;
    } elseif ($_SESSION['step'] == 3) {
        foreach ($answers as $index => $answer) {
            if (strtolower($answer) === strtolower($correctAnswersStep3[$index])) {
                $_SESSION['score'] += 5;
            }
        }
        $_SESSION['step'] = 4;
    }
}

if ($_SESSION['step'] == 1) {
    echo "<form method='GET'>";
    for ($i = 0; $i < 10; $i++) {
        echo "<p>Question " . ($i + 1) . ": Choose the correct answer</p>";
        echo "<label><input type='radio' name='answers[$i]' value='A'> A</label>";
        echo "<label><input type='radio' name='answers[$i]' value='B'> B</label>";
        echo "<label><input type='radio' name='answers[$i]' value='C'> C</label>";
        echo "<label><input type='radio' name='answers[$i]' value='D'> D</label>";
    }
    echo "<button type='submit'>Next</button>";
    echo "</form>";
} elseif ($_SESSION['step'] == 2) {
    echo "<form method='GET'>";
    for ($i = 0; $i < 10; $i++) {
        echo "<p>Question " . ($i + 1) . ": Choose all correct answers</p>";
        echo "<label><input type='checkbox' name='answers[$i][]' value='A'> A</label>";
        echo "<label><input type='checkbox' name='answers[$i][]' value='B'> B</label>";
        echo "<label><input type='checkbox' name='answers[$i][]' value='C'> C</label>";
        echo "<label><input type='checkbox' name='answers[$i][]' value='D'> D</label>";
    }
    echo "<button type='submit'>Next</button>";
    echo "</form>";
} elseif ($_SESSION['step'] == 3) {
    echo "<form method='GET'>";
    for ($i = 0; $i < 10; $i++) {
        echo "<p>Question " . ($i + 1) . ": Enter your answer</p>";
        echo "<input type='text' name='answers[$i]'>";
    }
    echo "<button type='submit'>Finish</button>";
    echo "</form>";
} elseif ($_SESSION['step'] == 4) {
    echo "<p>Your total score is: {$_SESSION['score']}</p>";
    session_destroy();
}
?>
