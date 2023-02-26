<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/riders/scanQR.css">
    <title>QR Code Scanner</title>
    <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
</head>
<body>
    <div id="container">
        <div id="upper_section">
            <div id="cancel_button">
                <a href="<?php echo URLROOT;?>/riders/riderLandPage"><img src="<?php echo URLROOT;?>/public/images/general/crossIcon1.png" alt="cancel"></a>
            </div>
            <div id="main_text">
                <h1>Scan to ride</h1>
                <div id="sub_text">
                    Locate the QR code on the bike
                </div>
            </div>
        </div> 
        
        <div class="middle_section">
            <div class="btn-scan-qr">
                <a id="btn-scan-qr">
                    <img src="<?php echo URLROOT;?>/public/images/general/scanIcon.png">
                </a>
            </div>
            
            <!-- <div class="middle_section btn-scan-qr qr-canvas">
                <canvas hidden="" id="btn-scan-qr qr-canvas"></canvas>
            </div>
                
            <div id="qr-result" hidden="">
                <b>Data:</b> <span id="outputData"></span>
            </div> -->
            <div class="middle_section a">
                <canvas hidden="" id="qr-canvas"></canvas>
            </div>

            <div class="middle_section b">
                <div id="qr-result" hidden="">
                    <b>Data:</b> <span id="outputData"></span>
                </div>
            </div>

        </div>

    </div>

    <script>
        //var qrcode = window.qrcode;

        const video = document.createElement("video");
        const canvasElement = document.getElementById("qr-canvas");
        const canvas = canvasElement.getContext("2d");

        const qrResult = document.getElementById("qr-result");
        const outputData = document.getElementById("outputData");
        const btnScanQR = document.getElementById("btn-scan-qr");

        let scanning = false;

        qrcode.callback = res => {
        if (res) {
            outputData.innerText = res;
            scanning = false;

            video.srcObject.getTracks().forEach(track => {
            track.stop();
            });

            qrResult.hidden = false;
            canvasElement.hidden = true;
            btnScanQR.hidden = false;
        }
        };

        btnScanQR.onclick = () => {
        navigator.mediaDevices
            .getUserMedia({ video: { facingMode: "environment" } })
            .then(function(stream) {
            scanning = true;
            qrResult.hidden = true;
            btnScanQR.hidden = true;
            canvasElement.hidden = false;
            video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
            video.srcObject = stream;
            video.play();
            tick();
            scan();
            });
        };

        function tick() {
        canvasElement.height = video.videoHeight;
        canvasElement.width = video.videoWidth;
        canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);

        scanning && requestAnimationFrame(tick);
        }

        function scan() {
        try {
            qrcode.decode();
        } catch (e) {
            setTimeout(scan, 300);
        }
        }
    </script>
</body>
</html>