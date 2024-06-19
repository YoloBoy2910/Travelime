let bookmarkContainer = document.getElementById("bookmarks");
let buttons = Array.from(document.getElementsByClassName("remove-hotel-button"));
let hotelCount = buttons.length;

if(buttons) {
    buttons.forEach(button => button.addEventListener("click", removeBookmarkedHotel));
}

//Function for removing bookmarked hotel.
function removeBookmarkedHotel() {

    const hotelId = this.id
    const element = this.parentNode;

    console.log(element);

    const data = {
        hotelId: hotelId
    }
    fetch("/Travelime/removeBookmark", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },      
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(response => {
        console.log(response);
        element.remove();
        hotelCount--;
        if(hotelCount < 1) {
            bookmarkContainer.innerHTML = `<h3>No hotels bookmarked yet. Time to search for some hotels!<h3>`;
        }
    })
    .catch(error => {
        console.log(`Error couldn't remove element. Error: ${error}`)
    })
}