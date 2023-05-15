<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/reports.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Accident Reports</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar-admin.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="admin_data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header-admin.php'; ?>

        <!-- REAL DATA AREA -->

        <!-- admin real data top -->
        <div class="admin__data__area--top">
            <div class="admin__data__area__top--title">Accident Reports</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add Report" onclick="location.href='<?php echo URLROOT;?>/admins/addReport'">
                </div>
                
                <form action="<?php echo URLROOT;?>/admins/archiveReports" method="POST" id="userInterface">
                <div class="delete_user_button">
                    <input type="submit" class="btn btn_delete" value="Archive Selected">
                </div>
            </div>

        </div>

        <div class="admin__table__area">
            <table>
                <tr>
                    <th style="width: 3%;"></th>
                    <th style="width: 5%;">Report ID</th>
                    <th style="width: 6%;">Reporter ID</th>
                    <th style="width: 5%;">Status</th>
                    <th style="width: 10%;">Problem Title</th>
                    <th style="width: 20%;">Problem Description</th>
                    <th style="width: 8%;">Logged Time</th>
                    <th style="width: 7%;">Assigned Mechanic</th>
                    <th style="width: 7%;">Accident Location</th>
                    <th style="width: 5%;">Accident Time</th>
                    <th style="width: 5%;">Bicycle ID</th>
                    <th style="width: 5%;"></th>

                    <?php foreach($data['report_details'] as $oneObject) : if($oneObject->reportType == "Accident"){?>
                    <tr>
                        <td><input type="checkbox" name="selected[]" value="<?php echo $oneObject->reportID ?>"></td>
                        <td><?php echo $oneObject->reportID ?></td>
                        <td><?php echo $oneObject->reporterID ?></td>
                        <td>
                            <?php 
                                if($oneObject->status == 0){
                                    echo "Active";
                                }else{
                                    echo "Resolved";
                                }
                            
                            ?>
                        </td>
                        <td><?php echo printValue($oneObject, 'problemTitle')?></td>
                        <td><?php echo printValue($oneObject, 'problemDescription') ?></td>
                        <td><?php echo printValue($oneObject, 'loggedTimestamp') ?></td>
                        <td><?php if($oneObject->assignedMechanic){
                                foreach($data['mechanicName_details'] as $oneUserDetail) {
                                    if($oneUserDetail->userID == $oneObject->assignedMechanic) {
                                        echo $oneUserDetail->firstName;
                                    }
                                }
                            }else{echo "-";} ?></td>
                        <td><?php echo printValue($oneObject, 'accidentLat') ?><br><?php echo printValue($oneObject, 'accidentLong') ?></td>
                        <td><?php echo printValue($oneObject, 'accidentTimeApprox') ?></td>
                        <td><?php echo printValue($oneObject, 'bicycleID') ?></td>
                        <td>
                        <!-- update icon svg format -->
                        <a href="<?php echo URLROOT;?>/admins/editReportDetails?reportID=<?php echo $oneObject->reportID;?>"><img src="<?php echo URLROOT;?>/public/images/admins/editIcon1.png" alt="edit"></a>
                    </tr>
                <?php } endforeach; 
                    function printValue($oneObject, $column_name){
                        if($oneObject->$column_name != null){
                            echo $oneObject->$column_name;
                        }else{
                            echo "-";
                        }
                    }
                ?>

            </table>
            </form>
        </div>
    </section>

    <script>
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // prevent the form from submitting

        // get all the checkboxes in the table
        const checkboxes = document.querySelectorAll('table input[type="checkbox"]');

        // collect the values of the checked checkboxes
        const selectedRows = [];
        checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            selectedRows.push(checkbox.value);
        }
        });

        // add the selected rows to a hidden input field in the form
        const input = document.createElement('input');
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', 'selectedRows');
        input.setAttribute('value', JSON.stringify(selectedRows));
        this.appendChild(input);

        // submit the form
        this.submit();
    });
    </script>

</body>
</html>