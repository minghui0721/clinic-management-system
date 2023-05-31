<?php
// Create a connection to the MySQL database
include 'db_connect.php';



// Fetch appointments from the database and store them in an array
$appointments = array();

// Execute the query to retrieve the appointments data
$query = "SELECT patient_id, schedule, date_end, status FROM appointment_list";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $start = $row['schedule'];
        $end = $row['date_end'];
        $status = $row['status'];

        // Format the start and end times using the desired format
        $startTime = date('h:i A', strtotime($start));
        $endTime = date('h:i A', strtotime($end));

        $color = '';

        // Set different colors based on the appointment status
        if ($status == 0) {
          $color = '#FF0000'; // Red color for pending status
        } elseif ($status == 1) {
            $color = '#00FF00'; // Green color for confirmed status
        } elseif ($status == 3) {
            $color = '#4adede'; // Blue color for done status
        }

        $appointment = array(
            'title' => $row['patient_id'] . '<br>Start Time: ' . $startTime . '<br>End Time: ' . $endTime,
            'start' => $start,
            'end' => $end,
            'color' => $color,
            'status' => $status,
        );
        $appointments[] = $appointment;
    }
}


// Convert the array to JSON
$appointments_json = json_encode($appointments);

// Close the database connection
mysqli_close($conn);
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>


<div class="containe-fluid">

	<div class="row">
		<div class="col-lg-12">
			
		</div>
	</div>

	<div class="row mt-3 ml-3 mr-3">
			<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
				<?php echo "Welcome back ".($_SESSION['login_type'] == 3 ? "Dr. ".$_SESSION['login_name'].','.$_SESSION['login_name_pref'] : $_SESSION['login_name'])."!"  ?>
									
				</div>
				<hr>
				<div class="row">
				
				</div>
			</div>

        <!-- Add the three buttons -->
      <button id="filter-pending">Pending</button>
      <button id="filter-confirmed">Confirmed</button>
      <button id="filter-done">Done</button>
      
			<div id="calendar">

			</div>

			
		</div>
		</div>
	</div>

</div>


<script>
 
$(document).ready(function() {
  var calendar; // Declare the calendar variable
  calendar = $('#calendar').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,agendaWeek,agendaDay'
    },
    defaultView: 'month',
    buttonText: {
      today: 'Today',
      month: 'Month',
      week: 'Week',
      day: 'Day'
    },
    events: <?php echo $appointments_json; ?>,
    eventRender: function(event, element) {
      // Check if the appointment details have already been added
      if (element.find('.appointment-details').length === 0) {
        // Extract the appointment details from the event title
        var titleParts = event.title.split('<br>');
        var patientID = titleParts[0];
        var startTime = titleParts[1].substring(titleParts[1].indexOf(':') + 1).trim();
        var endTime = titleParts[2].substring(titleParts[2].indexOf(':') + 1).trim();
        var status = event.status;


        // Create the HTML content for the appointment details
        var html = '<div class="appointment-details">' +
          '<div class="patient-id">Patient ID: ' + patientID + '</div>' +
          '<div class="start-time">Start Time: ' + startTime + '</div>' +
          '<div class="end-time">End Time: ' + endTime + '</div>' +
          '<div class="status">Status: ' + status + '</div>' +
          '</div>';


        element.find('.fc-title').remove(); // Remove event title
        element.find('.fc-content').append(html);

         // Add custom class to the event element based on status
        element.addClass('status-' + status);
      }
    }
  });

  // Button click event handlers
   // Button click event handlers
   $('#filter-pending').click(function() {
    // Hide all appointments
    calendar.find('.fc-event').hide();

    // Show only the appointments with status "0"
    calendar.find('.status-0').show();
  });


  $('#filter-confirmed').click(function() {
    // Hide all appointments
    calendar.find('.fc-event').hide();

    // Show only the appointments with status "1"
    calendar.find('.status-1').show();
  });

  $('#filter-done').click(function() {
    // Hide all appointments
    calendar.find('.fc-event').hide();

    // Show only the appointments with status "3"
    calendar.find('.status-3').show();
  });
  
});

</script>