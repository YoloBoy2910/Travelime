<?php
function ensureAgeSubmitted() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
        if ($age !== false && $age >= 18 && $age <= 120) {
            // Redirect to the home page or wherever needed with age as a query parameter
            header("Location: Login.php?age=" . $age);
            exit();
        }
    }
    else {
        // If accessed directly, redirect to index
        header("Location: Index.php");
        exit();
    }
}