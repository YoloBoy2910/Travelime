//Variables.
let map;
let selectedPlaceMap;
let selectedPlaceMarker;
let infoWindow;
let markers = [];
let bookmarkedHotels = [];

//Some elements.
let autocompleteContainer = document.getElementById("autocomplete-container");
let selectRadius = document.getElementById("select-radius");
let selectedCountry = document.getElementById("current-country");
let radiusSelect = document.getElementById("radius-select");
let resultsDiv = document.getElementById("results-div");
let placeDetails = document.getElementById("place-details");
let overlay = document.getElementById("overlay");
let closeButton = document.getElementById("close-button");
let placeOverview = document.getElementById("place-overview");
let hotelSummary = document.getElementById("hotel-summary");
let currentCountry = document.getElementById("current-country")

//Function for getting the bookmarked hotels.
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

//Google maps libraries.
const [{ Map }, { AdvancedMarkerElement }] = await Promise.all([
    google.maps.importLibrary("marker"),
    google.maps.importLibrary("places"),
  ]);

const { Place, SearchNearbyRankPreference, Photo } = await google.maps.importLibrary("places");

async function initMap() {
  // Request needed libraries.
  //@ts-ignore

  //Import Advanced marker element library.
  const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
  //Initialize the map for showcasing found locations.
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 40.749933, lng: -73.98633 },
    zoom: 13,
    mapId: "4504f8b37365c3d0",
    mapTypeControl: false,
  });
  
  selectedPlaceMap = new google.maps.Map(document.getElementById("selected-location-map"), {
    center: { lat: 40.749933, lng: -73.98633 },
    zoom: 13,
    mapId: "4504f8b37365c3d0",
    mapTypeControl: false,
  });

  selectedPlaceMarker = new AdvancedMarkerElement({
    map: selectedPlaceMap, 
    position: { lat: 40.749933, lng: -73.98633 },
    title: "placeholder",
});

  let placeAutocomplete;

  const countryCode = currentCountry.querySelector("p").id;

  if(countryCode) {
    placeAutocomplete = new google.maps.places.PlaceAutocompleteElement({
        componentRestrictions: {country: countryCode}
      });
  } else {
    placeAutocomplete = new google.maps.places.PlaceAutocompleteElement();
  }

  placeAutocomplete.id = "place-autocomplete-input";

  autocompleteContainer.appendChild(placeAutocomplete);

  placeAutocomplete.addEventListener("gmp-placeselect", async ({place}) => {
    getNearbyPlaces(place);
  })
}

initMap();

async function getNearbyPlaces(place) {
  //Import places library.
  const placeLocation = await getPlaceLocation(place);

  //The place location will be set as the area in which to search.
  let center = new google.maps.LatLng(placeLocation.lat, placeLocation.lng);

  //Radius in which to search.
  let radius = Number(radiusSelect.value);

  //Import Advanced marker element library.
  const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

  const request = {
    fields: ["displayName", "location", "formattedAddress", "editorialSummary", "regularOpeningHours", "reviews", "photos", "rating"],
    locationRestriction: {
      center: center,
      radius: radius,
      type: "lodging"
    },
    includedPrimaryTypes: ["lodging"],
    maxResultCount: 20,
    rankPreference: SearchNearbyRankPreference.POPULARITY,
    language: "en-US",
  };

  //Get the places.
  const { places } = await Place.searchNearby(request);

  if(places.length) {

    const { LatLngBounds } = await google.maps.importLibrary("core");
    const bounds = new LatLngBounds();

    resultsDiv.innerHTML = "";

    if(markers.length > 0) {
        markers.forEach(marker => {
            marker.setMap(null);
        });
        markers = [];
    }
    //Loop through and get all the results.
    places.forEach((place) => {

        
        displayHotel(place);

        const markerView = new AdvancedMarkerElement({
            map, 
            position: place.location,
            title: place.displayName,
        });

        //Store the elements to dynamically keep track of the while the user is on the page.
        markers.push(markerView);

        bounds.extend(place.location);
    });
    map.fitBounds(bounds);
  } else {
    console.log("No results");
  }
};

//For gathering the location values of a place.
async function getPlaceLocation(selectedPlace) {
    let placeId = selectedPlace.id;

    const place = new Place({
        id: placeId,
        requestedLanguage: "en", // optional
    });

    await place.fetchFields({
        fields: ["location"]
    })
    
    const LatLng = {
        lat: place.location.lat(),
        lng: place.location.lng()
    }
    return LatLng;
}

//For getting the summary of a place.
async function getPlaceSummary(selectedPlace) {
    let placeId = selectedPlace.id;

    const place = new Place({
        id: placeId,
        requestedLanguage: "en", // optional
    });

    await place.fetchFields({
        fields: ["editorialSummary"]
    })

    return place.editorialSummary;
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
        const photo = hotel.photos[0];

        const photoUrl = photo.getURI();
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
    hotelHeadingDiv.innerHTML = `<h3>${hotel.displayName}</h3>`;

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
    if (bookmarkedHotels.some(bookmarkedHotel => bookmarkedHotel.hotelId === hotel.id)) {
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
        showHotelDetails(hotel);
    };
    reviewButton.innerHTML = `Check details! <i class="fa-solid fa-circle-info"></i>`;
    hotelButtonsContainer.appendChild(reviewButton);

    hotelInfoContainer.appendChild(hotelButtonsContainer);
    hotelContainer.appendChild(hotelInfoContainer);

    hotelDiv.appendChild(hotelContainer);

    hotelDiv.classList.add("move-up-appear");

    hotelDiv.addEventListener("mouseover", () => {
        
    })

    resultsDiv.appendChild(hotelDiv);
}

//Function for generating the star div.
function generateStarDiv(hotelRating) {
    let starDiv = document.createElement("div");

    let rating = Math.floor(hotelRating) - 1;

    for (let i = 0; i < 5; i++) {
        let star = document.createElement("span");
        if (i <= rating) {
            star.classList.add("fa", "fa-star", "star-checked");
        } else {
            star.classList.add("fa", "fa-star");
        }
        starDiv.appendChild(star);
    }

    return starDiv;
}

//Function for showing the hotel details.
async function showHotelDetails(hotel) {

    const { LatLngBounds } = await google.maps.importLibrary("core");
    const bounds = new LatLngBounds();

    //get the place location.
    let hotelLocation = await getPlaceLocation(hotel)
    let center = new google.maps.LatLng(hotelLocation.lat, hotelLocation.lng);

    let placeSummary = await getPlaceSummary(hotel);
    if(placeSummary) {
        hotelSummary.innerHTML = placeSummary;
    } else {
        hotelSummary.innerHTML = "Summary not available yet.";
    }

    bounds.extend(center);

    selectedPlaceMap.fitBounds(bounds);

    selectedPlaceMap.center = center;
    selectedPlaceMarker.position = center;
    placeOverview.place = hotel.id;

    //Change style displays.
    placeDetails.style.display = "flex";
    overlay.style.display = "block";
    setTimeout(() => {
        overlay.classList.toggle("darken")
        placeDetails.style.opacity = "1"
    }, 50);
}

//For closing the details container.
closeButton.addEventListener("click", () => {
    overlay.classList.toggle("darken");
    placeDetails.style.opacity = "0"
    setTimeout(() => {
    overlay.style.display = "none";
    placeDetails.style.display = "none";
    }, 500);
});

//Function for updating the bookmark state of the hotel.
function bookMarkHotel(hotel) {
    let hotelImage;
    if (hotel.photos && hotel.photos.length > 0) {
        const photo = hotel.photos[0];
        hotelImage = photo.getURI();
    } else {
        hotelImage = "/Travelime/src/IMG/HotelPlaceholder.png";
    }

    const data = {
        type: "bookmark",
        hotelId: hotel.id,
        hotelName: hotel.displayName,
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
            switch (response) {
                case "bookmarked":
                    bookmarkedHotels.push(data);
                    break;

                case "removed":
                    bookmarkedHotels = bookmarkedHotels.filter(bookmarkedHotel => bookmarkedHotel.hotelId !== hotel.id);
                    break;

                default:
                    console.log(`Message unknown: ${response}`);
            }
        })
        .catch(error => {
            console.log(`Error couldn't update bookmark state. Error: ${error}`);
        })
}

/*
//Js for country search bar.
*/
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