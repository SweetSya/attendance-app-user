console.log("ATTENDACE PAGE INITIATED");

var map = L.map("map", {
    zoomControl: false,
});
map.attributionControl.setPrefix(false);
// Using Openstreetmap tile layer
// https://tile.openstreetmap.org/{z}/{x}/{y}.png
// https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}
userTileLayer = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
    maxZoom: 19,
    // attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
// set the drawer menu element
targetDrawer = document.getElementById("drawer-attendance");
attendanceDrawer = new Drawer(
    targetDrawer,
    optionsDrawer,
    instanceOptionsDrawer
);
refreshLocationAttendace();
map._handlers.forEach(function (handler) {
    handler.disable();
});
// initFlowbite();

drawerSection = "";
videoStream = document.querySelector("#verify-camera");
videoStream.setAttribute("playsinline", "");
