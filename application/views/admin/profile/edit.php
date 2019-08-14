<?php 
	$session = $this->session->userdata('user');
	// print_r($user['password']);
	$password_user=$user['password'];
 ?>

				<div class="content">
					<!-- Centered forms -->
					<div class="row">
						
						<div class="col-md-7">
							<form action="<?php echo base_url('admin/myprofile/edit/') ?>" id="myprofileform" method="POST">
								<div class="panel panel-flat">
									<div class="panel-heading">
										<div class="row">
											<div class="col-md-10">
												<h5 class="panel-title"><?php echo $user['firstname'].'&nbsp;'.$user['lastname']; ?></h5>
											</div>
										</div>
									</div>
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>First name:</label>
													<input type="text" class="form-control" placeholder="Firstname" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>">
												</div>
												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>Last name:</label>
													<input type="text" class="form-control" placeholder="Lastname" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>">
												</div>

												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>Email:</label>
													<input type="text" class="form-control" placeholder="Email" id="email" name="email" class="email"value="<?php echo $user['email']; ?>">
												</div>

												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>Contact No:</label>
													<input type="text" class="form-control" placeholder="Contact No" id="mobile_no" name="mobile_no" value="<?php echo $user['mobile_no']; ?>">
												</div>
											
											
											<div class="form-group" align="right">
											<!-- 	<a href="" class="btn btn-success">View Profile</a> -->
												<button type="submit" class="btn btn-primary" name="submit" id="save">Save</button>
											</div>
										</div>
										</div>
									</div>
									</form>
								</div>
							
						</div>
						<div class="col-md-5">
							<form action="<?php echo base_url('admin/myprofile/update_password/') ?>" id="mypasswordform" method="POST">
								<div class="panel panel-flat">
									<div class="panel-heading">
										<div class="row">
											<div class="col-md-10">
												<h5 class="panel-title">Change Password</h5>
											</div>
										</div>
									</div>
									<div class="panel-body">
										<div class="row">
												<div class="form-group">
												
													<small>Last Password changed as on <?php echo time_stamp($user['last_password_change']); ?> </small>
													
												</div>
												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>Old Password:</label>
													<input type="password" name="password" class="form-control" placeholder="Password" id="password">
													<span class="msg"></span>
												</div>
												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>New Password:</label>
													<input type="password" class="form-control" placeholder="Password" id="newpassword" name="newpassword">
													<a class="btn toggle">
														<span>
														<!-- <label>
															 -->
													
													<i class="icon-eye"></i><!-- 
														</label> -->
													<!-- </div> -->
													</span>

													</a>
													Show Password
												</div>
												<div class="form-group">
													<label>Repeat New Password:</label>
													<input type="password" class="form-control" placeholder="Password" id="repeat_password" name="repeat_password">
													<span class="valid"></span>
												</div>

											<div class="form-group" align="right">
												<button type="submit" class="btn btn-primary" name="submit_password" id="submit_password">Save</button>
										
											</div>
										</div>
									</div>
									
								</div>
							</form>
						</div>
						
					</div>
					
				
				<!-- /content area -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<!-- <script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
 --><script type="text/javascript">
$(function () {
    $("#myprofileform").validate({
        rules: {
        	firstname:
        	{
        		 required: true,
        	},
        	lastname:
        	{
        		 required: true,
        	},
        	mobile_no: {
                    required: true,
                    // digit: true
                },

            email: {
                    required: true,
                    email: true
                },
           
        },
        messages: {
        	firstname: {
                 required:"Please Enter your Firstname",
                    // email:"Please enter a valid email address"

            },
            lastname: {
                 required:"Please Enter your Lastname",
                    // email:"Please enter a valid email address"

            },
              mobile_no: {
                 required:"Please Enter your Contact No",
                   mobile_no:"Please Enter Digits"

            },
            email: {
                 required:"Please Enter your email",
                    email:"Please Enter a valid email address"

            },
            

        }
        
    });  
     $("#mypasswordform").validate({
        rules: {
        	password:
        	{
        		 required: true,
        	},
        	newpassword:
        	{
        		 required: true,
        	},  

        },
        messages: {
        	password: {
                 required:"Please Enter your old password",
                    // email:"Please enter a valid email address"

            },
            newpassword: {
                 required:"Please Enter password",
                    // email:"Please enter a valid email address"

            },
            repeat_password: {
                 required:"Please Enter valid Password",
                    // email:"Please enter a valid email address"

            },
            
        }
        
    }); 
     });
$("#password").change(function(event) {
	event.preventDefault();
	var old_password =  CryptoJS.MD5($('#password').val());
	
	var user_password = "<?php  echo $user['password']; ?>";
	if (user_password==old_password)
	 {
	 	 $(".msg").html("<strong style='color:green'>Password Match</strong>");
	 	//toastr.success('Password Match');
	 }
	 
	 else
	 {
	 	 $(".msg").html("<strong style='color:red'>Password Not Match</strong>");
	 	 return false;
	 }
});
$("#repeat_password").change(function(event) {
	event.preventDefault();
	var newpassword = $('#newpassword').val();
	var repeat_password = $('#repeat_password').val();

	if (newpassword==repeat_password)
	 {
	 	 $(".valid").html("<strong style='color:green'>Repeat Password Match</strong>");
	 	
	 }
	 else
	 {
	 	 $(".valid").html("<strong style='color:red'>Repeat Password Not Match</strong>");
	 }
	
});
$("#newpassword").change(function(event) {
	event.preventDefault();
	var newpassword = $('#newpassword').val();
	var repeat_password = $('#repeat_password').val();

	if (newpassword==repeat_password)
	 {
	 	 $(".valid").html("<strong style='color:green'>Repeat Password Match</strong>");
	 	
	 }
	 else
	 {
	 	 $(".valid").html("<strong style='color:red'>Repeat Password Not Match</strong>");
	 }
	
});
$('.toggle').on('click',function(e){
e.preventDefault();
// alert(
// 	'yes');
var x = document.getElementById("newpassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
});
</script> 

