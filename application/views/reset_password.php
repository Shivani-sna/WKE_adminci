<?php 
	// echo md5(123456);
 ?>


					<!-- Password recovery -->
					<form  class="resetform" action="<?php echo base_url('authentication/reset_password/').$user['auth_token']; ?>" method="POST">
						<div class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-warning text-warning"><i class="icon-spinner11"></i></div>
								<h5 class="content-group">Reset Password</h5>
								<small class="display-block"><?php //echo $email; ?></small>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								<input type="password" class="form-control" placeholder="New Password" name="password" id="password">

								
							</div>
							<div class="form-group has-feedback has-feedback-left">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
								<input type="password" class="form-control" placeholder="confirm Password" id="confirm_password">

								<a class="btn toggle" id="check">
														<span>
														<!-- <label>
															 -->
													
													<i class="icon-eye"></i><!-- 
														</label> -->
													<!-- </div> -->
													</span>

														 Show Password
													</a>
												<center><span id="message" align="center"></span></center>
								
							</div>
							
							<button type="submit" class="btn bg-blue btn-block" name="submit">submit <i class="icon-arrow-right14 position-right"></i></button>
						</div>
					</form>
					<!-- /password recovery -->


					
<script type="text/javascript">
	$(function () {
    $(".resetform").validate({
        rules: {
            password: {
                    required: true,
                   
                }
            },
        messages: {
            password: {
                 required:"Please Enter Password",
                 

            }
        }
        
    });  
    });
</script>
<script type="text/javascript">  
	$( document ).ready(function() 
{
$('#confirm_password').on('change', function () 
{
	var password = $('#password').val();
	
	var confirm_password =$('#confirm_password').val();
	console.log(password);
	// if (confirm_password=='')
	//  {
	//  	$('#message').html('Password Empty').css({'tex-align': 'center','color':'red'});
	//  	return false;
	//  }
	// alert($('#confirm_password').val());
  if (password == confirm_password) 
  {
    $('#message').html('Confirm Password match').css({'color':'green'});
  } 
  else if(password=='')
  {
  	$('#message').html('Please Enter Password').css({'tex-align': 'center','color':'red'});
  }
  else
   {
   	$('#message').html('Confirm Password Not Match').css({'tex-align': 'center','color':'red'});
   }
    
});
$('.toggle').on('click',function(e){
e.preventDefault();

var x = document.getElementById("confirm_password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
});
});
</script> 
