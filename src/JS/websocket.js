//For making a websocket connection with a local node js server.
const url = 'ws://localhost:3000';
const positiveContainer = document.getElementById("feedbackcount-positive");
const neutralContainer = document.getElementById("feedbackcount-neutral");
const negativeContainer = document.getElementById("feedbackcount-negative");

const webSocket = new WebSocket(url);

//Get feedbackdata as a test.
fetch("/Travelime/home/getFeedbackData", {
    method: "GET",
    headers: {
        'Content-Type': 'application/json'
    }
})
.then(response => response.json())
.then(response => {
    response.forEach(feedback => {
        console.log(`The feedback: ${feedback}`);
    });
});

//Open connection to the local node server.
webSocket.addEventListener("open", () => {
    webSocket.send(JSON.stringify({ type: "pageview", url: window.location.href }));
    webSocket.send(JSON.stringify({ type: "connect", message: "Hey server!" }));
    console.log("connected!");
});

//Event-listener when a message from the server is received.
webSocket.addEventListener("message", (message) => {
    let data = JSON.parse(message.data);
    let dataType = data.type;

    switch(dataType) {
        case "newfeedback":
        updateLiveFeedback(data.feedback);
        break

        case "chatbot":
        updateChatbotResponse();
        break

        default:
        console.log(`Unknown message type: ${dataType}`);
    }
});

//Attach eventhandlers when the connection is established.
webSocket.onopen = () => {

    /*All of these events are related to page navigation and that's why we have to make use of them all to accurately track
    the location of the client.
    */
    window.addEventListener("popstate", () => {
        webSocket.send(JSON.stringify({ type: "pageview", url: window.location.href }));
    });

    window.addEventListener("pushstate", () => {
        webSocket.send(JSON.stringify({ type: "pageview", url: window.location.href }));
    });

    window.addEventListener("replacestate", () => {
        webSocket.send(JSON.stringify({ type: "pageview", url: window.location.href }));
    });
}

//Event-listener when a connect error occurs.
webSocket.addEventListener("error", (event) => {
    console.log(`Error couldn't connect. Error: ${event}`);

});

//Function for giving the response from the chatbot back to the user.
function updateChatbotResponse() {

}

//Function for updating the feedback data live on the server.
function updateLiveFeedback(newFeedback) {
    
    let positive = positiveContainer.innerHTML;
    let neutral = neutralContainer.innerHTML;
    let negative = negativeContainer.innerHTML;

    newFeedback.forEach(feedback => {
        if(feedback.feedbackname === "Negative" && feedback.feedbackcount != negative) {
            negativeContainer.innerHTML = feedback.feedbackcount;
        } else if(feedback.feedbackname === "Neutral" && feedback.feedbackcount != neutral) {
            neutralContainer.innerHTML = feedback.feedbackcount;
        } else if(feedback.feedbackname === "Positive" && feedback.feedbackcount != positive) {
            positiveContainer.innerHTML = feedback.feedbackcount;
        }
    });
}