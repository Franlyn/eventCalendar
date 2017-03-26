<?php
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $dbname = "volunteerevents";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_GET['id'];
$sql= "DELETE FROM events WHERE idevents='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();

include 'generateJSON.php';
//echo "<meta http-equiv='refresh' content='0;url=modify-events.php'>";

?>

<html>
<header>
  <style>
  .button {
    background: #E27575;
    border: none;
    padding: 10px 25px 10px 25px;
    color: #FFF;
    box-shadow: 1px 1px 5px #B6B6B6;
    border-radius: 3px;
    text-shadow: 1px 1px 1px #9E3F3F;
    cursor: pointer;
    }
  </style>
</header>
<body>
  <form>
    <input type="button" value="Back" onclick="location='modify-events.php'" />
  </form>
</body>
</html>