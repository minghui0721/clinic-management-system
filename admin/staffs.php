<?php include('db_connect.php');?>

<script>
function updateStaff() {
			var form = document.getElementById('edit-form');
			var staff_id = form.querySelector('#edit-staff-id').value;
			var name = form.querySelector('#edit-name').value;
			var address = form.querySelector('#edit-address').value;
			var contact = form.querySelector('#edit-contact').value;
			var email = form.querySelector('#edit-email').value;
			var salary = form.querySelector('#edit-salary').value;
			var img_path = ''; // Default image path

			if (form.querySelector('#edit-img')) {
				img_path = form.querySelector('#edit-img').value; // Get the current image path if it exists
			}

			// Create the SQL query to update the staff member
			var query = "UPDATE staff_list SET staff_id = '" + staff_id + "', name = '" + name + "', address = '" + address + "', contact_number = '" + contact + "', email = '" + email + "', salary = " + salary + ", img_path = '" + img_path + "' WHERE staff_id = " + staff_id;

			// Create and send a POST request
			var request = new XMLHttpRequest();
			request.open('POST', 'update_staff.php', true);

			// Handle the response
			request.onload = function() {
				if (request.status === 200) {
					var resp = request.responseText;
					if (resp == 1) {
						alert("Data successfully updated");
						location.reload();
					} else {
						alert("Failed to update data");
					}
				} else {
					alert("Error occurred during the request");
				}
			};

			// Send the query as form data
			var formData = new FormData();
			formData.append('query', query);
			request.send(formData);
		}
</script>



<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-doctor">
				<div class="card">
					<div class="card-header">
						   Staff's Form
				  	</div>
					<div class="card-body">
							<div id="msg"></div>
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Name</label>
								<textarea name="name" id="" cols="30" rows="2" class="form-control" required=""></textarea>
							</div>

                            <div class="form-group">
								<label class="control-label">Address</label>
								<textarea name="address" id="" cols="30" rows="2" class="form-control" required=""></textarea>
							</div>
						
							<div class="form-group">
								<label for="" class="control-label">Contact Number</label>
								<textarea name="contact" id="" cols="30" rows="2" class="form-control" required=""></textarea>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Email</label>
								<input type="email" class="form-control" name="email" required="">
							</div>
							<div class="form-group">
								<label for="" class="control-label">Salary</label>
								<input type="number" class="form-control" name="salary" required="">
							</div>
							<div class="form-group">
								<label for="" class="control-label">Password</label>
								<input type="password" class="form-control" name="password" >
							</div>
							<div class="form-group">
								<label for="" class="control-label">Image</label>
								<input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
							</div>
							<div class="form-group">
								<img src="" alt="" id="cimg">
							</div>	
							
							
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="_reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Image</th>
									<th class="text-center">Info</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$cats = $conn->query("SELECT * FROM staff_list order by staff_id asc");
								while($row=$cats->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center">
										<img src="../assets/img/<?php echo $row['img_path'] ?>" alt="">
									</td>
									<td class="">
										<p>ID: <b><?php echo $row['staff_id'] ?></b></p>
										<p><small>Name: <b><?php echo $row['name'] ?></b></small></p>
										<p><small>Email: <b><?php echo $row['email'] ?></b></small></p>
										<p><small>Contact: <b><?php echo $row['contact_number'] ?></b></small></p>
										<p><small>Salary: <b>RM<?php echo $row['salary'] ?></b></small></p>
										<p><small>Address: <b><?php echo $row['address'] ?></b></small></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit-staff" type="button" data-id="<?php echo $row['staff_id'] ?>" data-name="<?php echo $row['name'] ?>" data-contact="<?php echo $row['contact_number'] ?>" data-img_path="<?php echo $row['img_path'] ?>" data-email="<?php echo $row['email'] ?>" data-salary="<?php echo $row['salary'] ?>" data-address="<?php echo $row['address'] ?>">Edit</button>
										<button class="btn btn-sm btn-danger delete_staff" type="button" data-id="<?php echo $row['staff_id'] ?>">Delete</button>
									</td>

								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>

<!-- Add the following HTML code before the closing </body> tag -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Staff Member</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit-form">
          <div class="form-group">
            <label for="edit-staff-id">Staff ID</label>
            <input type="text" id="edit-staff-id" name="staff_id" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label for="edit-name">Name</label>
            <textarea id="edit-name" name="name" class="form-control" rows="2" required=""></textarea>
          </div>
          <div class="form-group">
            <label for="edit-address">Address</label>
            <textarea id="edit-address" name="address" class="form-control" rows="2" required=""></textarea>
          </div>
          <div class="form-group">
            <label for="edit-contact">Contact Number</label>
            <textarea id="edit-contact" name="contact" class="form-control" rows="2" required=""></textarea>
          </div>
          <div class="form-group">
            <label for="edit-email">Email</label>
            <input type="email" id="edit-email" name="email" class="form-control" required="">
          </div>
          <div class="form-group">
            <label for="edit-salary">Salary</label>
            <input type="number" id="edit-salary" name="salary" class="form-control" required="">
          </div>
          <div class="form-group">
            <label for="edit-img">Image</label>
            <input type="file" id="edit-img" name="img" class="form-control" onchange="displayImg(this,$(this))">
          </div>
          <div class="form-group">
            <img src="" alt="" id="edit-cimg" style="max-width:100px; max-height:150px;">
          </div>
          <input type="hidden" id="edit-id" name="id">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="updateStaff()">Save Changes</button>
      </div>
    </div>
  </div>
</div>


<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height: :150px;
	}
</style>


<script>
	function _reset(){
		$('[name="id"]').val('');
		$('#manage-doctor').get(0).reset();
	}

	$(document).ready(function() {
		// Initialize DataTable
		var table = $('table').DataTable();

		// Form submission
		$('#manage-doctor').submit(function(e){
			e.preventDefault();
			start_load();
			$('#msg').html('');
			$.ajax({
				url:'ajax.php?action=save_staff',
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				success:function(resp){
					if(resp==1){
						alert_toast("Data successfully added",'success');
						setTimeout(function(){
							location.reload();
						},1500);
					}
					else if(resp==2){
						$('#msg').html('<div class="alert alert-danger">Email already exists.</div>');
						end_load();
					}
				}
			});
		});

		// Display selected image
		function displayImg(input,_this) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#cimg').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}

		// Edit staff member
		$('table').on('click', '.edit-staff', function() {
			var staff_id = $(this).attr('data-id');
			var name = $(this).attr('data-name');
			var address = $(this).attr('data-address');
			var contact = $(this).attr('data-contact');
			var email = $(this).attr('data-email');
			var salary = $(this).attr('data-salary');
			var img_path = $(this).attr('data-img_path');

		// Set the values in the edit modal form fields
			$('#edit-staff-id').val(staff_id);
			$('#edit-name').val(name);
			$('#edit-address').val(address);
			$('#edit-contact').val(contact);
			$('#edit-email').val(email);
			$('#edit-salary').val(salary);
			$('#edit-cimg').attr('src', '../assets/img/' + img_path);

		// Show the edit modal
		$('#editModal').modal('show');
	});

		
	



		// Delete staff member
		$('table').on('click', '.delete_staff', function() {
            var staffID = $(this).attr('data-id');
            var confirmDelete = confirm("Are you sure you want to delete this staff member?");
            if (confirmDelete) {
                delete_staff(staffID);
            }
        });


		function delete_staff(staff_id){
			start_load();
			$.ajax({
				url:'ajax.php?action=delete_staff',
				method:'POST',
				data:{staff_id: staff_id},
				success:function(resp){
					if(resp==1){
						alert_toast("Data successfully deleted",'success');
						setTimeout(function(){
							location.reload();
						},1500);
					} else{
                        alert("hi");
                    }
				}
			});
		}


	});
</script>
