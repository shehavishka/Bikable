<?php 
class DBController {
	private $host = "localhost";
	private $user = "root";
	private $password = "";
	private $database = "bikable_db";
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_array($result)) {
			$resultset[] = $row;
		}
		if(!empty($resultset))
			return $resultset;
	}
}

$dbController = new DBController();
$query = "SELECT * FROM dockingareas WHERE status != 3";
$DAResult = $dbController->runQuery($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/adminLandPage.css">
    <title>Administrator Landpage</title>
</head>
<body>
    <section class="dashboard--header">
        <div class="dashboard__header--title"><strong>Administrator Dashboard</strong></div>
        
        <div class="dashboard__header--search">
            <input type="text" class="dashboard__header--searchbox" name="dashboard--searchbox" placeholder="Search">
            <div class="dashboard__header--searchicon">
                <img src="<?php echo URLROOT;?>/public/images/admins/dashboardIcons/search.png" alt="search icon" class="dashboard__icon searchicon">
            </div>
        </div>

        <div class="dashboard__header--helpsetting">
            <div class="helpsetting__help">
                <img src="<?php echo URLROOT;?>/public/images/admins/dashboardIcons/question.png" alt="help" class="dashboard__icon">
            </div>
            <div class="helpsetting__setting">
                <img src="<?php echo URLROOT;?>/public/images/admins/dashboardIcons/setting.png" alt="setting" class="dashboard__icon">
            </div>
        </div>

        <div class="dashboard__user__detail">
            <div class="user__address">Hello, <?php echo $_SESSION['user_fName'];?></div>
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($_SESSION['user_picture']).'" alt="dashboard profile picture" class="imgProperty"'; ?>
        </div>
    </section>

    <section class="upper__section">

        <div class="upper__section--buttons cardd">
            <!-- button class and put button into that classes -->
            <!-- <div class="admin--button">
                <input type="button" value="ADMIN" class="btn" onclick="location.href='<?php echo URLROOT;?>/admins/administrator'">
            </div> -->
            <div class="admin--button">
                <input type="button" value="MECHANIC" class="btn" onclick="location.href='<?php echo URLROOT;?>/admins/mechanic'">
            </div>
            <div class="admin--button">
                <input type="button" value="BICYCLE OWNER" class="btn" onclick="location.href='<?php echo URLROOT;?>/admins/bicycleOwner'">
            </div>
            <div class="admin--button">
                <input type="button" value="RIDERS" class="btn" onclick="location.href='<?php echo URLROOT;?>/admins/riders'">
            </div> 
        </div>

        <!-- report card on the upper section of the display -->
        <div class="upper__section--reports cardd">
            <div class="upper__section__card--title">
                <!-- Reports -->
                <a class = "title" href="<?php echo URLROOT ?>/admins/reportsControl">Reports</a>
            </div>
            <div class="upper_section__reports--body">
                <!-- take reports data from the database and display on this table -->
                <table>
                    <tr>
                    <th style="width: 5%;">Report ID</th>
                    <th style="width: 6%;">Problem Title</th>
                    <th style="width: 6%;">Time Logged</th>
                    </tr>

                    <?php foreach($data['dashboard_reports'] as $oneObject) : ?>
                    <tr>
                        <td><?php echo $oneObject->reportID ?></td>
                        <td><?php echo $oneObject->problemTitle ?></td>
                        <td><?php echo $oneObject->loggedTimestamp ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <!-- <table>
                    <tr>
                        <th>Report ID</th>
                        <th>Mechanic ID</th>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                </table> -->
            </div>
        </div>

        <!-- upper section reapir log card -->
        <div class="upper__section--repairlog cardd">
            <div class="upper__section__card--title">
                <a class = "title" href="<?php echo URLROOT ?>/admins/repairLogControl">Active Repair Log</a>
            </div>

            <div class="upper__section__repairlog--body">
                <table>
                    <tr>
                    <th style="width: 5%;">Repair Log ID</th>
                    <th style="width: 6%;">Mechanic ID</th>
                    <th style="width: 6%;">Date In</th>
                    </tr>

                    <?php foreach($data['dashboard_repairlog'] as $oneObject) : ?>
                    <tr>
                        <td><?php echo $oneObject->logID ?></td>
                        <td><?php echo $oneObject->mechanicID ?></td>
                        <td><?php echo $oneObject->dateIn ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <!-- <table>
                    <tr>
                        <th>Log ID</th>
                        <th>Bicyle ID</th>
                        <th>Date in</th>
                    </tr>

                    <tr>
                        <td>M32465</td>
                        <td>34156D</td>
                        <td>2022.11.11</td>
                    </tr>

                    <tr>
                        <td>F35325</td>
                        <td>26134F</td>
                        <td>2022.11.11</td>
                    </tr>

                    <tr>
                        <td>J31535</td>
                        <td>34524G</td>
                        <td>2022.11.11</td>
                    </tr>

                    <tr>
                        <td>L78975</td>
                        <td>25236D</td>
                        <td>2022.11.11</td>
                    </tr>

                    <tr>
                        <td>F35325</td>
                        <td>26134F</td>
                        <td>2022.11.11</td>
                    </tr>
                </table> -->
            </div>
        </div>

        <div class="upper__section--bicycles cardd">
            <div class="upper__section__card--title">
                <a class = "title" href="<?php echo URLROOT ?>/admins/bicyclesControl">Bicycles</a>
            </div>
            <div class="upper__section__bicycles--body">
            <table>
                    <tr>
                    <th style="width: 5%;">Bicycle ID</th>
                    <th style="width: 6%;">Date Put Into Use</th>
                    </tr>

                    <?php foreach($data['dashboard_bicycles'] as $oneObject) : ?>
                    <tr>
                        <td><?php echo $oneObject->bicycleID ?></td>
                        <td><?php echo $oneObject->datePutInUse ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <!-- <table>
                    <tr>
                        <th>Bicycle ID</th>
                        <th>Frame</th>
                        <th>Status</th>
                    </tr>

                    <tr>
                        <td>34156D</td>
                        <td>L</td>
                        <td>Active</td>
                    </tr>

                    <tr>
                        <td>34152D</td>
                        <td>L</td>
                        <td>Active</td>
                    </tr>

                    <tr>
                        <td>43214Q</td>
                        <td>S</td>
                        <td>Active</td>
                    </tr>

                    <tr>
                        <td>43214Q</td>
                        <td>S</td>
                        <td>Active</td>
                    </tr>

                    <tr>
                        <td>43214Q</td>
                        <td>M</td>
                        <td>Inactive</td>
                    </tr>

                </table> -->
            </div>
        </div>
    </section>

    <!-- ***************************************************************************************************************** -->
    <section class="lower__section">
        <!-- lower section map -->
        <!-- <div class="lower_section--map"> -->
        <div id="map-layer"></div>
            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdJd3svFUpixnG_ebYv6_dDQQHI1QPvlM&callback=initMap"
                async defer>
            </script>
        
            <script type="text/javascript">
                var map;

                function initMap() {
                    var mapLayer = document.getElementById("map-layer");
                    var centerCoordinates = new google.maps.LatLng(6.9100, 79.8800);
                    var defaultOptions = { center: centerCoordinates, zoom: 13.5, mapId: "f58d941242b91036"}

                    map = new google.maps.Map(mapLayer, defaultOptions);
                    
                    const dockAs = [
                    <?php 
                        if(!empty($DAResult)) 
                        {
                            foreach($DAResult as $k=>$v)
                            {   
                    ?>  
                            {
                                position: new google.maps.LatLng(<?php echo $DAResult[$k]["locationLat"]; ?>, <?php echo $DAResult[$k]["locationLong"]; ?>),
                                icon: {url:"<?php echo URLROOT; ?>/public/images/admins/map_icon.png", labelOrigin: new google.maps.Point(43, 18)},
                                label: {text: '<?php echo $DAResult[$k]["currentNoOfBikes"]; ?>', color: "white", fontFamily:"SF Pro Rounded"},
                                labelClass: "marker-position",
                                title: '<?php echo $DAResult[$k]["areaName"]; ?>',
                                clikable: true,
                                url: '<?php echo URLROOT; ?>/admins/editDADetails?areaID=<?php echo $DAResult[$k]["areaID"]; ?>',
                                //url: '<php echo URLROOT; ?>/admins/dockingareas',
                            },      
                    <?php
                            }
                        }
                    ?>
                    ];

                    dockAs.forEach(({position, icon, label, labelClass, title, clickable, url}, i) => {
                        // const pinView = new google.maps.Marker({
                        //     glyph: `${i + 1}`,
                        // });

                        const marker = new google.maps.Marker({
                            position,
                            map,
                            icon, label, labelClass, title, clickable
                            //content: pinView.element,
                        });

                        // Add a click listener for each marker
                        marker.addListener('click', function() {
                            window.location = url;
                        });
                    });
                        
                }
            </script>

        <div class="lower_section--statistics">
            <div class="lower__section__card--title">
                <a class = "title" href="<?php echo URLROOT ?>/admins/ridesControl">Active Rides</a>
            </div>

            <div class="upper_section__reports--body">
                <!-- take reports data from the database and display on this table -->
                <table>
                    <tr>
                    <th style="width: 5%;">Bicycle ID</th>
                    <th style="width: 6%;">Date Put Into Use</th>
                    </tr>

                    <?php foreach($data['dashboard_bicycles'] as $oneObject) : ?>
                    <tr>
                        <td><?php echo $oneObject->bicycleID ?></td>
                        <td><?php echo $oneObject->datePutInUse ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <!-- <table>
                    <tr>
                        <th>Rider ID</th>
                        <th>Ride ID</th>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                </table> -->
            </div>
        </div>

    </section>
</body>
</html>