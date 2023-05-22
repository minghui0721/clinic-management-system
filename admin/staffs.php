<?php include('db_connect.php');?>

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
                                        
										 <p>ID: <b><?php echo $row['staff_id']?></b></p>
										 <p><small>Email: <b><?php echo $row['name'] ?></b></small></p>
										 <p><small>Email: <b><?php echo $row['email'] ?></b></small></p>
										 <p><small>Contact: <b><?php echo $row['contact_number'] ?></b></small></p>
										 <p><small>Salary: <b>RM<?php echo $row['salary'] ?></b></small></p>
			

									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit-staff" type="button" data-id="<?php echo $row['staff_id'] ?>" data-name="<?php echo $row['name'] ?>" data-contact="<?php echo $row['contact_number'] ?>"  data-img_path="<?php echo $row['img_path'] ?>" data-email="<?php echo $row['email'] ?>">Edit</button>
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
		$('table').dataTable();

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
		$('.edit-staff').click(function(){
			start_load();
			var form = $('#manage-doctor');
			form.get(0).reset();
			form.find("[name='id']").val($(this).attr('data-id'));
			form.find("[name='name']").val($(this).attr('data-name'));
			form.find("[name='contact']").val($(this).attr('data-contact'));
			form.find("[name='email']").val($(this).attr('data-email'));
			form.find("[name='salary']").val($(this).attr('data-salary'));
			form.find("#cimg").attr("src","../assets/img/"+$(this).attr('data-img_path'));
			end_load();
		});

		// Delete staff member
		$('.delete_staff').click(function(){
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
