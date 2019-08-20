	<?php 
	//echo md5(123456);
		//echo get_cookie('email_cookie');
		//echo get_cookie('password_cookie');
	 ?>
	<!-- Simple login form -->
					<form action="<?php echo base_url('authentication/check_login'); ?>" id="loginform" method="POST">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
								<h5 class="content-group">Login to your account <small class="display-block">Enter your credentials below</small></h5>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<div class="form-control-feedback">
									<i class="icon-envelop text-muted"></i> 
								</div>
								<input type="text" class="form-control" placeholder="Email" name="email" id="email" value="<?php if (get_cookie('email_cookie')!=null)
								{
									echo get_cookie('email_cookie');
								}?>">
								
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								<input type="password" class="form-control" placeholder="Password" name="password" id="password" value="<?php if (get_cookie('password_cookie')!= null)
								{
									echo get_cookie('password_cookie');
								}?>">
							</div>
							<div class="form-group login-options">
								<div class="row">
									<div class="col-sm-6">
										<label class="checkbox-inline">
											<input type="checkbox" class="styled" name="remember" <?php if (get_cookie('email_cookie')!=null)
											 {
												echo "checked";
											} ?>>
											Remember
										</label>
									</div>

									<div class="col-sm-6 text-right">
										<a href="<?php echo base_url('authentication/forgot_password'); ?>">Forgot password?</a>
									</div>
								</div>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></button>
							</div>

							
						</div>
					</form>
					<!-- /simple login form -->

<script type="text/javascript">
	$(function () {

	          //Login form validation
    $("#loginform").validate({
        rules: {
            email: {
                    required: true,
                    email: true
                },
            password: {
                required: true
            }
        },
        messages: {
            email: {
                  required:"<?php echo _l('required_field_msg', _l('email')) ?>",
                    email:"<?php echo _l('required_field_valid', _l('email')) ?>"

            },
            password:{
                 required:"Please Enter Password"
            },

        }
        
    });  
    });
</script>
