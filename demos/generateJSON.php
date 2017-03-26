<?php

// open a connection to mysql
$conn = mysqli_connect("localhost","root","root","volunteerevents")
or die("Error is : ".mysqli_error($conn));
//fetching data to php 
$sql = "SELECT * FROM events";

$response = array();

$events = array();
$result=$conn->query($sql);


while($row=mysqli_fetch_array($result)) 
{ 
	$title=$row['title']; 
	$backgroundColor=$row['backgroundColor'];
	$start = $row['start'];
	$end = $row['end'];
	$eventTime = $row['eventTime'];
	$location = $row['location'];
	$description = $row['description'];
	$volunteers = $row['volunteers'];
	$contact = $row['contact'];
	$elink = $row['elink'];
	$link = $row['link']; 

	$events[] = array('title'=> $title, 'backgroundColor'=> $backgroundColor,
		'start'=> $start, 'end'=> $end, 'eventTime'=> $eventTime, 'location'=> $location, 
          'description'=> $description, 'volunteers'=> $volunteers, 'contact'=> $contact, 
          'elink'=> $elink, 'link'=> $link);

} 

//$response['events'] = $events;

$fp = fopen('events.json', 'w');
fwrite($fp, json_encode($events));
fclose($fp);


?> 