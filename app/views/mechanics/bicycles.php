<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/mechanics/bicycles.css">
    <title>Bicycles</title>
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
            <div class="admin__data__area__top--title">Bicycles</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add Bicycle" onclick="location.href='<?php echo URLROOT;?>/mechanics/addBicycle'">
                </div>

                <form action="<?php echo URLROOT;?>/mechanics/deleteBicycles" method="POST" id="userInterface">
                <div class="delete_user_button">
                    <input type="submit" class="btn btn_delete" value="Delete Selected">
                </div>
            </div>

        </div>

        <div class="admin__table__area">
            <table>
                <tr>
                    <th style="width: 3%;"></th>
                    <th style="width: 10%;">Bicycle ID</th>
                    <th style="width: 10%;">Bicycle Owner ID</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 10%;">Frame Size</th>
                    <th style="width: 10%;">Date Acquired</th>
                    <th style="width: 10%;">Date put into use</th>
                    <th style="width: 10%;">Current Location</th>
                    <th style="width: 5%;"></th>
                    

                    <?php foreach($data['bicycle_details'] as $oneObject) : ?>
                    <tr>
                        <td><input type="checkbox" name="selected[]" value="<?php echo $oneObject->bicycleID;?>"></td>
                        <td><?php echo $oneObject->bicycleID ?></td>
                        <td><?php echo $oneObject->bikeOwnerID ?></td>
                        <td>
                            <?php 
                                if($oneObject->status == 0){
                                    echo "Active";
                                }else{
                                    echo "Inactive";
                                }
                            
                            ?>
                        </td>
                        <td><?php echo $oneObject-> frameSize ?></td>
                        <td><?php echo $oneObject-> dateAcquired ?></td>
                        <td><?php echo $oneObject->	datePutInUse ?></td>
                        <td><?php echo $oneObject->	currentDA ?></td>
                        <td>
                        <!-- update icon svg format -->
                        <a href="<?php echo URLROOT;?>/mechanics/editBicycleDetails?bicycleID=<?php echo $oneObject->bicycleID;?>"><img src="<?php echo URLROOT;?>/public/images/mechanics/viewIcon1.png" alt="edit"></a>
                    </tr>
                <?php endforeach; ?>

                </tr>
            </table>
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