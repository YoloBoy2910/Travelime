<?php
include("src/INC/includes.php");
include("src/INC/functions.php");

includeHeader(["hotelmap", "hotels"]);
includeNavbar($travelAdvices);
?>

<div id="overlay"></div>

    <?php
    if(isset($countryAdvice)) {
    ?>
        <!-- Start selected country info. -->
        <section id="selected-country">

            <div id="country-img-container">
                <img src="<?php echo $countryAdvice['countryImage'];?>" alt="tubby">
            </div>
            
            <div id="selected-country-info">
                <h1><?php echo $countryAdvice['countryName'];?></h1>
                <p><?php echo $countryAdvice['countryDescription'];?></p>
            </div>
        </section>
        <!-- End selected country info. -->
    <?php
    }
    
    ?>

    <!-- Start radius container. -->
    <section class="intro-text-container" id="radius-container">
        <i class="fa-solid fa-compass font-size-100"></i>

        <div class="width-30">
        <h1>Define your own radius!</h1>
        <p>Decide wether you want to be close to the heart of a city or perhaps far away!</p>
        </div>
    </section>
    <!-- End radius container. -->

    <!-- Bookmark container. -->
    <section class="intro-text-container" id="bookmark-container">
        <div class="width-30">
        <h1>Bookmark your hotels!</h1>
        <p>Found a hotel you really like? Bookmark it so you can look back on it later!</p>
        </div>

        <i class="fa-solid fa-bookmark font-size-100"></i>
    </section>

    <!-- End bookmark container. -->

    <!-- Country selection container. -->
    <section class="intro-text-container" id="country-selection-container">
        
        <i class="fa-solid fa-earth-americas font-size-100"></i>
        
        <div id="change-country-container">
        <h1><?php if(isset($countryAdvice)) echo "Change country"; else echo "Select country?"; ?></h1>
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
        
    </section>
    <!-- End country selection container. -->

    <!-- Start search bar. -->

    <section id="search-bar-container">
        <?php
        if(isset($countryAdvice)) {
            ?>
            <div id="current-country">
                <i class="fa-solid fa-location-dot"></i>
                <p>Country: <?php echo $countryAdvice['countryName'];?></p>
            </div>
            <?php
        }
        ?>
        
        <div id="search-bar">

            <label for="city-search">Location</label>
            <input type="text" name="city-search" id="pac-input" placeholder="Enter a location">

            <label for="radius">Radius</label>
            <select name="radius" id="radius-select">
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

            <label for="">Search</label>

            <div>
                <button id="hotel-search-button"><i class="fa-solid fa-magnifying-glass fa-lg"></i></button>
            </div>

        </div>
        
    </section>
    <!-- End search bar. -->

  <h1 id="hotel-logging-text"></h1>

  <div id="container-results-map">
    
    <div id="results-div">
        <p>No hotels available yet start searching for hotels!</p>
    </div>

    <div id="container-map">
        <div id="map"></div>
    </div>

  </div>
        <button onclick="getBookmarkedHotels()"></button>
  

<?php
includeFooter(["hotels"]);