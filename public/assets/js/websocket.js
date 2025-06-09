const socket = new WebSocket("ws://localhost:3000");

socket.onopen = () => {
    console.log("Connected to WebSocket server");
};

socket.onmessage = (event) => {
    console.log("Received from server:", event.data);
    // Toast or update DOM here
};

socket.onclose = () => {
    console.log("Disconnected from WebSocket server");
};

function sendToServer(msg) {
    socket.send(msg);
}
socket.onerror = (error) => {   
    console.error("WebSocket error:", error);
}
