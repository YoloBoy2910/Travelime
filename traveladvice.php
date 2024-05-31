<?php
include("Assets/INC/includes.php");
include("Assets/INC/functions.php");

includeHeader();
includeNavbar();
?>

<div style="height:1vh;background:white;"></div>

<div style="height:auto;">
    <div class="content">
        <?php
        // Retrieve the input country from the GET parameter
        $countryInput = isset($_GET['myCountry']) ? trim($_GET['myCountry']) : '';

        // Call the getTraveladvices function to retrieve all travel advices
        $travelAdvices = getTraveladvices();

        // Check if there are any travel advices
        if (!empty($travelAdvices)) {
            // Shuffle the travel advices for randomness
            shuffle($travelAdvices);

            // Loop through the travel advices
            foreach ($travelAdvices as $travelAdvice) {
                // Display the travel advice only if it matches the input country
                if (strtolower(trim($travelAdvice['countryName'])) == strtolower($countryInput)) {
        ?>
                    <div class="travel-advice" style="background-image: url('<?php echo $travelAdvice['countryImage']; ?>');">
                        <div class="travel-advice-content">
                            <h2><?php echo $travelAdvice['countryName']; ?></h2>
                            <h4>Capital: <?php echo $travelAdvice['countryCapital']; ?></h4>
                            <p><?php echo $travelAdvice['countryDescription']; ?></p>

                            <p>Known For:
                                <?php
                                $keywords = explode(',', $travelAdvice['countryKeywords']);
                                foreach ($keywords as $keyword) {
                                    echo '<span class="badge badge-success">' . trim($keyword) . '</span> ';
                                }
                                ?>
                            </p>

                            <p>Major Cities:
                                <?php
                                $majorCities = explode(',', $travelAdvice['countryMajorCities']);
                                foreach ($majorCities as $city) {
                                    echo '<span class="badge badge-warning">' . trim($city) . '</span> ';
                                }
                                ?>
                            </p>

                            <p>Language(s):
                                <?php
                                $languages = explode(',', $travelAdvice['countryLanguages']);
                                foreach ($languages as $language) {
                                    echo '<span class="badge badge-primary">' . trim($language) . '</span> ';
                                }
                                ?>
                            </p>

                            <p>Currency: <span class="badge badge-secondary"><?php echo $travelAdvice['countryCurrency']; ?></span></p>
                            <a href="traveladvice.php">Check for hotels</a>
                        </div>
                    </div>
        <?php
                }
            }
        } else {
            echo "No travel advices available.";
        }
        ?>
    </div>
</div>

<script>
    var countries = ["Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Anguilla", "Antigua & Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia & Herzegovina", "Botswana", "Brazil", "British Virgin Islands", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central Arfrican Republic", "Chad", "Chile", "China", "Colombia", "Congo", "Cook Islands", "Costa Rica", "Cote D Ivoire", "Croatia", "Cuba", "Curacao", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands", "Faroe Islands", "Fiji", "Finland", "France", "French Polynesia", "French West Indies", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Japan", "Jersey", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kosovo", "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauro", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Norway", "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russia", "Rwanda", "Saint Pierre & Miquelon", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Korea", "South Sudan", "Spain", "Sri Lanka", "St Kitts & Nevis", "St Lucia", "St Vincent", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor Leste", "Togo", "Tonga", "Trinidad & Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks & Caicos", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States of America", "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "US Virgin Islands", "Yemen", "Zambia", "Zimbabwe"];

    function countriesInput(inp, arr) {
        var currentFocus;

        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            closeAllLists();
            currentFocus = -1;
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "countriesInput-list");
            a.setAttribute("class", "countriesInputItems");
            this.parentNode.appendChild(a);
            for (i = 0; i < arr.length; i++) {
                if (!val || arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    b = document.createElement("DIV");
                    if (!val) {
                        b.innerHTML = arr[i];
                    } else {
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                    }
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });

        inp.addEventListener("focus", function(e) {
            var val = this.value;
            closeAllLists();
            currentFocus = -1;
            var a = document.createElement("DIV");
            a.setAttribute("id", this.id + "countriesInput-list");
            a.setAttribute("class", "countriesInputItems");
            this.parentNode.appendChild(a);
            for (i = 0; i < arr.length; i++) {
                if (!val || arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    var b = document.createElement("DIV");
                    if (!val) {
                        b.innerHTML = arr[i];
                    } else {
                        b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                        b.innerHTML += arr[i].substr(val.length);
                    }
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                    a.appendChild(b);
                }
            }
        });

        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "countriesInput-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                currentFocus++;
                addActive(x);
            } else if (e.keyCode == 38) {
                currentFocus--;
                addActive(x);
            } else if (e.keyCode == 13) {
                e.preventDefault();
                if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            if (!x) return false;
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            x[currentFocus].classList.add("countriesInput-active");
        }

        function removeActive(x) {
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("countriesInput-active");
            }
        }

        function closeAllLists(elmnt) {
            var x = document.getElementsByClassName("countriesInputItems");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }

        document.addEventListener("click", function(e) {
            closeAllLists(e.target);
        });
    }

    countriesInput(document.getElementById("myInput"), countries);
</script>

<div style="height: auto;background: white;">
    <div class="container recommendations">
        <p class="d-block mb-4">Other destinations you might like</p>
        <div class="row justify-content-center">
            <?php
            // Shuffle the travel advices for randomness
            shuffle($travelAdvices);

            // Get a subset of unique travel advices for "You might also like" section
            $uniqueTravelAdvices = array_slice($travelAdvices, 0, 3); // Change 3 to the number of recommendations you need

            foreach ($uniqueTravelAdvices as $advice) {
            ?>
                <div class="col-4 col-md-4 mb-3">
                    <a href="traveladvice.php?myCountry=<?php echo urlencode($advice['countryName']); ?>" class="image-wrapper">
                        <img src="<?php echo $advice['countryImage']; ?>" alt="<?php echo $advice['countryName']; ?>" class="img-fluid recommendationsIMG">
                        <p class="overlay-text"><?php echo $advice['countryName']; ?></p>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="container recommendations">
        <div class="row justify-content-center">
            <?php
            // Get another subset of unique travel advices for "You might also like" section
            $uniqueTravelAdvices = array_slice($travelAdvices, 3, 2); // Adjust the start and length as needed

            foreach ($uniqueTravelAdvices as $advice) {
            ?>
                <div class="col-4 col-md-6 mb-3">
                    <a href="traveladvice.php?myCountry=<?php echo urlencode($advice['countryName']); ?>" class="image-wrapper">
                        <img src="<?php echo $advice['countryImage']; ?>" alt="<?php echo $advice['countryName']; ?>" class="img-fluid recommendationsIMG">
                        <p class="overlay-text"><?php echo $advice['countryName']; ?></p>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<div id="scroll-container">
        <div id="scroll-text"></div>
    </div>
    
    <script>
        var countries = ["Afghanistan", "Albania", "Algeria", /* ... add all countries here ... */ "Zimbabwe"];
        var allCountries = countries.join('  ') + '  ' + countries.join('  ') + '  ' + countries.join('  '); // Concatenate country names multiple times with extra spaces for smoother animation

        function displayAllCountries() {
            var scrollText = document.getElementById('scroll-text');
            scrollText.textContent = allCountries;
        }

        // Start the animation
        displayAllCountries();
    </script>

<?php
includeFooter();
?>