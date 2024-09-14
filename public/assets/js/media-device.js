const checkMediaDevice = async (constraints) => {
    value = { ok: false, message: "No message", target: null };
    await navigator.mediaDevices
        .getUserMedia(constraints)
        .then((media) => {
            value.ok = true;
            value.message = "Media siap digunakan";
            value.target = media
            return;
        })
        .catch((e) => {
            var message;
            switch (e.name) {
                case "NotFoundError":
                case "DevicesNotFoundError":
                    message = "Please setup your webcam first.";
                    break;
                case "SourceUnavailableError":
                    message = "Your webcam is busy";
                    break;
                case "PermissionDeniedError":
                case "NotAllowedError":
                case "SecurityError":
                    message = "Permission denied!";
                    break;
                default:
                    message = "Cannot resolve!";
                    return;
            }
            value.ok = false;
            value.message = message;
            return;
        });
    return value;
};
