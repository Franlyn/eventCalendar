<html>
<header>
  <style>
  .button-secondary {
    background: #888;
    margin-left: 30px;
    color: white;
    border-radius: 4px;
    text-shadow: 0 1px 0 #000;
    padding: 8px 20px 8px 20px;
  }
  table {
    background: #f5f5f5;
    border-collapse: separate;
    box-shadow: inset 0 1px 0 #fff;
    font-size: 12px;
    line-height: 24px;
    margin: 30px auto;
    margin-top: 0px;
    text-align: left;
    width: 800px;
    float: left;
  } 

  th {
    background: url(http://jackrugile.com/images/misc/noise-diagonal.png), linear-gradient(#777, #444);
    border-left: 1px solid #555;
    border-right: 1px solid #777;
    border-top: 1px solid #555;
    border-bottom: 1px solid #333;
    box-shadow: inset 0 1px 0 #999;
    color: white;
    font-family: Georgia;
    font-weight: bold;
    padding: 10px 15px;
    position: relative;
    text-shadow: 0 1px 0 #000;
  }

  th:after {
    background: linear-gradient(rgba(255,255,255,0), rgba(255,255,255,.08));
    content: '';
    display: block;
    height: 25%;
    left: 0;
    margin: 1px 0 0 0;
    position: absolute;
    top: 25%;
    width: 100%;
  }

  th:first-child {
    border-left: 1px solid #777;  
    box-shadow: inset 1px 1px 0 #999;
  }

  th:last-child {
    box-shadow: inset -1px 1px 0 #999;
  }

  td {
    font-family: Arial;
    border-right: 1px solid #fff;
    border-left: 1px solid #e8e8e8;
    border-top: 1px solid #fff;
    border-bottom: 1px solid #e8e8e8;
    padding: 10px 15px;
    position: relative;
    transition: all 300ms;
  }

  td:first-child {
    box-shadow: inset 1px 0 0 #fff;
  } 

  td:last-child {
    border-right: 1px solid #e8e8e8;
    box-shadow: inset -1px 0 0 #fff;
  } 

  tr {
    background: url(http://jackrugile.com/images/misc/noise-diagonal.png);  
  }

  tr:nth-child(odd) td {
    background: #f1f1f1 url(http://jackrugile.com/images/misc/noise-diagonal.png);  
  }

  tr:last-of-type td {
    box-shadow: inset 0 -1px 0 #fff; 
  }

  tr:last-of-type td:first-child {
    box-shadow: inset 1px -1px 0 #fff;
  } 

  tr:last-of-type td:last-child {
    box-shadow: inset -1px -1px 0 #fff;
  } 

  h1 {
    font-family: Georgia;
    display: inline-block;
    font-size: 25px;
    padding: 0px 0px 10px 40px;
    border-bottom:1px solid #E2E2E2;
    margin: 10px -15px 20px -35px; color: #555;
  }
  </style>
  <script src='../lib/jquery.min.js'></script>
</header>
<body class="basic">
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

    $sql = "SELECT title, SUM(moneyRaised) AS moneyRaised FROM events GROUP BY title";

    /*if (isset($_POST['submit'])) {
      $from = $_POST['start'];
      $to = $_POST['end'];
      $sql = "SELECT title, SUM(moneyRaised) AS moneyRaised FROM events WHERE start between '$from' AND '$to' GROUP BY title";
    } else {
      $sql = "SELECT title, SUM(moneyRaised) AS moneyRaised FROM events GROUP BY title";
    }*/

    $result = $conn->query($sql);
    ?>

  <div>
    <h1>Donation Amount List</h1>
  </div>

  <form  action="" method="post" enctype="multipart/form-data">
    <?php
    echo '<select name="selectName" style="font-family: Arial;">'; // Open your drop down box
    echo '<option value="All">All</option>';
    // Loop through the query results, outputing the options one by one
    while ($row = $result->fetch_assoc()) {
      echo '<option value="'.$row['title'].'">'.$row['title'].'</option>';
    }
    echo '</select>';

    ?>

    <label>
      <span>&nbsp;</span>
      <input type="submit" class="button" name="submit" value="submit" style="font-family: Arial;">
    </label>

  </form>

  <table>
    <tr>
      <th>ID</th>
      <th>Title</th>
      <th>Date</th>
      <th>Donation Amount</th>
      <th>Update Donation Amount</th></tr>

  <?php
  if (isset($_POST['submit'])) {
    $name = $_POST['selectName'];
    header("Location: output_total_money.php?event=$name");
      //echo "<a href='output_total_money.php?event=".$row['selectName']."'>Submit</a>";
  }
     // $selected = $_POST['selectName'];
  if (isset($_GET['event']) && $_GET['event'] != "All") {
    $selected = $_GET['event'];
    $sqltable = "SELECT * FROM events WHERE title = '$selected'";
    
    $resultTable = $conn->query($sqltable);

    if ($resultTable->num_rows > 0) {
      echo "<tr><td><b>#</b></td><td><b>".$selected."</b></td><td><b>All</b></td>";
      $totalSQL = "SELECT SUM(moneyRaised) AS moneyRaised FROM events WHERE title = '$selected' GROUP BY title";
      $totalResult = $conn->query($totalSQL);
      $totalRow = $totalResult->fetch_assoc();
      if ($totalRow['moneyRaised'] == "") {
        $total = "0.00";
      } else {
        $total = $totalRow['moneyRaised'];
      }
      echo "<td><b>$".$total."</b></td><td><b>#</b></td></tr>";

    // output data of each row
      while($row2 = $resultTable->fetch_assoc()) {
        echo "<tr><td>".$row2["idevents"]."</td>";
        echo "<td>".$row2["title"]."</td>";
        echo "<td>".$row2["start"]."</td>";

        if ($row2["moneyRaised"] == "") {
          echo "<td>$0.00</td>";
        } else {
          echo "<td>$".$row2["moneyRaised"]."</td>";
        }

        //echo "<td><a onclick=openwindow(".$row2['idevents'].")>Update</a></td>";
        echo "<td><a href='update_money.php?id=".$row2["idevents"]."'>Update</a></td>";

        echo "</tr>";
      }
      echo "</table>";
    } else {
      echo "0 results";
    }
  } else {
    $sqlAll = "SELECT title, SUM(moneyRaised) AS moneyRaised FROM events GROUP BY title";
    $resultAll = $conn->query($sqlAll);
    if ($resultAll->num_rows > 0) {
      while ($rowAll = $resultAll->fetch_assoc()) {
        echo "<tr><td>#</td><td>".$rowAll["title"]."</td><td>All</td>";
        if ($rowAll["moneyRaised"] == "") {
          echo "<td>$0.00</td>";
        } else {
          echo "<td>$".$rowAll["moneyRaised"]."</td>";
        }
        echo "<td>#</td></tr>";
      }
    }
  }
 // }
  $conn->close();
  ?>

</body>
</html>