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
								<input type="text" class="form-control" placeholder="Email" name="email" id="email" value="<?php if (isset($get_cookie))
								{
									echo $get_cookie[0];
								}?>">
								
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								<input type="password" class="form-control" placeholder="Password" name="password" id="password" value="<?php if (isset($get_cookie))
								{
									echo $get_cookie[1];
								}?>">
							</div>
							<div class="form-group login-options">
								<div class="row">
									<div class="col-sm-6">
										<label class="checkbox-inline">
											<input type="checkbox" class="styled" name="remember" checked="checked">
											Remember
										</label>
									</div>

									<div class="col-sm-6 text-right">
										<a href="<?php echo base_url('authentication/password_recovery'); ?>">Forgot password?</a>
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
                 required:"Please Enter your email",
                    email:"Please enter a valid email address"

            },
            password:{
                 required:"Please Enter Password"
            },

        }
        
    });  
    });
</script>
