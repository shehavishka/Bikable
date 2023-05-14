<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/administrator.css">
    <title>Mechanic Detail</title>
</head>
<body>
    <!-- Finalized Side Bar -->
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="admin_data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header.php'; ?>

        <!-- REAL DATA AREA -->

        <!-- admin real data top -->
        <div class="admin__data__area--top">
            <div class="admin__data__area__top--title">Riders</div>

            <!-- search bar -->
            <div class="dashboard__header--search">
                <input type="text" id="search" class="dashboard__header--searchbox" name="dashboard--searchbox" placeholder="Search">          
                <div class="dashboard__header--searchicon">
                    <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/search.png" alt="search icon" class="dashboard__icon searchicon">
                </div>
            </div>


            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add User" onclick="location.href='<?php echo URLROOT;?>/owners/addUserToTheSystem'">
                </div>
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Delete Selected" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
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

                <!-- <tr>
                    <td><input type="checkbox" class="cbox"></td>
                    <td>Shehaan Avishka</td>
                    <td>1238524</td>
                    <td>Inactive</td>
                    <td>OwnerShehaan@gmail.com</td>
                    <td>200002403065</td>
                    <td>Admin</td>
                    <td>
                        update icon svg format
                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="17" cy="17" r="17" fill="black"/>
                            <path d="M19.06 14L20 14.94L10.92 24H10V23.08L19.06 14ZM22.66 8C22.41 8 22.15 8.1 21.96 8.29L20.13 10.12L23.88 13.87L25.71 12.04C26.1 11.65 26.1 11 25.71 10.63L23.37 8.29C23.17 8.09 22.92 8 22.66 8ZM19.06 11.19L8 22.25V26H11.75L22.81 14.94L19.06 11.19Z" fill="white"/>
                        </svg>
                            
                    </td>
                </tr> -->

                <tbody class="all-data">
                    
                    <?php foreach ($data['rider_details'] as $oneObject) {
                        echo '
                            <tr style="height: 2.5rem;">
                                <td><input type="checkbox"></td>
                                <td>' . $oneObject->firstName . " " . $oneObject->lastName . '</td>
                                <td>' . $oneObject->userID . '</td>
                                <td>';

                                if ($oneObject->status == 0) {
                                    echo "Active";
                                } elseif ($oneObject->status == 1) {
                                    echo "Inactive";
                                } else {
                                    echo "Deleted";
                                }

                        echo '</td>
                                <td>' . $oneObject->emailAdd . '</td>
                                <td>' . $oneObject->NIC . '</td>
                                <td>' . $oneObject->role . '</td>
                                <td>
                                    <a href="'.URLROOT.'/owners/userProfileViewButton?userID='.$oneObject->userID.'"><img src="'.URLROOT.'/public/images/owners/editIconsViewIcons/editIcon1.png" alt="edit"></a>
                                </td>
                            </tr>';
                    }?>
                </tbody>
                
                <tbody id="details" class="search-data"></tbody>


            </table>
        </div>
    </section>

    <script>
        $(document).ready(function(){
            $("#search").keyup(function(){
                var searchText = $(this).val();

                if(searchText)
                {
                    $('.all-data').hide();
                    $('.search-data').show();
                }
                else{
                    $('.all-data').show();
                    $('.search-data').hide();
                }

                $.ajax({
                    url: './search_riders',
                    type: 'POST',
                    data: {search: searchText},
                    success: function(response){
                        console.log(response);
                        $("#details").html(response);
                    }
                });
            });       
        });
    </script>



</body>
</html>