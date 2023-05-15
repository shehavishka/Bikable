<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/riders/createReport.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Create Report</title>
    <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
</head>
<body>
<?php require APPROOT . '/views/inc/header-mechanic.php'; ?>

    <div id="container">
        <div id="upper_section">
            <div class="title" id="title">Make a Report</div>
        </div>         
        
        <form action="<?php echo URLROOT;?>/riders/createRep" method="POST" id="create_form">
            <div class="middle_section">
            <div class ="info" id="info_reportID">
                    <div class="main_text">Report ID</div>
                        <input type="text" name="reportID" class="sub_text2" placeholder="Report ID" value="<?php echo $data['reportID'];?>">
                        <span class="error_text"><?php echo $data['reportID_err'];?></span>
                    </div>
                    <div class="info" id="info_title">
                        <div class="main_text">Title</div>
                        <input type="text" name="problemTitle" id="problemTitle" class="sub_text" placeholder="Type here" value="<?php echo $data['problemTitle'];?>">
                        <span class="error_text"><?php echo $data['problemTitle_Err'];?></span>
                    </div>
                    <div class="info" id="info_description">
                        <div class="main_text">Description</div>
                        <textarea name="problemDescription" id="problemDescription" cols="30" rows="10" class="para_text" placeholder="Type here"><?php echo $data['problemDescription'];?></textarea>
                        <span class="error_text"><?php echo $data['problemDescription_Err'];?></span>
                    </div>
                    <div class="info" id="info_area">
                        <div class="main_text">Docking Area Name</div>
                        <!-- a drop down with selections being from the $data['mapDetails']->areaName value and value being the $data['mapDetails']->areaID -->
                        <select name="areaID" id="areaID" class="sub_text">
                            <option value="0" <?php if(empty($data['areaID'])) echo 'selected'; ?> hidden>Choose here</option>
                            <?php foreach($data['mapDetails'] as $mapDetail): ?>
                                <option value="<?php echo $mapDetail->areaID; ?>" <?php if($data['areaID'] == $mapDetail->areaID) echo 'selected'; ?>><?php echo $mapDetail->areaName; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="error_text"><?php echo $data['areaID_Err'];?></span>
                    </div>

                    <div class="data__area__detail--month">
                    <div class="data__area__div data--dateIn">
                        <div class="date_time" id="info_dateTime">
                        <div class="info">
                            <div class="main_text">Date In</div>
                                <input type="date" name="dateIn" id="date" class="sub_text1" value="<?php 
                                    if(!$data['dateIn']):
                                            $month = date('m');
                                            $day = date('d');
                                            $year = date('Y');
                                            $today = $year . '-' . $month . '-' . $day;
                                            echo $today;
                                    else: echo $data['dateIn'];
                                    endif?>">
                                <span class="error_text"><?php echo $data['dateIn_err'];?></span>
                                </div>
                            </div>
                            <div class="data__area__div data--dateOut">
                            <div class="main_text">Date Out</div>
                                    <input type="date" name="dateOut" id="date" class="sub_text1" value="<?php 
                                        if(!$data['dateOut']):
                                                $month = date('m');
                                                $day = date('d');
                                                $year = date('Y');
                                                $today = $year . '-' . $month . '-' . $day;
                                                echo $today;
                                        else: echo $data['dateIn'];
                                        endif?>">
                                    <span class="error_text"><?php echo $data['dateOut_err'];?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info" id="info_location">
                        <div class="main_text">Accident Location</div>
                        <input type="text" name="accidentLocation" id="accidentLocation" class="sub_text" placeholder="Type here" value="<?php echo $data['accidentLocation'];?>">
                        <span class="error_text"><?php echo $data['accidentLocation_Err'];?></span>
                    </div>
                    <div class="date_time" id="info_dateTime">
                        <div class="info">
                            <div class="main_text">Date</div>
                            <input type="date" name="date" id="date" class="sub_text1" value="<?php 
                                if(!$data['date']):
                                    $month = date('m');
                                    $day = date('d');
                                    $year = date('Y');
                                    $today = $year . '-' . $month . '-' . $day;
                                    echo $today;
                                else: echo $data['date'];
                                endif?>">
                            <span class="error_text"><?php echo $data['date_Err'];?></span>
                        </div>
                        <div class="info">
                            <div class="main_text">Estimated Cost</div>
                            <input type="text" name="estCost" class="sub_text1" placeholder="Estimated Cost" value="<?php echo $data['estCost'];?>">
                            <span class="error_text"><?php echo $data['estCost_err'];?></span>
                        </div>
                        <div class="info">
                            <div class="main_text">Final Cost</div>
                            <input type="text" name="finalCost" class="sub_text3" placeholder="Final Cost" value="<?php echo $data['finalCost'];?>">
                            <span class="error_text"><?php echo $data['finalCost_err'];?></span>
                        </div>
                        <div class="info">
                        <div class="main_text">Repair Notes</div>
                            <textarea name="repairNotes" id="repairNotes" cols="30" rows="10" class="para_text" placeholder="Type here"><?php echo $data['repairNotes'];?></textarea>
                            <span class="error_text"><?php echo $data['repairNotes_err'];?></span>
                        </div>
                        </div>
                    </div>
                    <div class="info" id="info_bicycleID">
                        <div class="main_text">Bicycle</div>
                        <!-- qr code scanning camera view -->
                        <!-- <div id="a"><canvas hidden="" id="qr-canvas"></canvas></div> -->

                        <input type="hidden" name="bicycleID" id="bicycleID" value="<?php if(empty($data['bicycleID'])) echo 0; else echo $data['bicycleID']; ?>">
                        <div class="sub_text" id="scan_btn"><div id="message"><?php if(empty($data['bicycleID'])) echo 'Scan'; else echo 'Scan completed'; ?></div><img src="<?php echo URLROOT;?>/public/images/general/scanIconB.png" alt="scan"></div>
                        <span class="error_text"><?php echo $data['bicycleID_Err'];?></span>
                        
                    </div>
                    <!-- <div class="info">
                        <div class="main_text">Upload an Image</div>
                        <input type="file" name="image" id="image" class="sub_text" value="test">
                        <span class="error_text"><?php echo $data['image_Err'];?></span>
                    </div> -->
            </div>
        

        <div id="lower_section">
            <input type="submit" class="create_btn" value="Create" >
            
            </form>
            <a href="<?php echo URLROOT;?>/riders/viewReports"><div class="cancel_btn">Cancel</div></a>
        </div> 

    </div>

    <script>
        showFields();

        // function showFields(){
        //     var type = document.getElementById("type");
        //     var typeValue = type.options[type.selectedIndex].value;
        //     if(typeValue == "Other"){
        //         document.getElementById("info_area").style.display = "none";
        //         document.getElementById("info_location").style.display = "none";
        //         document.getElementById("info_dateTime").style.display = "none";
        //         document.getElementById("info_bicycleID").style.display = "none";
        //     }
        //     else if(typeValue == "Accident"){
        //         document.getElementById("info_area").style.display = "none";
        //         document.getElementById("info_location").style.display = "flex";
        //         document.getElementById("info_dateTime").style.display = "flex";
        //         document.getElementById("info_bicycleID").style.display = "flex";
        //     }else if(typeValue == "Bicycle"){
        //         document.getElementById("info_area").style.display = "none";
        //         document.getElementById("info_location").style.display = "none";
        //         document.getElementById("info_dateTime").style.display = "none";
        //         document.getElementById("info_bicycleID").style.display = "flex";
        //     }else if(typeValue == "Area"){
        //         document.getElementById("info_area").style.display = "flex";
        //         document.getElementById("info_location").style.display = "none";
        //         document.getElementById("info_dateTime").style.display = "none";
        //         document.getElementById("info_bicycleID").style.display = "none";
        //     }else{
        //         document.getElementById("info_area").style.display = "none";
        //         document.getElementById("info_location").style.display = "none";
        //         document.getElementById("info_dateTime").style.display = "none";
        //         document.getElementById("info_bicycleID").style.display = "none";
        //     }
        // }
        
        
        const bicycle_ID = document.getElementById("bicycleID");
        const video = document.createElement("video");
        const canvasElement = document.getElementById("qr-canvas");
        const canvas = canvasElement.getContext("2d");

        const message = document.getElementById("message");
        //const outputData = document.getElementById("outputData");
        const btnScanQR = document.getElementById("scan_btn");

        let scanning = false;

        qrcode.callback = res => {
        if (res) {
            //outputData.innerText = res;
            //outputData2.href = res;
            // start_form.action = start_form.action+'/'+res;
            bicycle_ID.value = res;
            message.innerText = "Scan completed";

            scanning = false;

            video.srcObject.getTracks().forEach(track => {
            track.stop();
            });

            // qrResult.hidden = false;
            canvasElement.hidden = true;
            btnScanQR.hidden = false;
            a.style.visibility = "hidden";
            // b.style.visibility = "visible";
            
        }
        };

        btnScanQR.onclick = () => {
        navigator.mediaDevices
            .getUserMedia({ video: { facingMode: "environment" } })
            .then(function(stream) {
            scanning = true;
            // qrResult.hidden = true;
            // btnScanQR.hidden = true;
            canvasElement.hidden = false;
            a.style.visibility = "visible";
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