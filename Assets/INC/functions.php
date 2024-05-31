<?php

function db_connect()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "travelime";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}

//Remove this later...
function db_connect_temp()
{

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "travellimebootleg";

  // Create connection
  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  return $conn;
}

function getTravelAdvices()
{
    $db = db_connect();
    $sql = "SELECT * FROM traveladvice";
    $resource = $db->query($sql) or die($db->error);
    $items = $resource->fetch_all(MYSQLI_ASSOC);
    $db->close();
    return $items;
}

function ensureAgeSubmitted()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $age = intval($_POST['age']);
        if ($age >= 18 && $age <= 120) {
            $_SESSION['age'] = $age;
            header('Location: login.php');
            exit();
        } else {
            $error = "Please enter a valid age between 18 and 120.";
        }
    } else {
        // If accessed directly, redirect to index
        header("Location: Index.php");
        exit();
    }
}
