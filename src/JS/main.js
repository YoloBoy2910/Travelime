function initAutocomplete() {
    const map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -33.8688, lng: 151.2195 },
        zoom: 13,
        mapTypeId: "roadmap",
    });
    // Create the search box and link it to the UI element.
    const input = document.getElementById("pac-input");
    const searchBox = new google.maps.places.SearchBox(input);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    // Bias the SearchBox results towards current map's viewport.
    map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
    });

    let markers = [];

    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach((marker) => {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        const bounds = new google.maps.LatLngBounds();

        places.forEach((place) => {
            if (!place.geometry || !place.geometry.location) {
                console.log("Returned place contains no geometry");
                return;
            }

            const icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25),
            };

            // Create a marker for each place.
            markers.push(
                new google.maps.Marker({
                    map,
                    icon,
                    title: place.name,
                    position: place.geometry.location,
                }),
            );
            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
}

window.initAutocomplete = initAutocomplete;

var num = 0;

function Press() {
    const userInput = document.getElementById('userInput').value;
    if (userInput != "") {
        
        console.log('User Input:', userInput); // Debugging
        const userOutput = document.createElement('div');
        userOutput.classList.add('input');
        userOutput.innerText = userInput;
        outputContainer.appendChild(userOutput);
        fetch('func/main.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'question=' + encodeURIComponent(userInput)
        })
        .then(response => {
            console.log('Response Status:', response.status); // Debugging
            return response.text();
        })
        .then(data => {
            if (data != "") {
                console.log('Response Text:', data); // Debugging
                const outputContainer = document.getElementById('outputContainer');
                if (outputContainer) {
                    const newOutput = document.createElement('div');
                    newOutput.classList.add('output');
                    newOutput.innerText = data;
                    outputContainer.appendChild(newOutput);
                } else {
                    console.error('Output container not found');
                }
            }
            else {
                const newOutput = document.createElement('div');
                newOutput.classList.add('output');
                newOutput.innerText = "I'm sorry, it appears something went wrong.";
                outputContainer.appendChild(newOutput);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    else {
        return false;
    }
}

function chatbot_box() {
    num++;
    var box = document.getElementById("chatbot");
    var button = document.getElementById("chatbot_button");
    console.log(`Display style of box: ${box.style.display}`);
    
    if (num === 1) {
        box.style.display = "flex";
        button.style.display = "none";
    } else if (num === 2) {
        box.style.display = "none";
        button.style.display = "block";
        num = 0;
    }
}