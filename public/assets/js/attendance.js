const geopt = {
    enableHighAccuracy: true,
    timeout: 5000,
    maximumAge: 0,
};
const getBase64Face = () => {
    const context = canvas.getContext("2d");
    context.drawImage(videoStream, 0, 0, canvas.width, canvas.height);
    const base64Image = canvas.toDataURL("image/png");
    return base64Image;
};
const refreshLocation = () => {
    navigator.geolocation.getCurrentPosition(
        (e) => {
            latlong = [e.coords.latitude, e.coords.longitude];

            if (userMarker != null) {
                map.removeLayer(userMarker);
            }
            if (userPolyline != null) {
                map.removeLayer(userPolyline);
            }
            // Create a new marker at the user's location
            userMarker = L.marker(latlong, {
                icon: userIcon,
            }).addTo(map);
            userPolyline = L.polyline([latlong, office], {
                color: "#30beff ",
            }).addTo(map);
            if (autoSnap) {
                let bounds = map.fitBounds([latlong, office], {
                    maxZoom: 15,
                });
            }
            distance = getDistance(latlong, office);
            if (officeMarker != null) {
                map.removeLayer(officeMarker);
            }
            if (distance <= officeRadius) {
                officeMarker = L.circle(office, {
                    color: "green",
                    fillColor: "#00ff61",
                    fillOpacity: 0.2,
                    radius: officeRadius,
                }).addTo(map);
            } else {
                officeMarker = L.circle(office, {
                    color: "red",
                    fillColor: "#f03",
                    fillOpacity: 0.2,
                    radius: officeRadius,
                }).addTo(map);
            }
            dispatchEvent(
                new CustomEvent("set_distance", {
                    detail: {
                        position: latlong,
                        range: distance,
                        refresh_at: new Date().toLocaleTimeString(),
                    },
                })
            );
        },
        (e) => {},
        geopt
    );
    setTimeout(() => {
        refreshLocation();
    }, 1500);
};
refreshLocation();
map._handlers.forEach(function (handler) {
    handler.disable();
});

// set the drawer menu element
const targetDrawer = document.getElementById("drawer-attendance");

// options with default values
const optionsDrawer = {
    placement: "bottom",
    backdrop: true,
    bodyScrolling: false,
    edge: false,
    edgeOffset: "",
    backdropClasses: "bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-30",
    onHide: () => {
        if (drawerSection === "checkin") {
            stopVideostream();
        }
        dispatchEvent(
            new CustomEvent("set_drawer", {
                detail: { title: "", section: "" },
            })
        );
    },
};

// instance options object
const instanceOptionsDrawer = {
    id: "drawer-attendance",
    override: true,
};

const attendanceDrawer = new Drawer(
    targetDrawer,
    optionsDrawer,
    instanceOptionsDrawer
);
const startVideostream = async () => {
    var constraints = {
        audio: false,
        video: {
            facingMode: facingMode,
        },
    };
    // Section checkin
    media = await checkMediaDevice(constraints);
    /* Stream it to video element */
    if (media.ok) {
        videoStream.srcObject = media.target;
        return "";
    } else {
        console.log(media.message);
        return "";
    }
};
const prepareCheckedIn = async () => {
    await startVideostream();
    dispatchEvent(
        new CustomEvent("set_face_scanning", {
            detail: {
                scanning: true,
            },
        })
    );
    setTimeout(() => {
        base64 = getBase64Face();
        dispatchEvent(
            new CustomEvent("start_check_face", {
                detail: {
                    face: base64,
                },
            })
        );
    }, 150);
};
const openDrawer = (option) => {
    dispatchEvent(
        new CustomEvent("set_drawer", {
            detail: option,
        })
    );
    if (drawerSection === "checkin") {
        prepareCheckedIn();
    }
    attendanceDrawer.show();
};
const closeDrawer = async (time) => {
    setTimeout(() => {
        attendanceDrawer.hide();
    }, time);
};
const stopVideostream = () => {
    setTimeout(() => {
        if (isVideoStreamActive()) {
            try {
                const stream = videoStream.srcObject;
                const tracks = stream.getTracks();

                tracks.forEach((track) => {
                    track.stop();
                });

                videoStream.srcObject = null;
            } catch (error) {
                stopVideostream();
                return;
            }
        }
    }, 200);
};
const isVideoStreamActive = () => {
    if (videoStream.srcObject != null) {
        return true;
    } else {
        return false;
    }
};
document.addEventListener("visibilitychange", () => {
    if (drawerSection === "checkin") {
        if (document.hidden) {
            if (isVideoStreamActive()) {
                stopVideostream();
            }
        }
        if (!document.hidden) {
            if (!isVideoStreamActive()) {
                startVideostream();
            }
        }
    }
});

window.addEventListener("load", () => {
    window.scrollTo(0, document.body.scrollHeight);
});
