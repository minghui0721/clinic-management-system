<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="remarks_doctor.css">
</head>
<body>
    <h1>Doctor Remark Page</h1>


        <!-- Search form -->
        <form id="search-form">
        <input type="text" id="search-input" placeholder="Search remark...">
        <button type="submit">Search</button>
    </form>

    <!-- Display remarks here -->
    <h2>Remarks</h2>
    <div id="remarks-container"></div>



      <!-- Form to edit an existing remark -->
      <h2>Edit Remark</h2>
    <form id="edit-remark-form">
        <input type="hidden" id="edit-permission-id" name="permission_id">
        <input type="text" id="edit-appointment-id" name="appointment_id" placeholder="Appointment ID" required>
        <input type="text" id="edit-patient-id" name="patient_id" placeholder="Patient ID" required>
        <textarea id="edit-remark-text" name="remark" placeholder="Remark" required></textarea>
        <textarea id="edit-status-text" name="status" placeholder="Status" required readonly></textarea>
        <input type="submit" value="Update Remark">
        <button type="button" onclick="cancelEdit()">Cancel</button>
    </form>


    <!-- Form to add a new remark -->
    <h2>Add a Remark</h2>
    <form id="add-remark-form">
        <input type="hidden" id="remark-id" name="remark_id">
        <input type="text" id="appointment-id" name="appointment_id" placeholder="Appointment ID" required>
        <input type="text" id="patient-id" name="patient_id" placeholder="Patient ID" required>
        <textarea id="remark-text" name="remark" placeholder="Remark" required></textarea>
        <input type="submit" value="Add Remark">
    </form>

  
    <script>
        // Fetch and display remarks on page load
        window.onload = function() {
            fetchRemarks();
        };
        
        // Function to fetch remarks from the server
        function fetchRemarks() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("remarks-container").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "fetch_remarks_staff.php", true);
            xhttp.send();
        }
        
        // Function to add a new remark
        document.getElementById("add-remark-form").addEventListener("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    fetchRemarks();
                    document.getElementById("add-remark-form").reset();
                }
            };
            xhttp.open("POST", "add_remark_staff.php", true);
            xhttp.send(formData);
        });
        
        // Function to delete a remark
        function deleteRemark(permissionId) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    fetchRemarks();
                }
            };
            xhttp.open("GET", "delete_remark_staff.php?permission_id=" + permissionId, true);
            xhttp.send();
        }
        
        function editRemark(remarkId, appointmentId, patientId, remark, status) {
            document.getElementById("edit-permission-id").value = remarkId;
            document.getElementById("edit-appointment-id").value = appointmentId;
            document.getElementById("edit-patient-id").value = patientId;
            document.getElementById("edit-remark-text").value = remark;
            document.getElementById("edit-status-text").value = status;
            document.getElementById("edit-remark-form").style.display = "block";
        }




        // Function to update a remark
        document.getElementById("edit-remark-form").addEventListener("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    fetchRemarks();
                    cancelEdit();
                }
            };
            xhttp.open("POST", "update_remark_staff.php", true);
            xhttp.send(formData);
        });

        

        // Function to cancel editing a remark
        function cancelEdit() {
            document.getElementById("edit-appointment-id").value = "";
            document.getElementById("edit-patient-id").value = "";
            document.getElementById("edit-remark-text").value = "";
        }

        // Function to handle search form submission
        document.getElementById("search-form").addEventListener("submit", function(event) {
            event.preventDefault();
            var searchKeyword = document.getElementById("search-input").value;

            // Call a function to fetch and display the search results
            fetchSearchResults(searchKeyword);
        });

        // Function to fetch and display search results
        function fetchSearchResults(keyword) {
            // Make an AJAX request to the server with the search keyword
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Update the HTML with the search results
                    document.getElementById("remarks-container").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "search_remark_staff.php?search=" + encodeURIComponent(keyword), true);
            xhttp.send();
        }


    </script>
</body>
</html>

