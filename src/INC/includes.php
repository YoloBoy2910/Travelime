<?php

include("functions.php");

use App\Models\User;

function includeHeader($optionalScripts = [])
{
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
        <link rel="stylesheet" href="/Travelime/src/CSS/style.css">

        <?php
        if ($optionalScripts != []) {
            foreach ($optionalScripts as $optionalScript) {
                if ($optionalScript == "hotelmap") {
                ?>
                    <!-- Start old places script. 
                    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAzabKtWQq9f72-mTg661g_KQQGdgO7Sq8&loading=async&libraries=places,marker&callback=initAutocomplete">
                    </script>
                    End old places script. -->

                    <!-- Libraries/dependencies for the new places api. -->
                    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

                    <script type="module" src="https://unpkg.com/@googlemaps/extended-component-library"></script>

                    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
                    ({key: "AIzaSyAzabKtWQq9f72-mTg661g_KQQGdgO7Sq8", v: "beta"});</script>

                    <gmpx-api-loader key="AIzaSyAzabKtWQq9f72-mTg661g_KQQGdgO7Sq8"></gmpx-api-loader>
                <?php
                } else {
                ?>
                    <link rel="stylesheet" href="/Travelime/src/CSS/<?php echo $optionalScript; ?>.css"><?php
                }
            }
        }
        ?>

        <!-- Favicon -->
        <link rel="icon" href="/Travelime/src/IMG/Logo.ico">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Custom Font -->
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

            body {
                background: var(--white);
                font-family: "Kanit", sans-serif;
                font-weight: 500;
                font-style: italic;
            }
        </style>
    </head>
<?php
}

function includeNavbar()
{
    includeChatbot();
?>
    <nav class="navbar navbar-expand-lg">
        <div class="navbarContent">
            <a href="/Travelime/home" class="logoLink">
                <img src="/Travelime/src/IMG/Logo.png" alt="Travelime" class="navbarLogo">
            </a>
            <h1><a href="/Travelime/home" class="logoLink">TRAVELIME</a></h1>
        </div>
        <button class="navbarHamburger navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/Travelime/traveladvice">Travel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Travelime/hotels">Hotels</a>
                </li>
            </ul>
            <div class="navbar-right ms-auto">
                <?php if (!isset($_SESSION['logged-in'])) { ?>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/Travelime/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/Travelime/register">Register</a>
                        </li>
                        <li class="nav-item">
                            <a href="/Travelime/account"><img class="profilePicture" src="/Travelime/src/IMG/HotelPlaceholder.png"></a>
                        </li>
                    </ul>
                <?php } else if (isset($_SESSION['username'])) {
                    $User = new User();
                    $username = $_SESSION['username'];
                    $userData = $User->getUserByUsername($username);
                ?>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/Travelime/logout">Logout</a>
                        </li>
                        <li class="nav-item">
                            <a href="/Travelime/account"><img class="profilePicture" src="/Travelime/src/IMG/PROFILEIMG/<?php echo $userData['picture']; ?>"></a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
<?php
}

function includeFooter($optionalScripts = [])
{
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
                            <a href="https://nl-nl.facebook.com/" target="_blank" class="footerButton"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="https://www.instagram.com/" target="_blank" class="footerButton"><i class="fab fa-instagram"></i></a>
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
    <script src="/src/JS/main.js"></script>
    <?php
    if ($optionalScripts != []) {
        foreach ($optionalScripts as $optionalScript) {
            if($optionalScript == "hotels2") {
                ?>
                <script type="module" src="/Travelime/src/JS/<?php echo $optionalScript; ?>.js"></script><?php
            } else {
                ?>
                <script src="/Travelime/src/JS/<?php echo $optionalScript; ?>.js"></script><?php
            }     
        }
    }
    ?>
    </body>

    </html>
<?php
}

function includeChatbot()
{
?>
    <button id="chatbot_button" onclick="chatbot_box()">
        <img id="chatbotLogo" src="/Travelime/src/IMG/Support.png" alt="chatbot">
    </button>
    <div id="chatbot">
        <button onclick="chatbot_box()" class="close">&#x2715;</button>
        <div class="outputContainer" id="outputContainer">
            <?php if (isset($_SESSION['messages'])) {
                foreach ($_SESSION["messages"] as $output) { ?>
                    <div class="output"><?php echo htmlspecialchars($output); ?></div>
            <?php }
            }
            ?>
        </div>
        <div class="UI">
            <input type="text" name="userInput" id="userInput" autocomplete="off" autoscroll="on">
            <button onclick="Press()"><img src="/Travelime/src/IMG/send.png" alt="send"></button>
        </div>
    </div>
<?php
}

function dd($var, $die = false)
{
    echo "<pre style='background-color: #fff; border: 1px solid #000;'>";
    var_dump($var);
    echo "</pre>";
    if ($die) {
        die("End of dump!");
    }
}
