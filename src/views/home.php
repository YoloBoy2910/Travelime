<?php
include("src/INC/includes.php");
include("src/INC/functions.php");

includeHeader();
includeNavbar($travelAdvices);

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

            <div class="searchBar">
                <div class="row">
                    <div class="col-md-6">
                        <!--                    <i class="fa-solid fa-location-dot"></i>-->
                        <input type="text" id="place" class="form-control" placeholder="Enter a place">
                    </div>
                    <div class="col-md-6">
                        <button id="searchButton">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="py-5" id="features" style="background: white;">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h2 class="fw-bolder mb-0">Steps to finding your perfect destination</h2>
                </div>
                <div class="col-lg-8">
                    <div class="row gx-5 row-cols-1 row-cols-md-2">
                        <div class="col mb-4 h-100">
                            <h5>Open the chatbot</h5>
                            <p class="mb-0">Open the chatbot by clicking the circle in the bottomleft corner.</p>
                        </div>
                        <div class="col mb-4 h-100">
                            <h5>Give it a prompt</h5>
                            <p class="mb-0">Send a prompt to the chatbot about your wishes for your perfect vacation.</p>
                        </div>
                        <div class="col mb-4 mb-md-0 h-100">
                            <h5>Check the countries</h5>
                            <p class="mb-0">Check the countries that the chatbot returns in Travel Advice</p>
                        </div>
                        <div class="col h-100">
                            <h5>Find hotels</h5>
                            <p class="mb-0">Click the "Check for hotels" button, and find the place that suits you the best.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <div style="background: white; height: 80vh;"></div> -->

    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
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
    </script>
    <?php
    includeFooter();
    ?>