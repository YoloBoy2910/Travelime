<?php
include("Assets/INC/includes.php");
include("Assets/INC/functions.php");

ensureAgeSubmitted();

includeHeader();
includeNavbar();
?>

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
                <div class="col-md-4">
                    <!--                    <i class="fa-solid fa-hotel"></i>-->
                    <select id="category" class="form-control">
                        <option value="Hotel">Hotel</option>
                        <option value="Cruise">Cruise</option>
                        <option value="Camping">Camping</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <!--                    <i class="fa-solid fa-location-dot"></i>-->
                    <input type="text" id="place" class="form-control" placeholder="Enter a place">
                </div>
                <div class="col-md-4">
                    <button id="searchButton">Search</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="background: white; height: 80vh;"></div>

<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places&callback=initAutocomplete" async defer></script>
<script>
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