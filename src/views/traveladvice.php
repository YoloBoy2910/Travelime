<?php
include("src/INC/includes.php");
include("src/INC/functions.php");

includeHeader();
includeNavbar($travelAdvices);
includeChatbot();
?>

<!-- <div style="height:1vh;background:white;"></div> -->

<!-- Start traveladvice container. -->
<div style="height:auto;">
    <div class="content">
        <?php

            if (isset($countryAdvice)) { 
                if($countryAdvice != "404") {
                    ?> 
                <div class="travelAdvice" style="background-image: url('<?php echo $countryAdvice['countryImage']; ?>');">
                    <div class="travelAdviceContent">
                        <h2><?php echo $countryAdvice['countryName']; ?></h2>
                        <h4>Capital: <?php echo $countryAdvice['countryCapital']; ?></h4>
                        <p><?php echo $countryAdvice['countryDescription']; ?></p>

                        <p>Known For:
                            <?php
                            $keywords = explode(',', $countryAdvice['countryKeywords']);
                            foreach ($keywords as $keyword) {
                                echo '<span class="badge badge-success">' . trim($keyword) . '</span> ';
                            }
                            ?>
                        </p>

                        <p>Major Cities:
                            <?php
                            $majorCities = explode(',', $countryAdvice['countryMajorCities']);
                            foreach ($majorCities as $city) {
                                echo '<span class="badge badge-warning">' . trim($city) . '</span> ';
                            }
                            ?>
                        </p>

                        <p>Language(s):
                            <?php
                            $languages = explode(',', $countryAdvice['countryLanguages']);
                            foreach ($languages as $language) {
                                echo '<span class="badge badge-primary">' . trim($language) . '</span> ';
                            }
                            ?>
                        </p>

                        <p>Currency: <span class="badge badge-secondary"><?php echo $countryAdvice['countryCurrency']; ?></span></p>
                        <a href="/Travelime/traveladvice">Check for hotels</a>
                    </div>
                </div>
                <?php 
                } else {
                    echo "No advice available for this country/country doesn't exist";
                }
            } 
        ?>
    </div>
</div>
<!-- End traveladvice container. -->

<!-- Start recommendations. --> 
<div class="recommendations">
    <div class="container">
        <h2 class="recommendationsHeader d-block mb-4">destinations you might like</h2>
        <div class="row justify-content-center">
            <?php
            shuffle($travelAdvices);

            $uniqueTravelAdvices = array_slice($travelAdvices, 0, 3); // Change 3 to the number of recommendations you need

            foreach ($uniqueTravelAdvices as $advice) {
            ?>
                <div class="col-4 col-md-4 mb-3">
                    <a href="/Travelime/traveladvice/<?php echo $advice['countryName']; ?>" class="imageWrapper">
                        <img src="<?php echo $advice['countryImage']; ?>" alt="<?php echo $advice['countryName']; ?>" class="img-fluid recommendationsIMG">
                        <p class="textOverlay"><?php echo $advice['countryName']; ?></p>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <?php
            $uniqueTravelAdvices = array_slice($travelAdvices, 3, 2); // Adjust the start and length as needed

            foreach ($uniqueTravelAdvices as $advice) {
            ?>
                <div class="col-4 col-md-6 mb-3">
                    <a href="/Travelime/traveladvice/<?php echo $advice['countryName']; ?>" class="imageWrapper">
                        <img src="<?php echo $advice['countryImage']; ?>" alt="<?php echo $advice['countryName']; ?>" class="img-fluid recommendationsIMG">
                        <p class="textOverlay"><?php echo $advice['countryName']; ?></p>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- End recommendations. -->

<!-- Start scroll text. -->
<div id="scrollContainer">
    <div id="scrollText">
        <?php
            foreach($travelAdvices as $travelAdvices) {
                ?><a href="/Travelime/traveladvice/<?php echo $travelAdvices['countryName'];?>"><?php echo $travelAdvices['countryName'];?>&nbsp;&nbsp;&nbsp;&nbsp;</a>
                <?php
            }
        ?>
    </div>
</div>
<!-- End scroll text. -->

<!-- Start suprise me button. -->
<div class="surpriseMe">
    <div class="container">
        <div class="col-md-6">
        <h2 class="recommendationsHeader d-block mb-4">Can't make a decision?</h2>
        </div>
        <div class="col-md-6">
            <a href="/Travelime/traveladvice/random" id="surpriseMeButton">Surprise Me!</a>
        </div>
    </div>
</div>
<!-- End surprise me button. -->

<?php
includeFooter();
?>