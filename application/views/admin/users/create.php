<!-- page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4></i> <span class="text-semibold">Add User</span></h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<?php  ?>
							<li><a href="<?php echo base_url('admin/home'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a></li>
							 <li><a href="<?php echo base_url('admin/users'); ?>">Users</a></li>
							<li class="active">Add</li>

						</ul>
					</div>
				</div>
				<!-- page header -->

				<!-- Content area -->
				<div class="content">

					

					<!-- Centered forms -->
					<div class="row">
						
						<div class="col-md-8 col-md-offset-2">
							<form action="<?php echo base_url('admin/users/insert'); ?>" id="profileform" method="POST">
								<div class="panel panel-flat">
									<div class="panel-heading">
										<div class="row">
											<div class="col-md-10">
												<h5 class="panel-title">Profile</h5>
												<!-- <div class="heading-elements">
													<ul class="icons-list">
								                		<li><a data-action="collapse"></a></li>
								                		<li><a data-action="reload"></a></li>
								                		<li><a data-action="close"></a></li>
								                	</ul>
							                	</div> -->
											</div>
										</div>
									</div>
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>First name:</label>
													<input type="text" class="form-control" placeholder="Firstname" id="firstname" name="firstname">
												</div>
												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>Last name:</label>
													<input type="text" class="form-control" placeholder="Lastname" id="lastname" name="lastname">
												</div>

												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>Email:</label>
													<input type="text" class="form-control" placeholder="Email" id="email" name="email" class="email">
												</div>

												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>Contact No:</label>
													<input type="text" class="form-control" placeholder="Contact No" id="mobile_no" name="mobile_no">
												</div>
												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>Password:</label>
													<!-- <div class="col-md-12"> -->
													<input type="password" class="form-control" placeholder="Password" id="password" name="password" >
													
												</div>
												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>Confirm Password:</label>
													<input type="password" id="confirm_password" class="form-control" placeholder="Password">
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
												</br>
												<span id="message"></span>

												</div>

												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>Select Role</label>

										<select class="select" name="role" id="role">
											<!-- <option>Select Role</option> -->
													<?php 
															foreach ($roles as $key => $role)
															 {
															 	?>
																<div class="form-group">
										
											
												
											
												<option value="<?php echo $role['id']; ?>" name="role"><?php echo $role['name'] ?></option>
												
														<?php

														}

													 ?>

											
													 </select>

								
												</div>
												<div>
													<a href="<?php echo base_url('admin/roles/insert'); ?>" class="btn-xs btn-primary">Add New Role</a>
												</div>
												
												
											</div>
										</div>
									</div>
									
								</div>
							
						</div>
						
					</div>
					<!-- /form centered -->
					<div class="btn-bottom-toolbar text-right btn-toolbar-container-out">
						<button type="submit" class="btn btn-primary" name="submit">Save</button>
						 <a class="btn btn-success" onclick="window.history.back();">Back</a>
        				 
      				</div>
					</form>
				
				<!-- /content area -->

<script type="text/javascript">
$(function () {
    $("#profileform").validate({
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
            password: {
                required: true
            },
             role: {
                required: true
            }
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
            password:{
                 required:"Please Enter Password"
            },
             role:{
                 required:"Please Select Role"
            },

        }
        
    });  
    });
</script>
<script type="text/javascript">  
$(' #confirm_password').on('change', function () {
  if ($('#password').val() != $('#confirm_password').val()) {
  	$('#message').html('Confirm Passsword Not Match').css({'font-weight': 'bold','color':'red'});
   return false;
  } else 
  {
  	 $('#message').html('Password match').css({'font-weight': 'bold','color':'green'});
  }
    
});

$('#password').on('change', function () {
  if ($('#password').val() != $('#confirm_password').val()) 
  {
  	$('#message').html('Confirm Passsword Not Match').css({'font-weight': 'bold','color':'red'});
   return false;
  } else 
  {
  	 $('#message').html('Password match').css({'font-weight': 'bold','color':'green'});
  }
    
});
$('.toggle').on('click',function(e){
e.preventDefault();
// alert(
// 	'yes');
var x = document.getElementById("confirm_password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
});
</script>  
