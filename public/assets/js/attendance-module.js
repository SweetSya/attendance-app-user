import vision from "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.3";
const { FaceLandmarker, FilesetResolver, DrawingUtils } = vision;

let attendanceFaceLandmarker;
let attendanceRunningMode;
let attendanceVideo;
let attendanceAnimationFrameFace = null;
let attendanceLastVideoTime;
let attendanceWebcamRunning;
let attendanceResults;
let attendanceWasBlinking;

const attendanceFilesetResolver = await FilesetResolver.forVisionTasks(
    "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.3/wasm"
);

async function attendanceCreateFaceLandmarker() {
    console.log("attendanceCreateFaceLandmarker");
    attendanceFaceLandmarker = await FaceLandmarker.createFromOptions(
        attendanceFilesetResolver,
        {
            baseOptions: {
                modelAssetPath:
                    "https://storage.googleapis.com/mediapipe-models/face_landmarker/face_landmarker/float16/1/face_landmarker.task",
                delegate: "GPU",
            },
            outputFaceBlendshapes: true,
            runningMode: attendanceRunningMode,
            numFaces: 1,
        }
    );
    dispatchEvent(
        new CustomEvent("set_landmarker", {
            detail: {
                state: true,
            },
        })
    );
}

async function attendancePredictWebcam() {
    console.log("attendancePredictWebcam");
    if (attendanceRunningMode === "IMAGE") {
        attendanceRunningMode = "VIDEO";
        await attendanceFaceLandmarker.setOptions({
            runningMode: attendanceRunningMode,
        });
    }

    let startTimeMs = performance.now();
    if (attendanceLastVideoTime !== attendanceVideo.currentTime) {
        attendanceLastVideoTime = attendanceVideo.currentTime;
        attendanceResults = attendanceFaceLandmarker.detectForVideo(
            attendanceVideo,
            startTimeMs
        );
    }
    attendanceDetectBlinking(attendanceResults.faceBlendshapes);
    if (attendanceWebcamRunning) {
        setTimeout(() => {
            attendanceAnimationFrameFace = window.requestAnimationFrame(
                attendancePredictWebcam
            );
        }, 300);
    }
}

function attendanceDetectBlinking(blendShapes) {
    if (!blendShapes.length) return;

    const categories = blendShapes[0].categories;
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
        if (blink.right && blink.left && !attendanceWasBlinking) {
            console.log("Blink Detected");
            attendanceWasBlinking = true;
        }
    });
}

const attendanceInitBiometricFace = () => {
    console.log("attendanceInitBiometricFace");
    attendanceWebcamRunning = true;
    if (!attendanceFaceLandmarker)
        return alert("Terjadi kesalahan pada Landmarker");
    attendanceVideo = document.getElementById("verify-camera");
    if (attendanceVideo) {
        attendanceVideo.addEventListener("loadeddata", attendancePredictWebcam);
    }
    attendanceRunningMode = "IMAGE";
    attendanceAnimationFrameFace = null;
    attendanceLastVideoTime = -1;
    attendanceWasBlinking = false;
};

const attendanceRemoveAnimationFrame = () => {
    // stop video stream
    stopVideostream();
    dispatchEvent(
        new CustomEvent("set_landmarker", {
            detail: {
                state: false,
            },
        })
    );
    attendanceVideo.removeEventListener("loadeddata", attendancePredictWebcam);
    cancelAnimationFrame(attendanceAnimationFrameFace);
    attendanceAnimationFrameFace = null;
    console.log("Attendance Animation Frame Removed");
};

const attendanceIsBlinking = () => {
    return attendanceWasBlinking;
};
window.attendanceRemoveAnimationFrame = attendanceRemoveAnimationFrame;
window.attendanceInitAttendaceBiometricFace = attendanceInitBiometricFace;
window.attendanceCreateFaceLandmarker = attendanceCreateFaceLandmarker;
window.attendanceIsBlinking = attendanceIsBlinking;
