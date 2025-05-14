import vision from "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.3";
const { FaceLandmarker, FilesetResolver, DrawingUtils } = vision;

let faceLandmarker;
let runningMode = "IMAGE";
let webcamRunning = false;

const video = document.getElementById("webcam");
const elemPitch = document.getElementById("pitch");
const elemYaw = document.getElementById("yaw");
const videoWrapper = document.querySelector("#webcam-wrapper");
const canvasElement = document.getElementById("output_canvas");
const canvasCtx = canvasElement.getContext("2d");
const drawingUtils = new DrawingUtils(canvasCtx);

const resizeCapturer = () => {
    const aspectRatio = video.videoHeight / video.videoWidth;
    video.style.width = videoWrapper.clientWidth + "px";
    video.style.height = videoWrapper.clientWidth * aspectRatio + "px";
    canvasElement.style.width = videoWrapper.clientWidth + "px";
    canvasElement.style.height = videoWrapper.clientWidth * aspectRatio + "px";
    canvasElement.width = videoWrapper.clientWidth;
    canvasElement.height = videoWrapper.clientHeight;
};
let capturedFrame = {
    "netral-netral": "",
    "top-netral": "",
    "top-right": "",
    "netral-right": "",
    "bottom-right": "",
    "bottom-netral": "",
    "bottom-left": "",
    "netral-left": "",
    "top-left": "",
};

dispatchEvent(
    new CustomEvent("set_camera_capture", {
        detail: {
            images: capturedFrame,
        },
    })
);

let firstLaunch = true;

async function createFaceLandmarker() {
    const filesetResolver = await FilesetResolver.forVisionTasks(
        "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.3/wasm"
    );
    faceLandmarker = await FaceLandmarker.createFromOptions(filesetResolver, {
        baseOptions: {
            modelAssetPath:
                "https://storage.googleapis.com/mediapipe-models/face_landmarker/face_landmarker/float16/1/face_landmarker.task",
            delegate: "GPU",
        },
        outputFaceBlendshapes: true,
        runningMode,
        numFaces: 1,
    });
}
createFaceLandmarker();

let lastVideoTime = -1;
let results = undefined;

function captureFrame(videoElement) {
    const canvas = document.createElement("canvas");
    canvas.width = videoElement.videoWidth;
    canvas.height = videoElement.videoHeight;

    const ctx = canvas.getContext("2d");
    ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);

    // This is base64 string: "data:image/png;base64,AAAA..."
    return canvas.toDataURL("image/png");
}

async function predictWebcam() {
    resizeCapturer();
    if (runningMode === "IMAGE") {
        runningMode = "VIDEO";
        await faceLandmarker.setOptions({ runningMode });
    }

    let startTimeMs = performance.now();
    if (lastVideoTime !== video.currentTime) {
        lastVideoTime = video.currentTime;
        results = faceLandmarker.detectForVideo(video, startTimeMs);
    }

    canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
    if (results.faceLandmarks) {
        if (results.faceLandmarks.length > 0) {
            const landmarks = results.faceLandmarks[0];

            const leftCheek = landmarks[234]; // Titik pipi kiri
            const rightCheek = landmarks[454]; // Titik pipi kanan
            const noseTip = landmarks[1];
            const chin = landmarks[152];
            const faceWidth = Math.hypot(
                rightCheek.x - leftCheek.x,
                rightCheek.y - leftCheek.y
            );
            const noseCenterX = (rightCheek.x + leftCheek.x) / 2;
            // Normalize offsets by face width
            const yaw = (noseTip.x - noseCenterX) / faceWidth;
            const pitch = (chin.y - noseTip.y) / faceWidth;

            let direction = {
                x: "",
                y: "",
            };
            elemPitch.innerHTML = pitch.toFixed(4);
            elemYaw.innerHTML = yaw.toFixed(4);
            // console.log(`PITCH: ${pitch.toFixed(4)}`);
            // console.log(`YAW: ${yaw.toFixed(4)}`);
            // Check direction Y
            if (pitch > 0.49) {
                direction.y = "top";
            } else if (pitch < 0.4) {
                direction.y = "bottom";
            } else {
                direction.y = "netral";
            }
            // Check direction X
            if (yaw > 0.21) {
                direction.x = "left";
            } else if (yaw < -0.31) {
                direction.x = "right";
            } else {
                direction.x = "netral";
            }
            let currentDirection = `${direction.y}-${direction.x}`;
            // Capture for each frame
            if (capturedFrame[currentDirection] == "") {
                capturedFrame[currentDirection] = captureFrame(video);
                dispatchEvent(
                    new CustomEvent("set_camera_capture_one", {
                        detail: {
                            position: currentDirection,
                            image: capturedFrame[currentDirection],
                        },
                    })
                );
                console.log(`Menghadap: ${currentDirection}`);
                console.log("======================================");
            }
        }

        for (const landmarks of results.faceLandmarks) {
            drawingUtils.drawConnectors(
                landmarks,
                FaceLandmarker.FACE_LANDMARKS_TESSELATION,
                { color: "#C0C0C070", lineWidth: 1 }
            );
            drawingUtils.drawConnectors(
                landmarks,
                FaceLandmarker.FACE_LANDMARKS_RIGHT_EYE,
                { color: "#FF3030" }
            );
            drawingUtils.drawConnectors(
                landmarks,
                FaceLandmarker.FACE_LANDMARKS_LEFT_EYE,
                { color: "#30FF30" }
            );
        }
    }

    drawBlendShapes(results.faceBlendshapes);

    if (webcamRunning) {
        window.requestAnimationFrame(predictWebcam);
        if (firstLaunch) {
            canvasElement.classList.remove("hidden");
            dispatchEvent(
                new CustomEvent("set_camera_status", {
                    detail: {
                        status: "running",
                    },
                })
            );
            firstLaunch = false;
        }
    }
}
let wasBlinking = false;
function drawBlendShapes(blendShapes) {
    if (!blendShapes.length) return;

    const categories = blendShapes[0].categories;
    let html = "";
    let blink = {
        left: false,
        right: false,
    };
    categories.forEach((shape) => {
        const name = shape.displayName || shape.categoryName;
        const score = shape.score;

        if (name === "eyeBlinkLeft" && score > 0.4) {
            blink.left = true;
        }
        if (name === "eyeBlinkRight" && score > 0.6) {
            blink.right = true;
        }
        if (blink.right && blink.left && !wasBlinking) {
            wasBlinking = true;
            const allFilled = Object.values(capturedFrame).every(
                (value) => value !== ""
            );
            if (allFilled) {
                if (video.srcObject) {
                    video.removeEventListener("loadeddata", predictWebcam);
                    console.log("STOP VIDEO");
                    video.srcObject
                        .getTracks()
                        .forEach((track) => track.stop());
                    video.srcObject = null;
                    // Normalize everything soo it can run for the next scan if needed
                    dispatchEvent(
                        new CustomEvent("set_camera_status", {
                            detail: {
                                status: "offline",
                            },
                        })
                    );
                    sendNotfy.success("Berhasil menangkap muka");
                    canvasElement.classList.add("hidden");
                    firstLaunch = true;
                    webcamRunning = false;
                    runningMode = "IMAGE";
                }
                console.log(capturedFrame);
            } else {
                wasBlinking = false;
            }
        }
    });
}

async function requestUserCamera() {
    if (!faceLandmarker) return alert("Terjadi kesalahan pada Landmarker");
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: "user",
            },
        });
        capturedFrame = {
            "netral-netral": "",
            "top-netral": "",
            "top-right": "",
            "netral-right": "",
            "bottom-right": "",
            "bottom-netral": "",
            "bottom-left": "",
            "netral-left": "",
            "top-left": "",
        };
        wasBlinking = false;
        video.srcObject = stream;
        webcamRunning = true;
        video.addEventListener("loadeddata", predictWebcam);
        return {
            status: "preparing",
            message: "Mempersiapkan kamera",
        };
    } catch (error) {
        const errString = error.toString();
        if (errString.includes("dismissed")) {
            return {
                status: "error",
                message:
                    "Harap izinkan aplikasi untuk mengakses perangkat kamera",
            };
        } else if (errString.includes("denied")) {
            return {
                status: "error",
                message:
                    "Izin akses kamera terblokir, harap izinkan terlebih dahulu",
            };
        } else {
            return {
                status: "error",
                message:
                    "Terjadi kesalahan saat mengakses kamera: " + errString,
            };
        }
    }
}

window.requestUserCamera = requestUserCamera;

window.captureFrame = captureFrame;
