<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/reports.css">
    <title>Reports</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="admin_data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header.php'; ?>

        <!-- REAL DATA AREA -->

        <!-- admin real data top -->
        <div class="admin__data__area--top">
            <div class="admin__data__area__top--title">Reports</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="View Archieved" onclick="location.href='<?php echo URLROOT;?>/owners/archivedReportsControl'">
                </div>
    <form action="<?php echo URLROOT;?>/owners/archiveReports" method="POST" id="userInterface">
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
                    <th style="width: 5%;">User ID</th>
                    <th style="width: 5%;">Status</th>
                    <th style="width: 10%;">Title</th>
                    <th style="width: 8%;">Mechanic ID</th>
                    <th style="width: 13%;">Date/Time</th>
                    <th style="width: 10%;">Type</th>
                    <!-- <th style="width: 4%;">Log ID</th> -->
                    <th style="width: 4%;"></th>

                </tr>

                <!-- sample template data -->
                <!-- <tr>
                    <td><input type="checkbox" class="cbox"></td>
                    <td>3711643</td>
                    <td>24021</td>
                    <td>Inactive</td>
                    <td>Flat Tyre</td>
                    <td>M5322</td>
                    <td>2023.03.24</td>
                    <td>Complaint</td>
                    <td>M23098</td>
                    <td> -->
                        <!-- update icon svg format -->
                        <!-- <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="17" cy="17" r="17" fill="black"/>
                            <path d="M19.06 14L20 14.94L10.92 24H10V23.08L19.06 14ZM22.66 8C22.41 8 22.15 8.1 21.96 8.29L20.13 10.12L23.88 13.87L25.71 12.04C26.1 11.65 26.1 11 25.71 10.63L23.37 8.29C23.17 8.09 22.92 8 22.66 8ZM19.06 11.19L8 22.25V26H11.75L22.81 14.94L19.06 11.19Z" fill="white"/>
                        </svg>
                            
                    </td>
                </tr> -->

                <?php foreach($data['report_details'] as $oneReport) : if($oneReport->reportType == "Bicycle"){?>
                    <tr>
                        <td><input type="checkbox" name="selected[]" value="<?php echo $oneReport->reportID ?>"></td>
                        <td><?php echo $oneReport->reportID ?></td>
                        <td><?php echo $oneReport->reporterID ?></td>
                        <td><?php
                                    if ($oneReport->status == 0) {
                                        echo "Active";
                                    } elseif ($oneReport->status == 1) {
                                        echo "Inactive";
                                    }
                                ?>
                        </td>
                        <td><?php echo $oneReport->problemTitle ?></td>
                        <td><?php echo $oneReport->assignedMechanic ? $oneReport->assignedMechanic : "Null" ?></td>
                        <td><?php echo $oneReport->loggedTimestamp ?></td>
                        <td><?php echo $oneReport->reportType ?></td>
                        <td>
                            <a href="<?php echo URLROOT;?>/owners/editReportDetails?reportID=<?php echo $oneReport->reportID;?>"><img src="<?php echo URLROOT;?>/public/images/owners/editIconsViewIcons/editIcon1.png" alt="edit"></a>
                        </td>
                    </tr>
                <?php } endforeach; ?>

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