<?php

function includeHeader() {
    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Travelime</title>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- CSS -->
        <link rel="stylesheet" href="Assets/CSS/Styles.css">

        <!-- Favicon -->
        <link rel="icon" href="Assets/IMG/Logo.ico">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Custom Font -->
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

            body {
                font-family: "Kanit", sans-serif;
                font-weight: 500;
                font-style: italic;
            }
        </style>
    </head>
    <body>
    <?php
}

function includeNavbar() {
    ?>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a href="Index.php" class="logoLink"><img src="Assets/IMG/Logo.png" alt="KappersTotaal" class="navbarLogo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="TravelAdvise.php">Travel Advise</a></li>
                    <li class="nav-item"><a class="nav-link" href="HotelComparison.php">Hotel Comparison</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
}

function includeFooter() {
    ?>
    <footer class="footer py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-md-left">
                    <h5 class="footerTitle">Customer Support</h5>
                    <table class="table-borderless footerTable">
                        <tbody>
                        <tr>
                            <td>Tuesday</td>
                            <td>9.00u – 18.00u</td>
                        </tr>
                        <tr>
                            <td>Wednesday</td>
                            <td>9.00u – 18.00u</td>
                        </tr>
                        <tr>
                            <td>Thursday</td>
                            <td>9.00u – 21.00u</td>
                        </tr>
                        <tr>
                            <td>Friday</td>
                            <td>9.00u – 21.00u</td>
                        </tr>
                        <tr>
                            <td>Saturday</td>
                            <td>9.00u – 17.00u</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-4 text-md-left">
                    <h5 class="footerTitle">Travelime</h5>
                    <ul class="list-unstyled footerList">
                        <li>Keizerin Marialaan 2</li>
                        <li>5702 NR, Helmond</li>
                        <li><i class="fa-solid fa-phone"></i> 0492 123456</li>
                        <li><i class="fa-solid fa-envelope"></i> contact@travelime.nl</li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h5 class="footerTitle">Socials</h5>
                    <ul class="list-unstyled">
                        <li>Check our socials!</li>
                        <li>
                            <a href="" target="_blank" class="footerButton"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="" target="_blank" class="footerButton"><i class="fab fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </footer>

    <!-- Bootstrap JavaScript and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-aTmCaqDl6M5GzAVrV+OXC5eXZOpjno9vZ7vByc4dPpPZR10a5+C49HE42V6uNOZn" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-b21VaE9r9GY4nEJN/Axpx9QTEB3+P9oU1veH3J8QzojN1VHlme/JY58Kb5nfmm9v" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
    </html>
    <?php
}