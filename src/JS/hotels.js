let resultsDiv = document.getElementById("results-div");
let hotelLoggingText = document.getElementById("hotel-logging-text");
let overlay = document.getElementById("overlay");
let map;
let markers = [];
let hotels = [];
let bookmarkedHotels = [];
let selectedCountry = document.getElementById("current-country");

function getBookmarkedHotels() {

    fetch("/Travelime/getBookmarkedHotels", {
        method: "GET",
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        bookmarkedHotels = data;
    })
    .catch(error => {
        console.log(`Error couldn't fetch data. Error: ${error}`);
    })
}

getBookmarkedHotels();

//Function for updating the bookmark state of the hotel.
function bookMarkHotel(hotel) {
    let hotelImage;

    if(hotel.photos && hotel.photos.length > 0) {
        hotelImage = hotel.photos[0].getUrl();
    } else {
        hotelImage = "/Travelime/src/IMG/HotelPlaceholder.png";
    }

    const data = {
        type: "bookmark",
        hotelId: hotel.place_id,
        hotelName: hotel.name,
        hotelImage: hotelImage,
        hotelRating: hotel.rating
    }
    
    fetch("/Travelime/updateBookmarkState", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(response => {
        //Add or remove the new added hotel from our bookmarked hotels array.
        switch(response) {
            case "bookmarked":
            bookmarkedHotels.push(data);
            break;

            case "removed":
            bookmarkedHotels = bookmarkedHotels.filter(bookmarkedHotel => bookmarkedHotel.hotelId !== hotel.place_id);
            break;

            default:
            console.log(`Message unknown: ${response}`);
        }
    })
    .catch(error => {
        console.log(`Error couldn't update bookmark state. Error: ${error}`);
    })
}

async function initAutocomplete() {
    const center = { lat: 50.064192, lng: -130.605469 };
    let options;
    // Create a bounding box with sides ~10km away from the center point
    const defaultBounds = {
        north: center.lat + 0.1,
        south: center.lat - 0.1,
        east: center.lng + 0.1,
        west: center.lng - 0.1,
    };

    // Create a new map and set its initial options
    map = new google.maps.Map(document.getElementById('map'), {
        center: center,
        zoom: 8 // Adjust the zoom level as needed
    });

    const input = document.getElementById("pac-input");
    if (!input) {
        console.error("Autocomplete input element not found");
        return;
    }

    if(selectedCountry) {
        const countryCode = selectedCountry.querySelector("p").id;
        options = {
            bounds: defaultBounds,
            componentRestrictions: { country: `${countryCode}` },
            fields: ["address_components", "geometry", "icon", "name"],
            strictBounds: false,
        };
    } else {
        options = {
            bounds: defaultBounds,
            fields: ["address_components", "geometry", "icon", "name"],
            strictBounds: false,
        };
    }
    
    
    const autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.bindTo('bounds', map);

    const hotelSearchButton = document.getElementById("hotel-search-button");
    if (!hotelSearchButton) {
        console.error("Hotel search button element not found");
        return;
    }

    hotelSearchButton.addEventListener("click", function () {
        const place = autocomplete.getPlace();

        if (!place.geometry) {
            console.log(`No details available for input: ${place.name}`);
            return;
        }

        const location = {
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng()
        };

        // Optionally, update the map to center on the selected place
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
            map.setZoom(13);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(13); // Adjust zoom level as needed
        }

        fetchHotelData(location);
    });
}

function initAutocompleteMap() {
    
}

function fetchHotelData(location) {
    
    const radiusSelect = document.getElementById("radius-select");
    const radius = radiusSelect.value;
    const map = new google.maps.Map(document.createElement('div'));
    const placeService = new google.maps.places.PlacesService(map);
    const request = {
        location: location,
        radius: radius, //Might get adjusted later on.
        type: ['lodging']
    };

    placeService.nearbySearch(request, function(results, status) {
        if(status === google.maps.places.PlacesServiceStatus.OK) {
            //Clear hotels if a new search query is done.
            resultsDiv.innerHTML = "";

            let pacInputvalue = document.getElementById("pac-input").value;
            let radiusValue = document.getElementById("radius-select").value;

            hotelLoggingText.innerHTML = `Found ${results.length} hotels around ${pacInputvalue} in a radius of ${radiusValue} miles!`;
            hotelLoggingText.classList.add("fade-in");
            setTimeout(() => {
                hotelLoggingText.classList.remove("fade-in");
            }, 2000)
        
            if(markers.length > 0) {
                markers.forEach(marker => {
                    marker.setMap(null);
                });
            }

            if(hotels.length > 0) {
                hotels = [];
            }

            results.forEach(hotel => { 
                displayHotel(hotel);
            });

        } else {
            console.log("no hotels found...");
        }
    });
}

//Function for creating an showing the fetched hotels.
function displayHotel(hotel) {
    //Create the main hotel container.
    let hotelDiv = document.createElement("div");
    hotelDiv.classList.add("hotel");

    let hotelImageDiv = document.createElement("div");
    hotelImageDiv.classList.add("hotel-image");

    let hotelImage = document.createElement("img");
    
    if (hotel.photos && hotel.photos.length > 0) {
        const photoUrl = hotel.photos[0].getUrl();
        hotelImage.src = photoUrl;
    } else {
        hotelImage.src = "/Travelime/src/IMG/HotelPlaceholder.png";
    }

    //Append them to their respective containers.
    hotelImageDiv.appendChild(hotelImage);
    hotelDiv.appendChild(hotelImageDiv);
    
    //Create hotelcontainer.
    let hotelContainer = document.createElement("div");
    hotelContainer.classList.add("hotel-container");

    //Create hotelheading.
    let hotelHeadingDiv = document.createElement("div");
    hotelHeadingDiv.classList.add("hotel-heading");
    hotelHeadingDiv.innerHTML = `<h3>${hotel.name}</h3>`;

    hotelContainer.appendChild(hotelHeadingDiv);

    //Create hotel info container.
    let hotelInfoContainer = document.createElement("div");
    hotelInfoContainer.classList.add("hotel-info");

    //Create hotel rating div.
    let hotelRatingDiv = document.createElement("div");
    hotelRatingDiv.classList.add("hotel-rating");

    //Create rating paragraph.
    let ratingParagraph = document.createElement("p");
    
    if (hotel.rating) {
        ratingParagraph.innerHTML = `<p>Rating: ${hotel.rating}</p>`;
        hotelRatingDiv.appendChild(ratingParagraph);
        
        let starDiv = generateStarDiv(hotel.rating);
        hotelRatingDiv.appendChild(starDiv);
    } else {
        ratingParagraph.innerHTML = `<p>No rating set.</p>`;
        hotelRatingDiv.appendChild(ratingParagraph);
    }

    hotelInfoContainer.appendChild(hotelRatingDiv);

    //create hotel buttons container.
    let hotelButtonsContainer = document.createElement("div");
    hotelButtonsContainer.classList.add("hotel-buttons");

    let checkboxContainer = document.createElement("div");
    checkboxContainer.classList.add("checkbox-container");

    //Create the checkbox for bookmarking hotels.
    let bookmarkCheck = document.createElement("input");
    bookmarkCheck.classList.add("bookmark-check");
    bookmarkCheck.id = hotel.place_id;
    bookmarkCheck.type = "checkbox";

    //check if the hotel is already bookmarked. If this is the case change the checkstate of the element to checked.
    if(bookmarkedHotels.some(bookmarkedHotel => bookmarkedHotel.hotelId === hotel.place_id)) {
        bookmarkCheck.checked = true;
    } else {
        bookmarkCheck.checked = false;
    }
    bookmarkCheck.addEventListener("change", () => {
        bookMarkHotel(hotel);
    })
    checkboxContainer.appendChild(bookmarkCheck);

    //Create label for the checkbox.
    let bookmarkCheckLabel = document.createElement("label");
    bookmarkCheckLabel.classList.add("bookmark-check-label");
    bookmarkCheckLabel.innerHTML = `Bookmark? <i class="fa-solid fa-book-bookmark"></i>`;
    checkboxContainer.appendChild(bookmarkCheckLabel);

    //Add the checkbox container to the buttons contianer.
    hotelButtonsContainer.appendChild(checkboxContainer);

    let reviewButton = document.createElement("button");
    reviewButton.onclick = function () {
        showHotelDetails(hotel.place_id);
    };
    reviewButton.innerHTML = `Check details! <i class="fa-solid fa-circle-info"></i>`;
    hotelButtonsContainer.appendChild(reviewButton);

    let locationButton = document.createElement("button");
    locationButton.innerHTML = `Check location! <i class="fa-solid fa-location-dot"></i>`;
    hotelButtonsContainer.appendChild(locationButton);

    hotelInfoContainer.appendChild(hotelButtonsContainer);
    hotelContainer.appendChild(hotelInfoContainer);

    hotelDiv.appendChild(hotelContainer);

    hotelDiv.classList.add("move-up-appear");

    resultsDiv.appendChild(hotelDiv);

    hotels.push(hotelDiv);

    const mapMarker = createMarker(hotel);
    const infoWindow = createInfoWindow(hotel);

    hotelDiv.addEventListener("mouseover", () => {
        infoWindow.open(map, mapMarker);
    });

    hotelDiv.addEventListener("mouseleave", () => {
        infoWindow.close();
    });
}

//Function for generating the star div.
function generateStarDiv(hotelRating) {
    let starDiv = document.createElement("div");

    let rating = Math.floor(hotelRating) - 1;

    for(let i = 0; i < 5; i++) {
        let star = document.createElement("span");
        if(i <= rating) {
            star.classList.add("fa", "fa-star", "star-checked");
        } else {
            star.classList.add("fa", "fa-star");
        }
        starDiv.appendChild(star);
    }

    return starDiv;
}

//Function for creating a marker.
function createMarker(hotel) {
    hotelLat = hotel.geometry.location.lat();
    hotelLng = hotel.geometry.location.lng();

    const myLatlng = new google.maps.LatLng(hotelLat, hotelLng);

    const hotelMarker = new google.maps.Marker({
        animation: google.maps.Animation.DROP,
        position: myLatlng,
        title: hotel.name,
    });

    hotelMarker.setMap(map);
    markers.push(hotelMarker);

    return hotelMarker;
}

//Create infowindow for the marker.
function createInfoWindow(hotel) {

    const hotelContent = 
    '<div class="hotel-infowindow">' +

        '<div class="hotel-infowindow-header">' +
        `<h3>${hotel.name}</h3>` +
        '</div>' +

        '<div class="hotel-infowindow-body">' +
        '<p>Click here to view in google maps!</p>' +
        '</div>' +

    '</div>'

    const infoWindow  = new google.maps.InfoWindow({
        content: hotelContent
    });
    
    return infoWindow;
}

function showHotelDetails(hotelId) {

    const service = new google.maps.places.PlacesService(map);

    const request = {
        placeId: hotelId,
        fields: ['name', 'formatted_address', 'geometry', 'rating', 'photos', 'price_level', 'website', 'url']
    };

    service.getDetails(request, (place, status) => {
        if(status === google.maps.places.PlacesServiceStatus.OK) {
            createHotelDetailsContainer(place);
        } else {
            console.log("Couldn't gather the hotel details.")
        }
    });
}

function createHotelDetailsContainer(hotel) {

    //Create the main container.
    let hotelDetailsContainer = document.createElement("div");
    hotelDetailsContainer.classList.add("hotel-details-container");

    //Create the hotel images container.
    let hotelImagesContainer = document.createElement("div");
    hotelImagesContainer.classList.add("hotel-images");

    //Create the image element.
    let hotelImage = document.createElement("img");
    //Check if the hotel returns and image if not use a placeholder.
    if (hotel.photos && hotel.photos.length > 0) {
        const photoUrl = hotel.photos[0].getUrl();
        hotelImage.src = photoUrl;
    } else {
        hotelImage.src = "/Travelime/src/IMG/HotelPlaceholder.png";
    }
    hotelImagesContainer.appendChild(hotelImage);

    hotelDetailsContainer.appendChild(hotelImagesContainer);

    //Create the details container.
    let hotelInfoContainer = document.createElement("div");
    hotelInfoContainer.classList.add("hotel-details");

    //Create the details header.
    let hotelheader = document.createElement("div");
    hotelheader.classList.add("hotel-details-header");
    hotelheader.innerHTML =`<h1>${hotel.name}</h1>`;
    hotelInfoContainer.appendChild(hotelheader);

    //Create the details body.
    let hotelBody = document.createElement("div");
    hotelBody.classList.add("hotel-details-body");
    hotelBody.innerHTML = `<h2>Hey mom!</h2>`;

    hotelInfoContainer.appendChild(hotelBody);

    hotelDetailsContainer.appendChild(hotelInfoContainer);

    //Create options container.
    let options = document.createElement("div");
    options.classList.add("hotel-details-options");
    options.innerHTML = `<h1>Options</h1>`;

    //Create close button.
    let closeButton = document.createElement("button");
    closeButton.onclick = function() {
        destroyDetailsContainer(hotelDetailsContainer);
    };

    closeButton.innerHTML = `Close <i class="fa-solid fa-circle-xmark"></i>`;
    options.appendChild(closeButton);

    //Create google maps button.
    let googleMapsButton = document.createElement("button");
    googleMapsButton.innerHTML = `View on map <i class="fa-solid fa-map-location-dot"></i>`;
    options.appendChild(googleMapsButton);

    hotelDetailsContainer.appendChild(options);

    //Apply the animation class to each child.
    let children = Array.from(hotelDetailsContainer.children);

    children.forEach(child => {
        child.classList.add("move-down-appear")
    });

    setTimeout(() => {
        children.forEach(child => {
            child.classList.remove("move-down-appear");
        });
    }, 500)

    //Remove the animations again.
    setTimeout(() => {
        hotelDetailsContainer.classList.remove("move-down-appear");
    }, 500)

    document.body.appendChild(hotelDetailsContainer);
    
    overlay.style.display = "block";
    setTimeout(() => {
        overlay.classList.toggle("darken")
    }, 50)
}

//Destroys the hotel details container.
function destroyDetailsContainer(detailsContainer) {
    let children = Array.from(detailsContainer.children);
    children.forEach(child => {
        child.classList.add("move-up-dissappear");
    });
    setTimeout(() => {
        detailsContainer.remove();
    }, 300)

    overlay.classList.toggle("darken");
    setTimeout(() => {
        overlay.style.display = "none";
    }, 500)
}

//traveladvice related javascript.
let countrySearch = document.getElementById("country-search");
let countryOptionsList = document.getElementById("countryOptions");
let countryOptions = Array.from(countryOptionsList.querySelectorAll("li"));
let countrySearchForm = document.getElementById("countries-form");
let countrySearchButton = document.getElementById("country-search-button");

//Event listener to make the search bar appear.
countrySearch.addEventListener("click", () => {
    let styleDisplay = window.getComputedStyle(countryOptionsList).display;
    countryOptionsList.style.display = styleDisplay !== "none" ? "none" : "block";
});

//Window eventlistener to check if there is clicked outside the searchbar.
window.addEventListener("mouseup", (event) => {
    let element = event.target.id;
    let styleDisplay = window.getComputedStyle(countryOptionsList).display;
    if (element !== "country-search" && styleDisplay === "block") {
        countryOptionsList.style.display = "none";
    }
});

//Only show countries similar to the entered input.
countrySearch.addEventListener("input", getMatchingCountries);

//Adding eventlisteners to each li element from the search list.
countryOptions.forEach(countryOption => {
    countryOption.addEventListener("click", populateSearchBar);
});

function populateSearchBar() {
    countrySearch.value = this.innerText;
    countryOptionsList.style.display = "none";
}

function getMatchingCountries() {
    let userInput = countrySearch.value.toLowerCase();
    countryOptions.filter((countryOption) => {
        if (countryOption.innerHTML.toLowerCase().includes(userInput)) {
            countryOption.style.display = "block"
        } else {
            countryOption.style.display = "none";
        }
    });
}

//Eventlistener for country search button.
countrySearchButton.addEventListener("click", () => {
    let country = countrySearch.value.toLowerCase();
    country = country.charAt(0).toUpperCase() + country.slice(1);
    document.location.href = `/Travelime/hotels/${country}`;
});