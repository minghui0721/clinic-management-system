<?php 

session_start();


?>


<div class="container-fluid">
	<form action="" id="signup-frm">
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
			<textarea cols="30" rows="3" name="address" required="" class="form-control"></textarea>
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
			<select name="allergic"  required="" class="form-control" onchange="yesnoCheck(this);">
				<option value="">Choose the medication you are allergic to</option>
				<option value="penicillin and related antibiotics.">Penicillin and related antibiotics.</option>
				<option value="antibiotics containing sulfonamides (sulfa drugs)">Antibiotics containing sulfonamides (sulfa drugs)</option>
				<option value="anticonvulsants.">Anticonvulsants.</option>
				<option value="no allergic">No allergic</option>
				<option value="other">Others</option>
			</select>
		</div>

		<div id="ifYes" style="display: none;">
			<label for="other">Allergic</label> <input type="text" id="other" name="other" /><br />
		</div>



		<button class="button btn btn-info btn-sm" name="btnCreate" value ="create">Create</button>
	</form>
</div>

<style>
	#uni_modal .modal-footer{
		display:none;
	}
</style>
<script>

	function yesnoCheck(that) {
		if (that.value == "other") {
			document.getElementById("ifYes").style.display = "block";
		} else {
			document.getElementById("ifYes").style.display = "none";
		}
	}

	$('#signup-frm').submit(function(e){
		e.preventDefault()
		$('#signup-frm button[type="submit"]').attr('disabled',true).html('Saving...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'admin/ajax.php?action=signup',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#signup-frm button[type="submit"]').removeAttr('disabled').html('Create');

			},
			success:function(resp){
				if(resp == 1){
					location.reload();
				} else{
					$('#signup-frm').prepend('<div class="alert alert-danger">Email already exist.</div>')
					$('#signup-frm button[type="submit"]').removeAttr('disabled').html('Create');
					console.log(resp);
				}
			}
		})
	})
</script>