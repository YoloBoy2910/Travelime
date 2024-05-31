<?php
include("Assets/INC/includes.php");
include("Assets/INC/logins.php");

includeHeader();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $age = intval($_POST['age']);

    if ($age >= 18 && $age < 30) {
        LoginY();
    } elseif ($age >= 30 && $age <= 60) {
        LoginA();
    } else {
        LoginE();
    }
}
