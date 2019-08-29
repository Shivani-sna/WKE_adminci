<!-- Password recovery -->
<form  class="recoveryform" action="<?php echo base_url('authentication/forgot_password') ?>" method="POST">
	<div class="panel panel-body login-form">
		<div class="text-center">
			<div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
			<h5 class="content-group">Password recovery <small class="display-block">We'll send you instructions in email</small></h5>
		</div>

		<div class="form-group has-feedback">
			<div class="form-control-feedback">
				<i class="icon-mail5 text-muted"></i>
			</div>
			<input type="email" class="form-control" placeholder="Your email" name="email" id="email">
			
		</div>

		<button type="submit" class="btn bg-blue btn-block" name="submit">Reset password <i class="icon-arrow-right14 position-right"></i></button>
	</div>
</form>
<!-- /password recovery -->					
<script type="text/javascript">
	$(function () {
    $(".recoveryform").validate({
        rules: {
            email: {
                    required: true,
                    email: true
                }
            },
        messages: {
            email: {
                 required:"Please Enter your email",
                    email:"Please enter a valid email address"

            }
        }
        
    });  
    });
</script>
