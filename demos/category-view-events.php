<html>
<header>
  <style>
  .basic {
    font: 12px Georgia, "Times New Roman", Times, serif;
  }
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
    width: 1200px;
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
    border-right: 1px solid #fff;
    border-left: 1px solid #e8e8e8;
    border-top: 1px solid #fff;
    border-bottom: 1px solid #e8e8e8;
    padding: 10px 15px;
    position: relative;
    transition: all 300ms;
    font-family: Arial;
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
    display: inline-block;
    font-size: 25px;
    padding: 0px 0px 10px 40px;
    border-bottom:1px solid #E2E2E2;
    margin: 10px -15px 20px -35px; color: #555;
  }
  </style>
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
  ?>
  <div>
    <h1>Event List</h1>
    <p style="float: right;"><a href="modify-events.php">view by events</a>/view by category</p>
    <!--input type="button" class="button-secondary" value="Add Events" onclick="location='add_event.php'" /-->
  </div>

  <?php

    $sql = "SELECT title, location, contact, SUM(totalhour) AS totalhour FROM events GROUP BY title";;

    if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'title')
      {
        $sql .= " ORDER BY title";
      }
      elseif ($_GET['sort'] == 'contact')
      {
        $sql .= " ORDER BY contact";
      }
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<table><tr>";
      echo "<th><a style=\"color: white;\" href='modify-events.php?sort=title'>Title</a></th>";
      echo "<th>Location</th><th>Total Hours</th>";
      echo "<th><a style=\"color: white;\" href='modify-events.php?sort=contact'>Contact</a></th></tr>";

    // output data of each row
      while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["title"]."</td>";
        echo "<td>".$row["location"]."</td>";
        echo "<td>".$row["totalhour"]."</td><td>".$row["contact"]."</td></tr>";
      }
      echo "</table>";
    } else {
      echo "0 results";
    }
    $conn->close();
  ?>

</body>
</html>