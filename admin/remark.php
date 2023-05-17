<?php 
	include 'db_connect.php';

	// Get the appointment details
	$appointment_id = $_GET['id'];
	$type = $_GET['type'];

	$appointment_query = $conn->query("SELECT a.*, u.name as patient_name FROM appointment_list a JOIN users u ON a.patient_id = u.id WHERE a.id = $appointment_id");
	$appointment = $appointment_query->fetch_assoc();

    // Retrieve the value of 'remark' from the 'remark' table based on type
    $remark_query = $conn->query("SELECT remark, remark_id FROM remark WHERE appointment_id = $appointment_id AND type = '$type'");
    $remark_result = $remark_query->fetch_assoc();
    $remark = isset($remark_result['remark']) ? $remark_result['remark'] : '';
    $remark_id = isset($remark_result['remark_id']) ? $remark_result['remark_id'] : '';

	// Handle form submission
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Get the form data
		$appointment_id = $_POST['appointment_id'];
		$patient_id = $appointment['patient_id'];
		$remark = $_POST['remark'];

		if (!empty($remark_id)) {
			// Update the existing remark
			$update_query = $conn->prepare("UPDATE remark SET remark = ? WHERE remark_id = ?");
			$update_query->bind_param("si", $remark, $remark_id);
			$update_query->execute();
		} else {
			// Insert a new remark record
			$insert_query = $conn->prepare("INSERT INTO remark (appointment_id, patient_id, remark, type) VALUES (?, ?, ?, ?)");
			$insert_query->bind_param("iiss", $appointment_id, $patient_id, $remark, $type);
			$insert_query->execute();
		}

		// Redirect to appointments.php
		header("Location: index.php?page=appointments");
		exit();
	}
?>

<div class="container-fluid">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<h4>Appointment Details</h4>
				<p><strong>Appointment ID:</strong> <?php echo $appointment['id']; ?></p>
				<p><strong>Patient ID:</strong> <?php echo $appointment['patient_id']; ?></p>
				<p><strong>Patient Name:</strong> <?php echo $appointment['patient_name']; ?></p>
				<form action="" method="POST">
					<input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
					<input type="hidden" name="type" value="<?php echo $type; ?>">
					<div class="form-group">
						<label for="remark">Remark:</label>
						<textarea class="form-control" id="remark" name="remark" placeholder="Enter remark"><?php echo htmlspecialchars($remark); ?></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Save</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	// Handle form submission
	document.querySelector('form').addEventListener('submit', function(event) {
		// Prevent the default form submission
		event.preventDefault();
		
		// Perform any additional processing or validation here if needed
		
		// Submit the form using AJAX or fetch
		var form = this;
		var formData = new FormData(form);

		fetch(form.action, {
			method: 'POST',
			body: formData
        }).then(function(response) {
            // Handle the response if needed
			// Redirect to appointments.php
			window.location.href = 'index.php?page=appointments';
		}).catch(function(error) {
			// Handle errors if needed
			console.error(error);
		});
	});
</script>