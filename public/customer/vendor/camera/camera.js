
// Set constraints for the video stream
var constraints = { video: { facingMode: "environment" }, audio: false };
var image_type = 0; // 0: avatar, 1: event

// Define constants
const cameraView = document.querySelector("#camera--view"),
    cameraOutput = document.querySelector("#camera--output"),
    cameraSensor = document.querySelector("#camera--sensor"),
    cameraTrigger = document.querySelector("#camera--trigger");

// Access the device camera and stream to cameraView
function cameraStart(img_type) {
    image_type = img_type;  // avatar image or event image

    navigator.mediaDevices
        .getUserMedia(constraints)
        .then(function(stream) {
            track = stream.getTracks()[0];
            cameraView.srcObject = stream;
            $('#cameraDialog').modal('show');
        })
        .catch(function(error) {
            alert('Could not access the camera');
        });
}

// Take a picture when cameraTrigger is tapped
cameraTrigger.onclick = function() {

    cameraSensor.width = cameraView.videoWidth;
    cameraSensor.height = cameraView.videoHeight;
    cameraSensor.getContext("2d").drawImage(cameraView, 0, 0);

    cameraOutput.src = cameraSensor.toDataURL("image/webp");
    cameraOutput.classList.add("taken");

    selectCameraPhoto(cameraSensor.toDataURL("image/webp"), image_type);
    $('#cameraDialog').modal('hide');
};
