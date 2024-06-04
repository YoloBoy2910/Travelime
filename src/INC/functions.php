<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'];
    $escaped_question = escapeshellarg($question);

    $command = "python src\\python\\text.py $escaped_question";
    $output = shell_exec($command);
    
    $_SESSION['messages'][] = $output;
    echo $output;
}

if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = array();
}