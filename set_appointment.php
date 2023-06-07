<?php
include ('admin/db_connect.php');

// Retrieve the doctor_id from the URL
$doctor_id = $_GET['id'];

// Retrieve available services options from the medical_specialty table
$options_query = "SELECT name FROM medical_specialty";
$options_result = mysqli_query($conn, $options_query);
$services = array();

if ($options_result) {
    while ($row = mysqli_fetch_assoc($options_result)) {
        $services[] = $row['name'];
    }

    // Retrieve the working hours for the selected doctor from the database
    $query = "SELECT * FROM doctors_schedule WHERE doctor_id = $doctor_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Check if there are available working hours
        if (mysqli_num_rows($result) > 0) {
            // Fetch the working hours row
            $row = mysqli_fetch_assoc($result);
            
            // Retrieve the start time and end time from the working hours
            $start_time = strtotime($row['time_from']);
            $end_time = strtotime($row['time_to']);
    
            // Calculate the duration between the start time and end time
            $duration = 30 * 60; // 30 minutes in seconds
    
            // Generate appointment slots based on the working hours
            $current_time = $start_time;
            while ($current_time < $end_time) {
                // Format the appointment slot time
                $slot_time = date('H:i', $current_time);

    
                $appointment_slots[] = $slot_time;
    
                // Move to the next appointment slot
                $current_time += $duration;
            }

            // Retrieve the days from the working hours
            $working_days = explode(',', $row['day']);
        } else {
            echo "No working hours available for this doctor.";
        }
    } else {
        echo "Error retrieving working hours: " . mysqli_error($conn);
    }


} else {
    echo "Error retrieving service options: " . mysqli_error($conn);
}
?>

<style>
    #uni_modal .modal-footer {
        display: none
    }
</style>
<div class="container-fluid">
    <div class="col-lg-12">
        <div id="msg"></div>
        <form action="" id="manage-appointment">
        <input type="hidden" name="doctor_id" value="<?php echo $_GET['id'] ?>">
            <div class="form-group">
                <label for="" class="control-label">Date</label>
                <input type="date" value="" name="date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="" class="control-label">Time</label>
                <select name="time" class="form-control" required>
                    <option value="">Select Time</option>
                    <?php foreach ($appointment_slots as $slot) : ?>
                        <?php $slot_time = date('H:i', strtotime($slot)); ?>
                        <option value="<?php echo $slot_time; ?>"><?php echo $slot_time; ?></option>
                    <?php endforeach; ?>
                </select>

            </div>

            <div class="form-group">
                <label for="" class="control-label">Type of Services</label>
                <select name="service_type" class="form-control" required>
                    <option value="">Select Type of Services</option>
                    <?php foreach ($services as $service) : ?>
                        <option value="<?php echo $service; ?>"><?php echo $service; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <hr>
            <div class="col-md-12 text-center">
                <button class="btn-primary btn btn-sm col-md-4">Request</button>
                <button class="btn btn-secondary btn-sm col-md-4" type="button" data-dismiss="modal" id="">Close</button>
            </div>
        </form>
    </div>
</div>


<script>
$("#manage-appointment").submit(function(e) {
    e.preventDefault()
    start_load()
    $.ajax({
        url: 'admin/ajax.php?action=set_appointment',
        method: 'POST',
        data: $(this).serialize(),
        success: function(resp) {
            resp = JSON.parse(resp)
            if (resp.status == 1) {
                alert_toast("Request submitted successfully");
                end_load();
                $('.modal').modal("hide");
            } else {
                $('#msg').html('<div class="alert alert-danger">' + resp.msg + '</div>')
                end_load();
            }
        }
    })
})

// Define the available working days
// Define the available working days
var workingDays = <?php echo json_encode($working_days); ?>;

$(document).ready(function () {
    // Initialize the calendar
    $('#calendar').datepicker({
        onSelect: function (dateText) {
            $('#selected-date').val(dateText); // Store the selected date in the hidden input
        },
        beforeShowDay: function (date) {
            var day = date.getDay(); // Get the day of the week (0-6, where 0 is Sunday)
            return [workingDays.includes(day)]; // Return true if the day is in the workingDays array
        },
        yearRange: new Date().getFullYear().toString() + ':' + (new Date().getFullYear() + 1).toString() // Set the year range to current year and next year
    });
});


// Function to get the name of the day from the day index
function getDayName(dayIndex) {
    var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    return days[dayIndex];
}
</script>
