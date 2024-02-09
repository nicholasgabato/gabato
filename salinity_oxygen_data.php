<?php

$dataPoints = array();

// Replace your-hostname, your-db, your-username, your-password according to your database
$hostname = '85.10.205.173';
$dbname = 'waterquality2';
$username = 'waterquality2';
$password = 'pass123.';

// Best practice is to create a separate file for handling the connection to the database
$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$result = $conn->query('SELECT * FROM tblsalinity order by time DESC');

if (!$result) {
    die('Invalid query: ' . $conn->error);
}

while ($row = $result->fetch_assoc()) {
    array_push($dataPoints, array("y" => $row['salinity'], "x" => $row['oxygen']));
}

$conn->close();
?>

<!DOCTYPE HTML>
<html>
<head>  
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "SALINITY AND OXYGEN LEVEL"
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc  
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>
