<?php 
	$session = $this->session->userdata('user');

 ?>
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
							<li><a href="<?php echo base_url('admin/home'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a></li>
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
							<form action="<?php echo base_url('admin/users/update/').$user['id']; ?>" id="profileform" method="POST">
								<div class="panel panel-flat">
									<div class="panel-heading">
										<div class="row">
											<div class="col-md-10">
												<h5 class="panel-title">Profile</h5>
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
													<label>Password:</label>
													<input type="password" class="form-control" placeholder="Password" id="password" name="password" value="<?php echo $user['password']; ?>" >
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
													if ($user['id']==$session['id'])
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
               	swal('','Status Updated', "success");swal('','Status Updated', "success");
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