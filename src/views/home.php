<?php
include("src/INC/includes.php");
include("src/INC/functions.php");

includeHeader();
includeNavbar();

$ageGroup = isset($_SESSION['age-group']) ? $_SESSION['age-group'] : '';
?>

<body>
    <div class="promoDeal">
        <div class="row">
            <div class="col-md-6 greenCurve">
                <div class="bannerText">
                    <h1 class="travelime">Travelime</h1>
                    <h2>"Fresh Moments, <br>Endless Adventures"</h2>
                    <div class="line"></div>
                    <h3>Select a country<br>Express your wishes<br>Compare the hotels in the area</h3>
                </div>
            </div>

            <div class="col-md-6 whiteRight">
                <div class="imageCurve"></div>
            </div>
        </div>
    </div>

    <section class="home-introduction">
    <div class="container px-5 my-5">
        <div class="row gx-5">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h2 class="fw-bolder mb-0">Steps to finding your perfect destination</h2>
            </div>
            <div class="col-lg-8">
                <div class="row gx-5 row-cols-1 row-cols-md-2">
                    <div class="col mb-4 h-100 home-introduction-item">
                        <h5>Open the chatbot</h5>
                        <p class="mb-0">Open the chatbot by clicking the circle in the bottomleft corner.</p>
                    </div>
                    <div class="col mb-4 h-100 home-introduction-item">
                        <h5>Give it a prompt</h5>
                        <p class="mb-0">Send a prompt to the chatbot about your wishes for your perfect vacation.</p>
                    </div>
                    <div class="col mb-4 h-100 home-introduction-item">
                        <h5>Check the countries</h5>
                        <p class="mb-0">Check the countries that the chatbot returns in Travel Advice</p>
                    </div>
                    <div class="col mb-4 h-100 home-introduction-item">
                        <h5>Find hotels</h5>
                        <p class="mb-0">Click the "Check for hotels" button, and find the place that suits you the best.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<svg id="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill-opacity="1" d="M0,96L30,112C60,128,120,160,180,154.7C240,149,300,107,360,85.3C420,64,480,64,540,69.3C600,75,660,85,720,112C780,139,840,181,900,181.3C960,181,1020,139,1080,122.7C1140,107,1200,117,1260,122.7C1320,128,1380,128,1410,128L1440,128L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path>
    </svg>


    <section class="container feedback-section">
        <h1>GIVE FEEDBACK FROM THE ARDUINO</h1>
        <div id="feedback-container">
            <?php
            if (isset($feedbacks)) {
            ?>
                <ul class="feedback-box">
                    <?php
                    foreach ($feedbacks as $feedback) {
                        if ($feedback['feedbackname'] == "Positive") {
                    ?>
                            <li><span id="feedbackcount-positive"><?php echo $feedback['feedbackcount']; ?></span><i class="ratingGood fa-solid fa-face-smile"></i></li>
                        <?php
                        } else if ($feedback['feedbackname'] == "Neutral") {
                        ?>
                            <li><span id="feedbackcount-neutral"><?php echo $feedback['feedbackcount']; ?></span><i class="ratingRegular fa-solid fa-face-meh"></i></li>
                        <?php
                        } else {
                        ?>
                            <li><span id="feedbackcount-negative"><?php echo $feedback['feedbackcount']; ?></span><i class="ratingBad fa-solid fa-face-frown"></i></li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            <?php
            }
            ?>

        </div>
    </section>

    <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places&callback=initAutocomplete" async defer></script>
    <script>
        var ageGroup = "<?php echo isset($_SESSION['guest-age-group']) ? $_SESSION['guest-age-group'] : ''; ?>";

        function initAutocomplete() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: {
                    lat: -33.8688,
                    lng: 151.2195
                },
                zoom: 13,
                mapTypeId: "roadmap",
            });

            const input = document.getElementById("place");
            const autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.bindTo("bounds", map);

            autocomplete.addListener("place_changed", () => {
                const place = autocomplete.getPlace();

                if (!place.geometry || !place.geometry.location) {
                    console.error("Returned place contains no geometry");
                    return;
                }

                map.setCenter(place.geometry.location);
                map.setZoom(15); // Adjust zoom level as needed

                new google.maps.Marker({
                    map,
                    title: place.name,
                    position: place.geometry.location,
                });
            });
        }
    </script> -->

    <?php
    includeFooter(["account", "websocket"]);
    ?>