function toRadian(degree) {
    return (degree * Math.PI) / 180;
}
function getDistance(origin, destination) {
    // return distance in meters
    var lon1 = toRadian(origin[1]),
        lat1 = toRadian(origin[0]),
        lon2 = toRadian(destination[1]),
        lat2 = toRadian(destination[0]);

    var deltaLat = lat2 - lat1;
    var deltaLon = lon2 - lon1;

    var a =
        Math.pow(Math.sin(deltaLat / 2), 2) +
        Math.cos(lat1) * Math.cos(lat2) * Math.pow(Math.sin(deltaLon / 2), 2);
    var c = 2 * Math.asin(Math.sqrt(a));
    var EARTH_RADIUS = 6371;
    return c * EARTH_RADIUS * 1000;
}

function formatDistance(value) {
    // Define the threshold for kilometers
    const threshold = 1000;

    // Determine the unit and format the output
    if (value < threshold) {
        return `${value.toFixed(2)} m`; // Format as meters with two decimal places
    } else {
        // Convert meters to kilometers and format with two decimal places
        const kilometers = (value / threshold).toFixed(2);
        return `${kilometers} km`;
    }
}

let officeMarker = null;
let officeIconMarker = null;
let userMarker = null;
let userPolyline = null;
let userTileLayer = null;

var userIcon = L.icon({
    iconUrl: "/assets/images/icon/pinpoint-user.png", // Replace with your custom icon image path
    iconSize: [41, 41], // Size of the custom icon [width, height]
    iconAnchor: [21, 41], // Anchor point [left, top]
    popupAnchor: [1, -34], // Popup should open above the icon
    shadowSize: [41, 41],
});
var officeIcon = L.icon({
    iconUrl: "/assets/images/icon/pinpoint-office.png", // Replace with your custom icon image path
    iconSize: [41, 41], // Size of the custom icon [width, height]
    iconAnchor: [21, 41], // Anchor point [left, top]
    popupAnchor: [1, -34], // Popup should open above the icon
    shadowSize: [41, 41],
});
var map = L.map("map", {
    zoomControl: false,
});
map.attributionControl.setPrefix(false);
// Using Openstreetmap tile layer
// https://tile.openstreetmap.org/{z}/{x}/{y}.png
userTileLayer = L.tileLayer(
    "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
    {
        maxZoom: 19,
        // attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }
).addTo(map);
