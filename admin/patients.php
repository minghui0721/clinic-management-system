<?php
// Assuming you have a database connection
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the form input values
  $name = $_POST['name'];
  $address = $_POST['address'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $allergic = $_POST['allergic'];
  $other = $_POST['other1'];
  $doctorId = 0; // Assuming doctor_id is hardcoded to 0
  $type = 3; // Assuming type is hardcoded to 0

  // Check if the email already exists in the users table
  $checkQuery = "SELECT COUNT(*) as count FROM users WHERE username = '$email'";
  $checkResult = mysqli_query($conn, $checkQuery);
  $checkData = mysqli_fetch_assoc($checkResult);
  $emailExists = $checkData['count'] > 0;

  if ($emailExists) {
    // Email already exists, handle the error or show a message
    echo "Error: Email already exists.";
  } else {
    // Prepare and execute the SQL query to insert the data into the users table
    $usersQuery = "INSERT INTO users (doctor_id, name, address, contact, username, password, type) VALUES ('$doctorId', '$name', '$address', '$contact', '$email', '$password', '$type')";
    $usersResult = mysqli_query($conn, $usersQuery);

    if ($usersResult) {
      // Retrieve the patient ID generated by the auto-increment field
      $patientId_users = mysqli_insert_id($conn);

      $patientQuery = "INSERT INTO patient_list (name, address, contact_no, email, user_id) VALUES ('$name', '$address', '$contact', '$email', $patientId_users)";
      $patientResult = mysqli_query($conn, $patientQuery);
      $patientId = mysqli_insert_id($conn);

      if ($patientResult) {
        // Data inserted successfully in both tables

        // Insert the patient ID and allergic name into the allergic table
        if (!empty($other)) {
          $allergicName = $other;
        } else {
          $allergicName = $allergic;
        }

        $allergicQuery = "INSERT INTO allergic (patient_id, name) VALUES ('$patientId', '$allergicName')";
        $allergicResult = mysqli_query($conn, $allergicQuery);

        if ($allergicResult) {
          echo "Patient data information saved successfully.";
        } else {
          // Error occurred while inserting data into the allergic table
          echo "Error: " . mysqli_error($conn);
        }
      } else {
        // Error occurred while inserting data into the patient_list table
        echo "Error: " . mysqli_error($conn);
      }
    } else {
      // Error occurred while inserting data into the users table
      echo "Error: " . mysqli_error($conn);
    }
  }
}
?>


<style>
  table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ddd;
  }

  th,
  td {
    padding: 8px;
    text-align: left;
    border-right: 1px solid #ddd;
  }

  th:last-child,
  td:last-child {
    border-right: none;
  }

  tr:last-child td {
    border-bottom: none;
  }

  th {
    background-color: #f2f2f2;
  }

  tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  tr:hover {
    background-color: #f5f5f5;
  }
</style>

<!-- Add the following code after including the necessary CSS and JavaScript files for Bootstrap -->
<div class="form-group">
					<input type="text" class="form-control" id="search_input" placeholder="Search by name">
</div>

<div id="modal" class="modal">
  <div class="modal-content">
    <!-- Place the user information here -->
    <span class="close">&times;</span>
  </div>
</div>


<div class="modal" id="addPatientModal" tabindex="-1" role="dialog" aria-labelledby="addPatientModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPatientModalLabel">Add Patient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="">
        <div class="modal-body">
          <div class="form-group">
            <label for="" class="control-label">Name</label>
            <input type="text" name="name" required="" class="form-control">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Contact</label>
            <input type="text" name="contact" required="" class="form-control">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Address</label>
            <input type="text" name="address" required="" class="form-control">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Email</label>
            <input type="email" name="email" required="" class="form-control">
          </div>
          <div class="form-group">
            <label for="" class="control-label">Password</label>
            <input type="password" name="password" required="" class="form-control">
        </div>
        <div class="form-group">
          <label for="" class="control-label">Allergic</label>
          <select name="allergic" required="" class="form-control" onchange="yesnoCheck(this);">
            <option value="">Choose the medication you are allergic to</option>
            <option value="penicillin and related antibiotics.">Penicillin and related antibiotics.</option>
            <option value="antibiotics containing sulfonamides (sulfa drugs)">Antibiotics containing sulfonamides (sulfa drugs)</option>
            <option value="anticonvulsants.">Anticonvulsants.</option>
            <option value="no allergic">No allergic</option>
            <option value="other">Others</option>
          </select>
        </div>
        <div id="ifYes" style="display: none;">
          <label for="other">Allergic</label> <input type="text" id="other1" name="other1" /><br />
        </div>

        </div>
        
       
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button> <!-- Changed the button type to submit -->
        </div>
      </form>
    </div>
  </div>
</div>

<a href="javascript:void(0);" onclick="$('#addPatientModal').modal('show');" style="margin-bottom: 10px; display: inline-block;">+ Add Patient</a>


<div class="modal" id="editPatientModal" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="update_patient.php">
        <div class="modal-body">

          <div class="form-group">
            <label for="editPatientID" class="control-label">Patient ID</label>
            <input type="text" name="patientId" id="editPatientId" class="form-control" readonly> 
          </div>

          <div class="form-group" hidden>
            <label for="editPatientId_users" class="control-label">Patient ID Users</label>
            <input type="text" name="patientId_users" id="editPatientId_users" class="form-control" readonly> 
            </div>


          <div class="form-group">
            <label for="editName" class="control-label">Name</label>
            <input type="text" id="editName" name="name" required="" class="form-control">
          </div>
          <div class="form-group">
            <label for="editContact" class="control-label">Contact</label>
            <input type="text" id="editContact" name="contact" required="" class="form-control">
          </div>
          <div class="form-group">
            <label for="editAddress" class="control-label">Address</label>
            <input type="text" id="editAddress" name="address" required="" class="form-control">
          </div>
          <div class="form-group">
            <label for="editEmail" class="control-label">Email</label>
            <input type="email" id="editEmail" name="email" required="" class="form-control">
          </div>
          <div class="form-group">
            <label for="editPassword" class="control-label">Password</label>
            <input type="password" id="editPassword"             name="password" required="" class="form-control">
          </div>
          <div class="form-group">
            <label for="editAllergic" class="control-label">Allergic</label>
            <select id="editAllergic" name="allergic" required="" class="form-control" onchange="yesnoCheck(this);">
                <option value="">Choose the medication you are allergic to</option>
                <option value="penicillin and related antibiotics.">Penicillin and related antibiotics.</option>
                <option value="antibiotics containing sulfonamides (sulfa drugs)">Antibiotics containing sulfonamides (sulfa drugs)</option>
                <option value="anticonvulsants.">Anticonvulsants.</option>
                <option value="no allergic">No allergic</option>
                <option value="other">Others</option>
            </select>
            </div>
            <div id="editIfYes" style="display: none;">
                <label for="editOther">Allergic</label>
                <input type="text" id="other1" name="other1">
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>








<!-- Rest of the code remains the same -->


<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Email</th>
      <th>Contact</th>
      <th>Allergic</th>
      <th>Action</th> <!-- Add Action column -->
    </tr>
  </thead>
  <tbody>
    <?php
      // Assuming you have a database connection
      include('db_connect.php');

      // Retrieve data from the patient_list table
      $query = "SELECT * FROM patient_list";
      $result = mysqli_query($conn, $query);

      // Auto-increment counter for the #
      $counter = 1;

      // Fetch and populate table rows
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$counter."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['contact_no']."</td>";

        // Retrieve allergic information from the allergic table based on name
        $allergicQuery = "SELECT name FROM allergic WHERE patient_id = '".$row['id']."'";
        $allergicResult = mysqli_query($conn, $allergicQuery);

        $allergicNames = array(); // Array to store allergic names

        while ($allergicRow = mysqli_fetch_assoc($allergicResult)) {
          $allergicNames[] = $allergicRow['name']; // Add each name to the array
        }

        $allergicInfo = implode(", ", $allergicNames); // Combine the names with a comma separator

        if ($allergicInfo === "") {
          $allergicInfo = "None"; // Display "None" when no allergic records found
        }

        echo "<td>".$allergicInfo."</td>";
        
        // Add Action buttons
        echo "<td>";
        echo "<button onclick='editPatient(".$row['id'].")'>Edit</button>";
        echo "<button onclick='deletePatient(".$row['id'].")'>Delete</button>";
        echo "</td>";

        echo "</tr>";

        $counter++;
      }
    ?>
  </tbody>
</table>

<script>

    

function editPatient(patientId) {
  // Send an AJAX request to retrieve the patient information
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "get_patient.php?patientId=" + patientId, true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        // Request was successful, handle the response
        var response = JSON.parse(xhr.responseText);

         // Retrieve the patientId from the response
         var patientId = response.patientId;

         // Retrieve the allergic value from the response
        var allergicValue = response.allergic;

        // Update the form fields with the patient information
        $('#editPatientModal input[name="patientId_users"]').val(response.id);
        $('#editPatientModal input[name="patientId"]').val(patientId);
        $('#editPatientModal input[name="name"]').val(response.name);
        $('#editPatientModal input[name="contact"]').val(response.contact);
        $('#editPatientModal input[name="address"]').val(response.address);
        $('#editPatientModal input[name="email"]').val(response.username);
        $('#editPatientModal input[name="password"]').val(response.password);
        $('#editPatientModal select[name="allergic"]').val(allergicValue);        

        

        // Show the modal
        $('#editPatientModal').modal('show');
      } else {
        // Error occurred during the AJAX request
        alert("Error: " + xhr.status);
      }
    }
  };
  xhr.send();
}



  // Function to handle delete button click
function deletePatient(patientId) {
  // Confirm with the user before proceeding with the deletion
  if (confirm("Are you sure you want to delete this patient?")) {
    // Send an AJAX request to delete_patient.php
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_patient.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Request was successful, handle the response
          var response = xhr.responseText;
          if (response === "success") {
            // Patient deleted successfully, reload the page to reflect the changes
            location.reload();
          } else {
            // Error occurred during deletion
            alert("Error: " + response);
          }
        } else {
          // Error occurred during the AJAX request
          alert("Error: " + xhr.status);
        }
      }
    };
    xhr.send("patientId=" + patientId);
  }
}


  function showPopup() {
    document.getElementById('popupContainer').style.display = 'block';
  }

  function hidePopup() {
    document.getElementById('popupContainer').style.display = 'none';
  }

  function yesnoCheck(selectElement) {
  var ifYes = document.getElementById('editIfYes');
  if (selectElement.value === 'other') {
    ifYes.style.display = 'block';
  } else {
    ifYes.style.display = 'none';
  }
}


$('#search_input').on('input', function() {
		var searchValue = $(this).val().toLowerCase(); // Get the search value and convert to lowercase

		// Loop through each table row
		$('table tbody tr').each(function() {
			var name = $(this).find('td:nth-child(2)').text().toLowerCase(); // Get the name value from the second column and convert to lowercase

			if (name.includes(searchValue)) {
				$(this).show(); // Show the row if the name matches the search value
			} else {
				$(this).hide(); // Hide the row if the name does not match the search value
			}
		});
	});
</script>



