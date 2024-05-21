<?php
include('Assets/INC/Includes.php');
include('Assets/INC/Logins.php');

includeHeader();

if (age > 18 && age < 30) {
    LoginY();
}
else if (age >= 30 && age < 60) {
    LoginA();
}
else {
    LoginE();
}
?>