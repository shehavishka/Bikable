<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/administrator.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Mechanics</title>
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
            <div class="admin__data__area__top--title">Mechanic</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add User" onclick="location.href='<?php echo URLROOT;?>/admins/addUser'">
                </div>
                <form action="<?php echo URLROOT;?>/admins/deleteUsers" method="POST" id="userInterface">
                <div class="delete_user_button">
                    <input type="submit" class="btn btn_delete" value="Delete Selected">
                </div>
            </div>

        </div>

        <div class="admin__table__area">
            <table>
                <tr>
                    <th style="width: 3%;"></th>
                    <th style="width: 13%;">Username</th>
                    <th style="width: 10%;">UserID</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 15%;">NIC</th>
                    <th style="width: 10%;">Role</th>
                    <th style="width: 5%;"></th>

                </tr>
        

                <?php foreach($data['mechanic_details'] as $oneObject) : ?>
                    <tr>
                    <td><input type="checkbox" name="selected[]" value="<?php echo $oneObject->userID ?>"></td>
                        <td><?php echo $oneObject->firstName . " " . $oneObject->lastName ?></td>
                        <td><?php echo $oneObject->userID ?></td>
                        <td>
                            <?php 
                                if($oneObject->status == 0){
                                    echo "Active";
                                }else{
                                    echo "Inactive";
                                }
                            
                            ?>
                        </td>
                        <td><?php echo $oneObject->emailAdd ?></td>
                        <td><?php echo $oneObject->NIC ?></td>
                        <td><?php echo $oneObject->role ?></td>
                        <td>
                        <!-- update icon svg format -->
                        <!-- <form action="<?php echo URLROOT;?>/admins/viewUserProfile" method="post">
                                <input type="hidden" name="userID" value="<?php echo $oneObject->userID;?>">
                                <input type="hidden" name="userStatus" value="<?php echo $oneObject->status;?>">
                                <input type="image" src="<?php echo URLROOT;?>/public/images/admins/editIcon1.png" name="edit" value="edit" >
                        </form> -->
                        <a href="<?php echo URLROOT;?>/admins/viewUserProfile?userID=<?php echo $oneObject->userID;?>"><img src="<?php echo URLROOT;?>/public/images/admins/editIcon1.png" alt="edit"></a>
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