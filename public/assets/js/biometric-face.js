import vision from "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.3";
const { FaceLandmarker, FilesetResolver, DrawingUtils } = vision;

let faceLandmarker;
let runningMode = "IMAGE";
let webcamRunning = false;
const videoWidth = 320;

const videoBlendShapes = document.getElementById("video-blend-shapes");
const video = document.getElementById("webcam");
const canvasElement = document.getElementById("output_canvas");
const canvasCtx = canvasElement.getContext("2d");
const drawingUtils = new DrawingUtils(canvasCtx);
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

async function predictWebcam() {
    const aspectRatio = video.videoHeight / video.videoWidth;
    video.style.width = videoWidth + "px";
    video.style.height = videoWidth * aspectRatio + "px";
    canvasElement.style.width = videoWidth + "px";
    canvasElement.style.height = videoWidth * aspectRatio + "px";
    canvasElement.width = video.videoWidth;
    canvasElement.height = video.videoHeight;

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

    drawBlendShapes(videoBlendShapes, results.faceBlendshapes);

    if (webcamRunning) {
        window.requestAnimationFrame(predictWebcam);
        if (firstLaunch) {
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

function drawBlendShapes(el, blendShapes) {
    if (!blendShapes.length) return;

    const categories = blendShapes[0].categories;
    let html = "";

    categories.forEach((shape) => {
        const name = shape.displayName || shape.categoryName;
        const score = shape.score;
        html += `
      <li class="blend-shapes-item">
        <span class="blend-shapes-label">${name}</span>
        <span class="blend-shapes-value" style="width: calc(${
            score * 100
        }% - 120px)">${score.toFixed(4)}</span>
      </li>
    `;

        if (name === "eyeBlinkLeft" && score > 0.4) {
            console.log("Left eye blink");
        }
        if (name === "eyeBlinkRight" && score > 0.6) {
            console.log("Right eye blink");
        }
    });

    el.innerHTML = html;
}

async function requestUserCamera() {
    if (!faceLandmarker) return alert("Terjadi kesalahan pada Landmarker");
    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: {
                facingMode: "user",
            },
        });
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
