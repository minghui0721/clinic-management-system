<?php
include ('admin/db_connect.php');

// Retrieve available services options from the medical_specialty table
$options_query = "SELECT name FROM medical_specialty";
$options_result = mysqli_query($conn, $options_query);
$services = array();

if ($options_result) {
    while ($row = mysqli_fetch_assoc($options_result)) {
        $services[] = $row['name'];
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
                <input type="time" value="" name="time" class="form-control" required>
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
                <button class="btn btn-secondary btn-sm col-md-4  " type="button" data-dismiss="modal" id="">Close</button>
            </div>
        </form>
    </div>
</div>

<script>
    $("#manage-appointment").submit(function (e) {
        e.preventDefault()
        start_load()
        $.ajax({
            url: 'admin/ajax.php?action=set_appointment',
            method: 'POST',
            data: $(this).serialize(),
            success: function (resp) {
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
</script>
