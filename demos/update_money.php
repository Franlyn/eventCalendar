<?php

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

    if(isset($_GET['id'])) {

        $id=$_GET['id'];

        if(isset($_POST['submit'])) {
          $moneyRaised = $_POST['moneyRaised'];

          $moneyRaised = $conn->real_escape_string($moneyRaised);

          $sql = "UPDATE events SET moneyRaised='$moneyRaised' WHERE idevents='$id'";

          /*$query1 = "SELECT title, start FROM events WHERE idevents='$id'";
          $result = $conn->query($query1);
          $row = $result->fetch_assoc();
          $title = $row['title'];
          $date = $row['start'];
          $sql2 = "INSERT INTO raisemoney (title, date, amount) VALUES ('$title', '$date', '$moneyRaised')";*/
        
          if ($conn->query($sql) === TRUE) {
            echo "Updated!";
           // header('location:modify-events.php');
          } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            //echo "Error: " . $sql2 . "<br>" . $conn->error;
          }
          $conn->close();
          include 'generateJSON.php';

        }

        $query1 = "SELECT * FROM events WHERE idevents='$id'";
        $result = $conn->query($query1);
        $row = $result->fetch_assoc();

?>
<html>
<head>
    <script src='../lib/jquery.min.js'></script>
    <script type="text/javascript">
    function clicked() {
      var url = <?php echo '"output_total_money.php?event='.$row['title'].'"' ?>;
      window.location.href=url;
    }
    </script>
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
        margin: -10px -15px 30px -10px;
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
    background: #FFF;
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

</head>
<body>


<form action="" method="post" enctype="multipart/form-data" class="basic-grey">

 <h1>Update the Donation Amount</h1>

 <label>
  <span>Title:</span>
  <input type="text" name="title" value="<?php echo $row['title']; ?>" required>
</label>

	<label>
		<span>Start Date:</span>
		<input type="date" name="start" value="<?php echo $row['start']; ?>" required>
	</label>

	<label>
		<span>Donation Amount:</span>
		<input type="text" name="moneyRaised" value="<?php echo $row['moneyRaised']; ?>" required>
	</label>

	<label>
		<span>&nbsp;</span>
		<input type="submit" class="button" name="submit" value="submit">
		<input type="button" style="margin-left: 20px;" class="button" value="Back" onclick="clicked()" />
	</label>

</form>

<?php
//$conn->close();
}
?>

</body>
</html>
