

<div class="container-fluid">
	<form action="" id="login-frm">
		<div class="form-group">
			<label for="" class="control-label">Email</label>
			<input type="email" name="email" required="" class="form-control">
		</div>
		<div class="form-group">
			<label for="" class="control-label">Password</label>
			<input type="password" name="password" required="" class="form-control">
			<small><a href="javascript:void(0)" id="new_account">Create New Account</a></small>
		</div>

		<button class="button btn btn-info btn-sm" name="btnLogin">Login</button>
	</form>
</div>


<div id="reset_email" style="display: none;">
			<div class="form-group">
				<label for="" class="control-label">Email</label>
				<input type="email" name="reset_email" required="" class="form-control">
				<button id="confirmReset" value="Confirm" type="submit">Confirm</button>
			</div>
</div>

<style>
	#uni_modal .modal-footer{
		display:none;
	}
</style>

<script>
	var loginAttempts = 0;
	$('#new_account').click(function(event){
		if (loginAttempts >= 3) {
			event.preventDefault();
			$('#reset_email').show();
		} else {
			uni_modal("Create an Account",'signup.php?redirect=index.php?page=checkout');
		}
	});

	$('#login-frm').submit(function(e){
		e.preventDefault();
		$('#login-frm button[type="submit"]').attr('disabled', true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0)
			$(this).find('.alert-danger').remove();
		$.ajax({
			url: 'admin/ajax.php?action=login2',
			method: 'POST',
			data: $(this).serialize(),
			error: err => {
				console.log(err);
				$('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
			},
			success: function(resp) {
				if (resp == 1) {
					// Successful login
					var redirect = '<?php echo isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php?page=home' ?>';
					var patientID = '<?php echo isset($_SESSION['patient_id']) ? $_SESSION['patient_id'] : '' ?>';
					var email = encodeURIComponent($('#login-frm input[name="email"]').val());

					var url = redirect;
					if (redirect.indexOf('?') > -1) {
						url += '&';
					} else {
						url += '?';
					}

					if (patientID !== '') {
						url += 'patient_id=' + patientID;
					} else if (email !== '') {
						url += 'email=' + email;
					}

					location.href = url;
				} else {
					// Failed login attempt
					loginAttempts++;
					if (loginAttempts >= 3) {
						$('#new_account').text('Reset Password via Email');
					}
					$('#login-frm').prepend('<div class="alert alert-danger">Email or password is incorrect.</div>');
					$('#login-frm button[type="submit"]').removeAttr('disabled').html('Login');
				}
			}
		});
	});

// JavaScript code to handle the AJAX request and display the response
$('#confirmReset').click(function(e) {
    e.preventDefault();
    var resetEmail = $('input[name="reset_email"]').val();

    // Make an AJAX request to trigger the "reset.php" logic
    $.ajax({
        url: 'reset.php',
        method: 'POST',
        data: { email: resetEmail },
        success: function(response) {
            // Handle the response from "reset.php" if needed
            if (response === '1') {
                $('#reset_email').html('<p>Please check your email to reset the password.</p>');
            } else if (response === '2') {
                $('#reset_email').html('<p>Something went wrong. Please try again later.</p>');
			} else if (response === '3') {
                $('#reset_email').html('<p>Email does not exist. Please register.</p>');
            } else {
				console.log(response);
			}
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
        }
    });
});

</script>
