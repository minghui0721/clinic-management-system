<?php
include 'db_connect.php';

// Retrieve career records
$qry = $conn->query("SELECT * from career");
$careers = array();
while($row = $qry->fetch_assoc()){
    $careers[] = $row;
}
?>

<div class="container-fluid">
    <div class="card col-lg-12">
        <div class="card-body">
            <form action="" id="manage-career">

                <div class="form-group">
                    <input type="hidden" id="career_id" name="career_id" value="">
                </div>

  
                <div class="form-group">
                    <label for="name" class="control-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="" required>
                </div>
                <div class="form-group">
                    <label for="description" class="control-label">Description</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <label for="type" class="control-label">Type (0 = Full-Time / 1 = Part-Time)</label>
                    <input type="text" class="form-control" id="type" name="type" value="" required>
                </div>
                <center>
                    <button class="btn btn-info btn-primary btn-block col-md-2" data-id="<?php echo $career['career_id']; ?>">Save</button>
                </center>
            </form>
        </div>
    </div>

    <br>

    <div class="card col-lg-12">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Career ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($careers as $career): ?>
                        <tr>
                            <td><?php echo $career['career_id']; ?></td>
                            <td><?php echo $career['name']; ?></td>
                            <td><?php echo $career['description']; ?></td>
                            <td><?php echo $career['type']; ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary edit_career" data-id="<?php echo $career['career_id']; ?>">Edit</button>
                                <button class="btn btn-sm btn-danger delete_career" data-id="<?php echo $career['career_id']; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        // Edit career record
        $('.edit_career').click(function(){
            var career_id = $(this).data('id');
            var career = <?php echo json_encode($careers); ?>;

            // Find the selected career record
            var selectedCareer = career.find(function(c){
                return parseInt(c.career_id) === career_id; // Convert to integer
            });

            // Check if selectedCareer is valid
            if (selectedCareer) {
                // Populate the form fields with selected career data
                $('#career_id').val(selectedCareer.career_id); // Set the career_id value
                $('#name').val(selectedCareer.name);
                $('#description').val(selectedCareer.description);
                $('#type').val(selectedCareer.type);
            } else {
                console.log('Selected career record not found.');
            }
        });

        // Delete career record
        $('.delete_career').click(function(){
            var career_id = $(this).data('id');
            
            // Show confirmation dialog before deleting
            if(confirm('Are you sure you want to delete this career record?')){
                // Perform AJAX request to delete the career record
                $.ajax({
                    url:'ajax.php?action=delete_career',
                    data: {career_id: career_id},
                    method: 'POST',
                    success:function(resp){
                        if(resp == 1){
                            alert('Career record deleted successfully.');
                            location.reload();
                        }else{
                            alert('Error deleting career record.');
                        }
                    }
                });
            }
        });

        // Save career record
        $('#manage-career').submit(function(e){
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            var careerId = $('#career_id').val(); // Retrieve the career_id value from the hidden input field
            // Add the career_id value to the formData
            formData.append('career_id', careerId);
            // Perform AJAX request to save the career record
            $.ajax({
                url:'ajax.php?action=save_career',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                success:function(resp){
                    if(resp == 1){
                        alert('Career record saved successfully.');
                        location.reload();
                    }else{
                        alert('Error saving career record.');
                    }
                }
            });
        });
    });
</script>

