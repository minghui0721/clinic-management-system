<?php
    include('admin/db_connect.php');
    // Assuming you have a database connection established

    // Check if the appointment ID is provided in the URL
    if (isset($_GET['appointment_id'])) {
        $appointmentId = $_GET['appointment_id'];

        // Retrieve the appointment details based on the ID
        $query = "SELECT id, schedule, services FROM appointment_list WHERE id = $appointmentId";
        $result = mysqli_query($conn, $query);

        // Retrieve the employees from the database
        $employee_query = "SELECT name FROM users WHERE type = 2";
        $employee_result = mysqli_query($conn, $employee_query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $id = $row['id'];
            $schedule = $row['schedule'];
            $services = $row['services'];
        } else {
            echo "Invalid appointment ID.";
        }
    } else {
        echo "Appointment ID not provided.";
    }

    $totalAmount = 75.00;
?>

<!DOCTYPE html>
<html>
<head>
    <style>
    
    .payment {
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-top: 80px;
    }

    .payment_details{
        background-color:;
    }

    #submit {
        margin-top: 10px;
    }

    form {
        padding: 20px;
        border-radius: 10px;
        text-align: center;
    }
    
    .details-container {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
    }

    h2 {
        margin-top: 20px;
    }

    label {
        display: flex;
        flex-direction: column;
        font-weight: bold;
    }

    input[type="text"] {
        margin-top: 5px;
        padding: 8px;
        width: 300px;
    }

    #cash_message {
        margin-top: 5px;
        color: green;
    }

    .submit-button {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .submit-button:hover {
        background-color: #45a049;
    }

    </style>
</head>

<body>
    <div class="payment">            
        <h2><i>Appointment Details</i></h2>
        <p><strong>ID:</strong> <?php echo $id; ?></p>
        <p><strong>Schedule:</strong> <?php echo $schedule; ?></p>
        <p><strong>Services:</strong> <?php echo $services; ?></p>

        <h2><i>Payment Form</i></h2>
        <form method="POST" action="process_payment.php">

        <p>Total Amount: RM<?php echo number_format($totalAmount, 2); ?></p> <!-- Display the total amount -->
            <input type="hidden" name="total_amount" value="<?php echo $totalAmount; ?>">

            <input type="hidden" name="appointment_id" value="<?php echo $id; ?>">
            <div class="payment_details">
                <label for="staff_option">Serve by which employee:</label>
                <select name="staff_option" id="staff_option">
                <?php
                while ($employee_row = mysqli_fetch_assoc($employee_result)) {
                    $employee_name = $employee_row['name'];
                    echo "<option value=\"$employee_name\">$employee_name</option>";
                }
                ?>
                </select>
            </div>


            <div class="payment_details">
                <label for="payment_option">Payment Option:</label>
                <select name="payment_option" id="payment_option">
                    <option value="none">Select payment option</option>
                    <option value="touch_n_go">Touch 'n Go</option>
                    <option value="cash">Cash</option>
                    <option value="card">Card</option>
                </select>
            </div>

            <div id="payment_fields">
                <input type="text" name="duitnow_id" id="duitnow_id" placeholder="Enter DuitNow ID" style="display: none; maxlength="12" required>

                <p id="cash_message" style="display: none;">Please pay the cash to the staff.</p>

                <input type='text' name='card_number' id='card_number' placeholder='Enter Card Number' maxlength='16' style="display: none;" required>
            </div>

            <a href="process_payment.php"><input type="submit" value="Submit Payment" id="submit" name="submit"></a>
            
        </form>
    </div>


    <script>
        document.getElementById('payment_option').addEventListener('change', function() {
    var paymentFields = document.getElementById('payment_fields');
    var duitnowIdField = document.getElementById('duitnow_id');
    var cashMessage = document.getElementById('cash_message');
    var cardNumberField = document.getElementById('card_number');

    if (this.value === 'touch_n_go') {
        paymentFields.style.display = 'block';
        duitnowIdField.style.display = 'block';
        cashMessage.style.display = 'none';
        cardNumberField.style.display = 'none';
        duitnowIdField.required = true;
        duitnowIdField.disabled = false;
        cardNumberField.required = false;
        cardNumberField.disabled = true;
        duitnowIdField.pattern = "\\d{12}"; // Validate for exactly 12 digits
        duitnowIdField.title = "Please enter a 12-digit Touch 'n Go ID";
    } else if (this.value === 'none') {

    } else if (this.value === 'cash') {
        paymentFields.style.display = 'block';
        duitnowIdField.style.display = 'none';
        cashMessage.style.display = 'block';
        cardNumberField.style.display = 'none';
        duitnowIdField.required = false;
        duitnowIdField.disabled = true;
        cardNumberField.required = false;
        cardNumberField.disabled = true;
        duitnowIdField.pattern = ""; // Clear the pattern
        duitnowIdField.title = ""; // Clear the title
    } else if (this.value === 'card') {
        paymentFields.style.display = 'block';
        duitnowIdField.style.display = 'none';
        cashMessage.style.display = 'none';
        cardNumberField.style.display = 'block';
        duitnowIdField.required = false;
        duitnowIdField.disabled = true;
        cardNumberField.required = true;
        cardNumberField.disabled = false;
        cardNumberField.pattern = "\\d{16}"; // Validate for exactly 16 digits
        cardNumberField.title = "Please enter a 16-digit card number";
    } else {
        paymentFields.style.display = 'none';
        duitnowIdField.required = false;
        duitnowIdField.disabled = true;
        cardNumberField.required = false;
        cardNumberField.disabled = true;
        duitnowIdField.pattern = ""; // Clear the pattern
        duitnowIdField.title = ""; // Clear the title
        cardNumberField.pattern = ""; // Clear the pattern
        cardNumberField.title = ""; // Clear the title
    }

    // Trigger validation on the form to update the form control state
    var form = document.getElementById('payment_form');
    form.reportValidity();
});


    </script>

</body>
</html>


