<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/administrator.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Bicycle Owners</title>
</head>
<body>
    <!-- Finalized Side Bar -->
    <?php require APPROOT . '/views/inc/sidebar-admin.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="admin_data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header-admin.php'; ?>

        <!-- REAL DATA AREA -->

        <!-- admin real data top -->
        <div class="admin__data__area--top">
            <div class="admin__data__area__top--title">Bicycle Owners</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add Bike Owner" onclick="location.href='<?php echo URLROOT;?>/admins/addBikeOwner'">
                </div>

                <form action="<?php echo URLROOT;?>/admins/deleteBikeOwners" method="POST" id="userInterface">
                <div class="delete_user_button">
                    <input type="submit" name="delete" class="btn btn_delete" value="Delete Selected">
                </div>
            </div>

        </div>

        <div class="admin__table__area">
            <table>
                <tr>
                    <th style="width: 3%;"></th>
                    <th style="width: 10%;">Name</th>
                    <th style="width: 10%;">Bicycle Owner ID</th>
                    <th style="width: 10%;">NIC</th>
                    <th style="width: 10%;">Phone Number</th>
                    <th style="width: 10%;">Email</th>
                    <th style="width: 5%;"></th>

                </tr>

                <?php foreach($data['bikeOwner_details'] as $oneObject) : ?>
                    <tr>
                        <td><input type="checkbox" name="selected[]" value="<?php echo $oneObject->bikeOwnerID ?>"></td>
                        <td><?php echo $oneObject->firstName . " " . $oneObject->lastName ?></td>
                        <td><?php echo $oneObject->bikeOwnerID ?></td>
                        <td><?php echo $oneObject->NIC ?></td>
                        <td><?php echo $oneObject->phoneNumber ?></td>
                        <td><?php echo $oneObject->emailAdd ?></td>
                        <td>
                        <!-- update icon svg format -->
                            <a href="<?php echo URLROOT;?>/admins/editBikeOwnerProfile?bikeOwnerID=<?php echo $oneObject->bikeOwnerID;?>"><img src="<?php echo URLROOT;?>/public/images/admins/editIcon1.png" alt="edit"></a>
                    </tr>
                <?php endforeach; ?>
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