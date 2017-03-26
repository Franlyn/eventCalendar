<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
<link href='../fullcalendar.min.css' rel='stylesheet' />
<link href='../fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='../lib/moment.min.js'></script>
<script src='../lib/jquery.min.js'></script>
<script type="text/javascript" src="jquery.qtip-1.0.0-rc3.min.js"></script>

   <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
   

<script src='../fullcalendar.min.js'></script>

<script>

	$(document).ready(function() {
		var today = $('#calendar').fullCalendar('getDate');
		
		$('#calendar').fullCalendar({
			header: {
				left: 'title',
				right: 'prev,next'
			},
			defaultDate: today,
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: {
				url: 'get-events.php',
				error: function() {
				 	$('#script-warning').show();
				}
			},
			/*eventRender: function(event, element) { 
				element.qtip({
					content: event.description
				});
			}*/
			loading: function(bool) {
				$('#loading').toggle(bool);
			},
			eventRender: function(event, element) {

				//Run a quick validation to not show anything with null values.
				var html_content = "<b class='text-info'>" + event.title + "</b><br>";

				if (event.eventTime != null) {
					html_content += "<b>Time</b> : " + event.eventTime + "</b><br>";
				}
				if (event.location != null) {
					html_content += "<b>Location</b> : " + event.location + "</b><br>";
				}
				if (event.description != null) {
					html_content += "<b>Description</b> : " + event.description + "</b><br>";
				}
				if (event.volunteers != null) {
					html_content += "<b>Volunteers</b> : " + event.volunteers + "</b><br>";
				}
				if (event.contact != null && (event.elink == "")) {
					html_content += "<b>Contact</b> : " + event.contact + "</b><br>";
                //html_content += "<b>Contact</b> : <a target='_blank' href=" + "mailto:" + event.contact + ">" + event.contact + "</b><br>";
                }
                if ((event.elink != "") && (event.contact != null))
                {
                	html_content += "<b>Contact</b> : <a href=" + "mailto:" + event.elink + ">" + event.contact + "</a><br>";
                }
                if ((event.link != null) && (event.link != "")){
                	html_content += "<b>Link</b> : <a target='_blank' href=" + event.link + ">" + event.link + "</b><br>";
                }

                element.css("cursor", "pointer");
                element.popover({
                	container: 'body',
                	html: true,
                	animation: false,
                	title: "Event",
                	content: html_content,
                	placement: "auto",
                	trigger: "manual"
                }).on("mouseenter", function() {
                	var _this = this;
                	$(this).popover("show");
                	$(".popover").on("mouseleave", function() {
                		$(_this).popover('hide');
                	});
                }).on("mouseleave", function() {
                	var _this = this;
                	setTimeout(function() {
                		if ($(".popover:hover").length === 0) {
                			$(_this).popover("hide");
                		}
                	}, 100);
                });
            }

		});
		
	});

</script>
<style>

	body {
		margin: 40px 10px;
		padding: 0;
		font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
		font-size: 14px;
	}

	#calendar {
		max-width: 860px;
		margin: 0 auto;
	}

	.fc-month-view span.fc-title{
        white-space: normal;
   }

   .fc-header-left span.fc-header-title {
   	  color: #003399;
   	  font: 15px;
   }

</style>
</head>
<body>

	<div id='calendar'></div>

</body>
</html>
