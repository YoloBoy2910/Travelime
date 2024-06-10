//traveladvice related javascript.
let countrySearch = document.getElementById("country-search");
let countryOptionsList = document.getElementById("countryOptions");
let countryOptions = Array.from(countryOptionsList.querySelectorAll("li"));
let countrySearchForm = document.getElementById("countries-form");
let countrySearchButton = document.getElementById("country-search-button");

//Event listener to make the search bar appear.
countrySearch.addEventListener("mousedown", () => {
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
    document.location.href = `/Travelime/traveladvice/${country}`;
});

