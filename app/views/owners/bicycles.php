<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/bicycles.css">
    <title>Bicycles</title>
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
            <div class="admin__data__area__top--title">Bicycles</div>

            <!-- search bar -->
            <div class="dashboard__header--search">
                <input type="text" id="search" class="dashboard__header--searchbox" name="dashboard--searchbox" placeholder="Search">          
                <div class="dashboard__header--searchicon">
                    <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/search.png" alt="search icon" class="dashboard__icon searchicon">
                </div>
            </div>


            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add Bicycle" onclick="location.href='<?php echo URLROOT;?>/owners/addBicycle'">
                </div>
    <form action="<?php echo URLROOT;?>/owners/deleteBicycles" method="POST" id="userInterface">
                <div class="delete_user_button">
                    <input type="submit" class="btn btn_delete" value="Delete Selected">
                </div>
            </div>

        </div>

        <div class="admin__table__area">
            <table>
                <tr>
                    <th style="width: 4%;"></th>
                    <th style="width: 10%;">Bicycle ID</th>
                    <th style="width: 5%;">F.Size</th>
                    <th style="width: 8%;">Status</th>
                    <th style="width: 8%;">Date Accq.</th>
                    <th style="width: 8%;">Deploy Date</th>
                    <th style="width: 8%;">Total KM</th>
                    <th style="width: 10%;">Current Location</th>
                    <th style="width: 8%;">B.OwnerID</th>
                    <!-- <th style="width: 10%;">Log ID</th> -->
                    <th style="width: 5%;"></th>

                </tr>

                <!-- sample template data -->
                <!-- <tr>
                    <td><input type="checkbox" class="cbox"></td>
                    <td>37116D</td>
                    <td>L</td>
                    <td>Inactive</td>
                    <td>2022.12.27</td>
                    <td>2023.12.24</td>
                    <td>43</td>
                    <td>COL8B</td>
                    <td>2124</td>
                    <td>M23098</td>
                    <td>
                        update icon svg format -->
                        <!-- <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="17" cy="17" r="17" fill="black"/>
                            <path d="M19.06 14L20 14.94L10.92 24H10V23.08L19.06 14ZM22.66 8C22.41 8 22.15 8.1 21.96 8.29L20.13 10.12L23.88 13.87L25.71 12.04C26.1 11.65 26.1 11 25.71 10.63L23.37 8.29C23.17 8.09 22.92 8 22.66 8ZM19.06 11.19L8 22.25V26H11.75L22.81 14.94L19.06 11.19Z" fill="white"/>
                        </svg>
                            
                    </td>
                </tr> -->

                <tbody class="all-data">
                    
                    <?php foreach ($data['bicycles_details'] as $oneObject) {
                        echo '
                            <tr style="height: 2.5rem;">
                                <td><input type="checkbox" name="selected[]" value="'.$oneObject->bicycleID.'"></td>
                                <td>' . $oneObject->bicycleID .  '</td>
                                <td>' . $oneObject->frameSize . '</td>
                                <td>';

                                if ($oneObject->status == 1) {
                                    echo "Active";
                                } elseif ($oneObject->status == 0) {
                                    echo "Inactive";
                                } else {
                                    echo "Deleted";
                                }

                        echo '</td>
                                <td>' . $oneObject->dateAcquired . '</td>
                                <td>' . $oneObject->datePutInUse . '</td>
                                <td>' . $oneObject->totalKM . '</td>
                                <td>' . ($oneObject->currentLocationLat != NULL ? $oneBike->currentLocationLat : "Null") . '</td>
                                <td>' . $oneObject->bikeOwnerID . '</td>
                                <td>
                                    <a href="'.URLROOT.'/owners/editBicycleDetails?bicycleID='.$oneObject->bicycleID.'"><img src="'.URLROOT.'/public/images/owners/editIconsViewIcons/editIcon1.png" alt="edit"></a>
                                </td>
                            </tr>';
                    }?>
                </tbody>
                
                <tbody id="details" class="search-data"></tbody>

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
                        url: './search_bicycles',
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