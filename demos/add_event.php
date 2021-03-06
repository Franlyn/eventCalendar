<?php
if (isset($_POST['button'])) {
	echo "hello";
    header('Location: ../modify-events.php');
}

if(isset($_POST['submit'])) {

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "volunteerevents";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$title = $_POST['title'];
$backgroundColor = $_POST['backgroundColor'];
$start = $_POST['start'];
$end = $_POST['end'];
$eventTime = $_POST['eventTime'];
$location = $_POST['location'];
$description = $_POST['description'];
$volunteers = $_POST['volunteers'];
$hourper = $_POST['hourper'];
$contact = $_POST['contact'];
$elink = $_POST['elink'];
$link = $_POST['link'];
$totalhour = $volunteers * $hourper;


$title = $conn->real_escape_string($title);
$backgroundColor = $conn->real_escape_string($backgroundColor);
$start = $conn->real_escape_string($start);
$end = $conn->real_escape_string($end);
$eventTime = $conn->real_escape_string($eventTime);
$location = $conn->real_escape_string($location);
$description = $conn->real_escape_string($description);
// $volunteers = $conn->real_escape_string($volunteers);
$contact = $conn->real_escape_string($contact);
$elink = $conn->real_escape_string($elink);
$link = $conn->real_escape_string($link);

$sql = "INSERT INTO events (title, backgroundColor, start, end, eventTime, location, description, volunteers, contact, elink, link, hourper, totalhour)
VALUES ( '$title', '$backgroundColor', '$start', '$end', '$eventTime', '$location', '$description', '$volunteers', '$contact', '$elink', '$link', '$hourper', '$totalhour')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

include 'generateJSON.php';

}

?>

<html>
<head>
	<style>
	.basic-grey {
    margin-left:auto;
    margin-right:auto;
    max-width: 500px;
    background: #F7F7F7;
    padding: 25px 15px 25px 10px;
    font: 12px Georgia, "Times New Roman", Times, serif;
    color: #888;
    text-shadow: 1px 1px 1px #FFF;
    border:1px solid #E4E4E4;
}
.basic-grey h1 {
    font-size: 25px;
    padding: 0px 0px 10px 40px;
    display: block;
    border-bottom:1px solid #E4E4E4;
    margin: -10px -15px 30px -10px;;
    color: #888;
}
.basic-grey h1>span {
    display: block;
    font-size: 11px;
}
.basic-grey label {
    display: block;
    margin: 0px;
}
.basic-grey label>span {
    float: left;
    width: 20%;
    text-align: right;
    padding-right: 10px;
    margin-top: 10px;
    color: #888;
}
.basic-grey input[type="text"], .basic-grey input[type="email"],
 .basic-grey input[type="date"], .basic-grey input[type="url"],
  .basic-grey input[type="color"], .basic-grey input[type="number"],
   .basic-grey textarea, .basic-grey select {
    border: 1px solid #DADADA;
    color: #888;
    height: 30px;
    margin-bottom: 16px;
    margin-right: 6px;
    margin-top: 2px;
    outline: 0 none;
    padding: 3px 3px 3px 5px;
    width: 70%;
    font-size: 12px;
    line-height:15px;
    box-shadow: inset 0px 1px 4px #ECECEC;
    -moz-box-shadow: inset 0px 1px 4px #ECECEC;
    -webkit-box-shadow: inset 0px 1px 4px #ECECEC;
}
.basic-grey textarea{
    padding: 5px 3px 3px 5px;
}
.basic-grey select {
    /*background: #FFF url('down-arrow.png') no-repeat right;
    background: #FFF url('down-arrow.png') no-repeat right);
    appearance:none;
    -webkit-appearance:none; 
    -moz-appearance: none;
    background: #FFF;*/
    text-indent: 0.01px;
    text-overflow: '';
    width: 70%;
    height: 35px;
    line-height: 25px;
}
.basic-grey textarea{
    height:100px;
}
.basic-grey .button {
    background: #E27575;
    border: none;
    padding: 10px 25px 10px 25px;
    color: #FFF;
    box-shadow: 1px 1px 5px #B6B6B6;
    border-radius: 3px;
    text-shadow: 1px 1px 1px #9E3F3F;
    cursor: pointer;
}
.basic-grey .button:hover {
    background: #CF7A7A;
}
.purpleText {
    background-color: #723f68;
}
.greenText {
    background-color: #a9b911;
}
.orangeText {
    background-color: #fca311;
}
.brownText {
    background-color: #d4b03e;
}
.blueText {
    background-color: #6bace4;
}
	</style>
	<script type="text/javascript">
	function clicked() {
		window.location.href="modify-events.php";
	}</script>

</head>
<body>

<form action="" method="post" enctype="multipart/form-data" class="basic-grey">

	<h1>Add New Events</h1>

	<label>
		<span>Title:</span>
		<input type="text" name="title" required>
	</label>

	<label>
		<span>City:</span>
		<!--input type="color" name="backgroundColor" value="#ff0000" required-->
		<select  onchange="this.className=this.options[this.selectedIndex].className"
        id="chooseColor" class="purpleText" name="backgroundColor" required>
			<option class="purpleText" value="#723f68">Toronto</option>
			<option class="greenText" value="#a9b911">Vancouver</option>
			<option class="orangeText" value="#fca311">Calgary</option>
			<option class="brownText" value="#d4b03e">Montreal</option>
			<option class="blueText" value="#6bace4">Other</option>
		</select>
	</label>

	<label>
		<span>Start:</span>
		<input type="date" name="start" placeholder="MM/DD/YYYY" required>
	</label>

	<label>
		<span>End:</span>
		<input type="date" name="end" placeholder="MM/DD/YYYY" required>
	</label>

	<label>
		<span>Event Time:</span>
		<input type="text" name="eventTime" placeholder="--:--" required>
	</label>

	<label>
		<span>Location:</span>
		<input type="text" name="location" required>
	</label>

	<label>
		<span>Description:</span>
		<textarea type="text" name="description" required></textarea>
	</label>

	<label>
		<span>Number of Volunteers:</span>
		<input type="number" name="volunteers" min="0">
	</label>

    <label>
        <span>Hours Per Volunteer:</span>
        <input type="number" step="0.01" name="hourper" min="0.00">
    </label>

	<label>
		<span>Contact:</span>
		<input type="text" name="contact" required>
	</label>

	<label>
		<span>ELink:</span>
		<input type="text" name="elink">
	</label>

	<label>
		<span>Link:</span>
		<input type="url" name="link">
	</label>

	<label>
		<span>&nbsp;</span>
		<input type="submit" class="button" name="submit">
		<input type="button" style="margin-left: 20px;" class="button" value="Back" onclick="clicked()" />
	</label>

</form>


</body>
</html>


