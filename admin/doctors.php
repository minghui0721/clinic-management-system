<?php include('db_connect.php'); ?>

<script>


function updateDoctor() {
  var form = document.getElementById('edit-form');
  var id = form.querySelector('#edit-id').value;
  var name_pref = form.querySelector('#edit-name-pref').value;
  var name = form.querySelector('#edit-name').value;
  var specialty_ids = Array.from(form.querySelectorAll('#edit-name-specialty option:checked')).map(option => option.value);
  var clinic_address = form.querySelector('#edit-address').value;
  var contact = form.querySelector('#edit-contact').value;
  var email = form.querySelector('#edit-email').value;
  var img_path = ''; // Default image path

  if (form.querySelector('#edit-img')) {
	img_path = form.querySelector('#edit-img').value; // Get the current image path if it exists
}

  // Create the SQL query to update the doctor
  var specialty_ids_string = JSON.stringify(specialty_ids).replace(/['"]+/g, ''); // Convert the array to a JSON string and remove the single quotes

// Create the SQL query to update the doctor
var query = `UPDATE doctors_list SET id = '${id}', name = '${name}', name_pref = '${name_pref}', clinic_address = '${clinic_address}', contact = '${contact}', email = '${email}', specialty_ids = '${specialty_ids_string}', img_path = '${img_path}' WHERE id = '${id}'`;


  // Create and send a POST request
  var request = new XMLHttpRequest();
  request.open('POST', 'update_doctor.php', true);

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
						   Doctor's Form
				  	</div>
					<div class="card-body">
							<div id="msg"></div>
							<input type="hidden" name="id">
							<div class="form-group">
								<label for="" class="control-label">Prefix</label>
								<input type="text" class="form-control" name="name_pref" placeholder="(M.D.)" required="">
							</div>
							<div class="form-group">
								<label class="control-label">Name</label>
								<textarea name="name" id="" cols="30" rows="2" class="form-control" required=""></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Medical Specialties</label>
								<select name="specialty_ids[]" id="" multiple=""  class="custom-select browser-default select2">
									<option value=""></option>
									<?php 
									$qry = $conn->query("SELECT * FROM medical_specialty order by name asc");
										while($row=$qry->fetch_assoc()):
									 ?>
									<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
									<?php endwhile; ?>
								</select>
							</div>
							<div class="form-group">
								<label class="control-label">Address</label>
								<textarea name="address" id="" cols="30" rows="2" class="form-control" required=""></textarea>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Contact</label>
								<textarea name="contact" id="" cols="30" rows="2" class="form-control" required=""></textarea>
							</div>
							<div class="form-group">
								<label for="" class="control-label">Email</label>
								<input type="email" class="form-control" name="email" required="">
							</div>
							<div class="form-group">
								<label for="" class="control-label">Password</label>
								<input type="password" class="form-control" name="password" required>
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
								$cats = $conn->query("SELECT * FROM doctors_list order by id asc");
								while($row=$cats->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="text-center">
										<img src="../assets/img/<?php echo $row['img_path'] ?>" alt="">
									</td>
									<td class="">
										 <p>ID: <b><?php echo $row['id'] ?></b></p>
										 <p><small>Prefix: <b><?php echo $row['name_pref'] ?></b></small></p>
										 <p><small>Name: <b><?php echo $row['name'] ?></b></small></p>
										 <p><small>Email: <b><?php echo $row['email'] ?></b></small></p>
										 <p><small>Clinic Address: <b><?php echo $row['clinic_address'] ?></b></small></p>
										 <p><small>Contac #: <b><?php echo $row['contact'] ?></b></small></p>
										 <p><small><a href="javascript:void(0)" class="view_schedule" data-id="<?php echo $row['id'] ?>" data-name="<?php echo "Dr. ".$row['name'].', '.$row['name_pref'] ?>"><i class='fa fa-calendar'></i> Schedule</a></b></small></p>

									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit-doctor" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-name-pref="<?php echo $row['name_pref'] ?>" data-address="<?php echo $row['clinic_address'] ?>" data-contact="<?php echo $row['contact'] ?>"  data-img_path="<?php echo $row['img_path'] ?>" data-specialty_ids="<?php echo $row['specialty_ids'] ?>" data-email="<?php echo $row['email'] ?>">Edit</button>
										<button class="btn btn-sm btn-danger delete_doctor" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Doctor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit-form">
          <div class="form-group">
            <label for="edit-id">ID</label>
            <input type="text" id="edit-id" name="id" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label for="edit-name-pref">Name Prefix</label>
            <input type="text" id="edit-name-pref" name="name_pref" class="form-control" required="">
          </div>
          <div class="form-group">
            <label for="edit-name">Name</label>
            <textarea id="edit-name" name="name" class="form-control" rows="2" required=""></textarea>
          </div>
          <div class="form-group">
				<label class="control-label">Medical Specialties</label>
				<select name="specialty_ids[]" id="edit-name-specialty" multiple=""  class="custom-select browser-default select2" required>
					<option value=""></option>
					<?php 
					$qry = $conn->query("SELECT * FROM medical_specialty order by name asc");
					while($row=$qry->fetch_assoc()):
					?>
					<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
					<?php endwhile; ?>
				</select>
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
            <label for="edit-img">Image</label>
            <input type="file" id="edit-img" name="img" class="form-control" onchange="displayImg(this,$(this))">
          </div>
          <div class="form-group">
            <img src="" alt="" id="edit-cimg" style="max-width:100px; max-height:150px;">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="updateDoctor()">Save Changes</button>
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
	$('.select2').select2({
		placeholder:"Please Select Here",
		width:'100%'
	})
	function _reset(){
		$('[name="id"]').val('');
		$('#manage-doctor').get(0).reset();
	}
	
	$('table').dataTable()
	$('#manage-doctor').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_doctor',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					$('#msg').html('<div class="alert alert-danger">Email already exist.</div>')
					end_load()

				}
				else if(resp==0){
					$('#msg').html('<div class="alert alert-danger">Error saving doctor.</div>')
					end_load()
					
				} else{
					alert('hi');
				}
			}
		})
	})


	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	// Edit doctor
	$('table').on('click', '.edit-doctor', function() {
	var id = $(this).attr('data-id');
	var name_pref = $(this).attr('data-name-pref');
	var name = $(this).attr('data-name');
	var address = $(this).attr('data-address');
	var contact = $(this).attr('data-contact');
	var email = $(this).attr('data-email');
	var img_path = $(this).attr('data-img_path');

	// Set the values in the edit modal form fields
	$('#edit-id').val(id);
	$('#edit-name-pref').val(name_pref);
	$('#edit-name').val(name);
	$('#edit-address').val(address);
	$('#edit-contact').val(contact);
	$('#edit-email').val(email);
	$('#edit-cimg').attr('src', '../assets/img/' + img_path);

	// Show the edit modal
	$('#editModal').modal('show');
	});

	

	$('.view_schedule').click(function(){
		uni_modal($(this).attr('data-name')+" - Schedule","view_doctor_schedule.php?id="+$(this).attr('data-id'))
	})


	$('table').on('click', '.delete_doctor', function() {
    _conf("Are you sure to delete this doctor?", "delete_doctor", [$(this).attr('data-id')]);
});

function delete_doctor($id) {
    start_load();
    $.ajax({
        url: 'ajax.php?action=delete_doctor',
        method: 'POST',
        data: { id: $id },
        success: function(resp) {
            if (resp == 1) {
                alert_toast("Data successfully deleted", 'success');
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }
        }
    });
}

</script>