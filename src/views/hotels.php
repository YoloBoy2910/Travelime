<?php
include("src/INC/includes.php");
include("src/INC/functions.php");

includeHeader(["hotelmap", "hotels"]);
includeNavbar($travelAdvices);
?>

<div id="overlay"></div>

<?php
if (isset($countryAdvice)) {
?>
    <!-- Start selected country info. -->
    <section id="selected-country">

        <div id="country-img-container">
            <img src="<?php echo $countryAdvice['countryImage']; ?>" alt="tubby">
        </div>

        <div id="selected-country-info">
            <h1><?php echo $countryAdvice['countryName']; ?></h1>
            <p><?php echo $countryAdvice['countryDescription']; ?></p>
        </div>
    </section>
    <!-- End selected country info. -->
<?php
}

?>

<div class="surpriseMe">
    <div class="container">
        <div style="background:white;height:5vh">
        </div>

        <div class="row gx-5 text-center">
            <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                    <img class="card-img-top" src="/Travelime/src/IMG/Hotels1.jpg" alt="...">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">DEFINE YOUR OWN RADIUS!</h5>
                        <p class="card-text mb-0">Decide wether you want to be close to the heart of a city or perhaps far away!</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                    <img class="card-img-top" src="/Travelime/src/IMG/Hotels2.jpg" alt="...">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">BOOKMARK YOUR HOTELS!</h5>
                        <p class="card-text mb-0">Found a hotel you really like? Bookmark it so you can look back on it later!</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card h-100 shadow border-0">
                    <img class="card-img-top" src="/Travelime/src/IMG/Hotels3.jpg" alt="...">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-3">SELECT A COUNTRY!</h5>
                        <p class="card-text mb-0">Select the country and region your looking for and receive recommendations!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <i class="fa-solid fa-earth-americas font-size-100"></i> -->

<!-- Country selection container. -->
<section class="intro-text-container" id="country-selection-container">

    <div id="change-country-container">
        <?php if (isset($countryAdvice)) { ?>
            <div id="current-country">
                <i class="fa-solid fa-location-dot"></i>
                <p id="<?php echo $countryAdvice['countryCode']; ?>"><?php echo $countryAdvice['countryName']; ?></p>
            </div>
        <?php } else { ?>
            <div id="current-country">
                <i class="fa-solid fa-location-dot"></i>
                <p>NO COUNTRY SELECTED</p>
            </div>
        <?php } ?>
    </div>

    <div id="change-country-container">
        <h2><?php if (isset($countryAdvice)) echo "CHANGE COUNTRY";
            else echo "SELECT A COUNTRY"; ?></h2>
        <div class="searchContainer d-flex flex-column me-auto">
            <div class="d-flex">
                <div class="countriesInput">
                    <input id="country-search" type="text" name="myCountry" placeholder="Country" autocomplete="off" class="form-control">
                    <button id="country-search-button" class="btn btn-outline-secondary"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="position-relative">
                <ul id="countryOptions" class="list-group">
                    <?php foreach ($travelAdvices as $travelAdvice) { ?>
                        <li class="list-group-item" data-value="<?php echo $travelAdvice['countryName']; ?>"><?php echo $travelAdvice['countryName']; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <div id="change-country-container">
        <h2 for="city-search">LOCATION</h2>
        <input class="inputLocation" type="text" name="city-search" id="pac-input" placeholder="Enter a location">
    </div>

    <div id="change-country-container">
        <h2 for="radius">RADIUS</h2>
        <select class="inputRadius" name="radius" id="radius-select">
            <option value="5000">5KM</option>
            <option value="10000">10KM</option>
            <option value="15000">15KM</option>
            <option value="20000">20KM</option>
            <option value="25000">25KM</option>
            <option value="30000">30KM</option>
            <option value="35000">35KM</option>
            <option value="40000">40KM</option>
            <option value="45000">45KM</option>
            <option value="50000">50KM</option>
        </select>
    </div>

    <div id="change-country-container">
        <!-- <h2 for="hotel-search">Search</h2> -->
        <div>
            <button id="hotel-search-button"><i class="fa-solid fa-magnifying-glass fa-lg"></i></button>
        </div>
    </div>

    <!-- Start search bar within the country selection container. -->
</section>

<!-- End country selection container. -->

<h1 id="hotel-logging-text"></h1>

<div id="container-results-map">

    <div id="results-div">
        <p>No hotels available yet start searching for hotels!</p>
    </div>

    <div id="container-map">
        <div id="map"></div>
    </div>

</div>

<?php
includeFooter(["hotels"]);
