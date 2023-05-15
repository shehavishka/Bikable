<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/mechanics/dockingareas.css">
    <title>Docking Areas</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require 'sidebar-mechanic.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="admin_data_area">

        <!-- dashboard section -->
        <?php require 'header.php'; ?>

        <!-- REAL DATA AREA -->

        <!-- admin real data top -->
        <div class="admin__data__area--top">
            <div class="admin__data__area__top--title">Docking Areas</div>
            <div class="admin__data_area__top--twobuttons">
                <!-- <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add Area" onclick="location.href='<?php echo URLROOT;?>/admins/addDA'">
                </div>

                <form action="<?php echo URLROOT;?>/admins/deleteDAs" method="POST" id="userInterface">
                <div class="delete_user_button">
                    <input type="submit" class="btn btn_delete" value="Delete Selected">
                </div> -->
            </div>

        </div>

        <div class="admin__table__area">
            <table>
                <tr>
                    <th style="width: 3%;"></th>
                    <th style="width: 7%;">Area ID</th>
                    <th style="width: 12%;">Area Name</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 20%;">Address</th>
                    <th style="width: 7%;">Radius</th>
                    <th style="width: 7%;">Current Bikes</th>
                    <th style="width: 5%;"></th>

                </tr>
        

                <?php foreach($data['DA_Details'] as $oneObject) : ?>
                    <tr>
                    <td><input type="hidden" name="selected[]" value="<?php echo $oneObject->areaID;?>"></td>
                        <td><?php echo $oneObject->areaID ?></td>
                        <td><?php echo $oneObject->areaName ?></td>
                        <td>
                            <?php 
                                if($oneObject->status == 0){
                                    echo "Active";
                                }else{
                                    echo "Inactive";
                                }
                            
                            ?>
                        </td>
                        <td><?php echo $oneObject->traditionalAdd ?></td>
                        <td><?php echo $oneObject->locationRadius ?></td>
                        <td><?php echo $oneObject->currentNoOfBikes ?></td>
                        <td>
                        <!-- update icon svg format -->
                        <a href="<?php echo URLROOT;?>/mechanics/viewDockingAreas?areaID=<?php echo $oneObject->areaID;?>"><img src="<?php echo URLROOT;?>/public/images/mechanics/viewIcon1.png" alt="view"></a>
                    </tr>
                <?php endforeach; ?>

            </table>
            </form>
        </div>
    </section>

    <!-- <script>
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
    </script> -->

</body>
</html>