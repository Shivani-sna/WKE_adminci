 <!-- page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4></i> <span class="text-semibold">Edit User</span></h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<?php  ?>
							<li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a></li>
							<li><a href="<?php echo base_url('admin/users'); ?>">Users</a></li>
							<li class="active">Edit</li>

						</ul>
					</div>
				</div>
				<!-- page header -->


				<!-- Content area -->
				<div class="content">

					

					<!-- Centered forms -->
					<div class="row">
						
						<div class="col-md-8 col-md-offset-2">
							<form action="<?php echo base_url('admin/users/edit/').$user['id']; ?>" id="profileform" method="POST">
								<div class="panel panel-flat">
									<div class="panel-heading">
										<div class="row">
											<div class="col-md-10">
												<h5 class="panel-title"><strong>User</strong></h5>
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
												<div class="form-group">
													<small class="req text-danger">* </small>
													<label>Change Password:</label>
													<input type="password" class="form-control" placeholder="New Password" id="password" name="newpassword" value="" >
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
													
													<label>Status:</label>
												 <?php 
													$readonly = '';
													if ($user['id']==get_loggedin_info('user_id')	)
													 {
														 $readonly="readonly";
													} 

													 ?> 
												<input type="checkbox" class="switch" 
												id="<?php echo $user['id']; ?>" <?php 
												if($user['is_active']==1)
												{
														echo "checked";
												} ?>  <?php  echo $readonly; ?>>
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
										
											
												
		<option value="<?php echo $role['id']; ?>" name="role"
			<?php if($user['role']==$role['id'])
			{
				echo  "selected";
			} 
			else
			{
				echo '';
			} ?>><?php echo $role['name'] ?>
			
		</option>
												
														<?php

														}

													 ?>

											
													 </select>

								
												</div>
											</div>
										</div>
									</div>
									
								</div>
							
						</div>
						
					</div>
					<!-- /form centered -->
					<div class="btn-bottom-toolbar text-right btn-toolbar-container-out">
						<button type="submit" class="btn btn-success" name="submit">Save</button>
						 <a class="btn btn-default" onclick="window.history.back();">Back</a>
        				 
      				</div>
					</form>
				</div>
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
            }
        },
        messages: {
        	firstname: {
                 required:"<?php echo _l('required_field_msg', _l('firstname')) ?>",
                    // email:"Please enter a valid email address"

            },
            lastname: {
                 required:"<?php echo _l('required_field_msg', _l('lastname')) ?>",
                    // email:"Please enter a valid email address"

            },
              mobile_no: {
                 required:"<?php echo _l('required_field_msg', _l('contact_no')) ?>",
                   mobile_no:"Please Enter Digits"

            },
            email: {
                 required:"<?php echo _l('required_field_msg', _l('email')) ?>",
                    email:"<?php echo _l('required_field_valid', _l('email')) ?>"

            },
            password:{
                 required:"<?php echo _l('required_field_msg', _l('password')) ?>"
            },
             role:{
                 required:"<?php echo _l('select', _l('contact_no')) ?>"
            },

        }
        
    });  
    });
</script>
<script type="text/javascript">  
$('#password, #confirm_password').on('keyup', function () {
  if ($('#password').val() == $('#confirm_password').val()) {
    $('#message').html('Password match').css({'font-weight': 'bold','color':'green'});
  } else 
    $('#message').html('Password not Matching').css({'font-weight': 'bold','color':'red'});
});
</script>  
<script type="text/javascript">
$( document ).ready(function() 
{
	
/*Update User Status Jquery for checkbox switch */
	$(".switch").change(function()
	 {
	 	
   	  var check = 0;
      var BASE_URL = "<?php echo base_url(); ?>";
      var id = $(this).attr('id');
      
      //console.log(id);

      
       	if($(this).is(":checked")) 
       {
       		check = 1;
       }
     // console.log(check);

       $.ajax({
              		url:BASE_URL+'admin/users/update_status',
              		type: 'POST',
              		data: {
              			    user_id:id,
              			    is_active:check
              			 },
              			  success:function(data)
               {
               	if (data=='Active')
                    {
                      toastr.success("<?php echo _l('activation_msg', _l('user')); ?>");
                    }
                    else
                    {
                        toastr.success("<?php echo _l('deactivation_msg', _l('user')); ?>");
                    }
               }
              	})
	 });
/* End of Update User Status Jquery for checkbox switch  */

$('.toggle').on('click',function(e){
e.preventDefault();
// alert(
// 	'yes');
var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
});

	});
/* end of document ready */
</script>