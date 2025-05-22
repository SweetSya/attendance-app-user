console.log("HOME PAGE INITIATED");

var swiper = new Swiper("#swiper-actions", {
    slidesPerView: 2,
    spaceBetween: 15,
    breakpoints: {
        640: {
            slidesPerView: 3,
        },
        768: {
            slidesPerView: 4,
        },
    },
});
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

refreshLocationHome();
toggleMapInteractivity(false);