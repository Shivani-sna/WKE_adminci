<!-- page header -->
<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4></i> <span class="text-semibold">Add User</span></h4>
		</div>
	</div>
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
		<li>
			<a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a>
		</li>
		 <li>
		 	<a href="<?php echo base_url('admin/users'); ?>">Users</a>
		 </li>
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
<form action="<?php echo base_url('admin/users/add'); ?>" id="profileform" method="POST">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h5 class="panel-title"><strong>User</strong>
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
						<input type="password" class="form-control" placeholder="Password" id="password" name="password" >
						
					</div>
					<div class="form-group">
						<small class="req text-danger">* </small>
						<label>Confirm Password:</label>
						<input type="password" id="confirm_password" class="form-control" placeholder="Password">
						<a class="btn toggle"><span><i class="icon-eye"></i><</span></a>
						Show Password
					</br>
					<span id="message"></span>

					</div>

					<div class="form-group">
						<small class="req text-danger">* </small>
						<label>Select Role</label>
						<select class="select" name="role" id="role">
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
<!-- /content area -->
<script type="text/javascript">
$(function ()
 {
    $("#profileform").validate
    ({
        rules: {
        	firstname:
        	{
        		 required: true,
        	},
        	lastname:
        	{
        		 required: true,
        	},
        	mobile_no:
        	 {
                required: true,
                digit: true
            },

            email:
            {
                required: true,
                email: true
            },
            password:
            {
                required: true
            },
             role:
            {
                required: true
            }
        },
        messages:
         {
        	firstname:
        	 {
                required:"<?php echo _l('required_field_msg', _l('firstname')) ?>",

            },
            lastname:
             {
                required:"<?php echo _l('required_field_msg', _l('lastname')) ?>",

            },
             mobile_no:
             {
                required:"<?php echo _l('required_field_msg', _l('contact_no')) ?>",
                mobile_no:"Please Enter Digits"

            },
            email:
             {
                required:"<?php echo _l('required_field_msg', _l('email')) ?>",
                email:"<?php echo _l('required_field_valid', _l('email')) ?>"

            },
            password:
            {
                required:"<?php echo _l('required_field_msg', _l('password')) ?>"
            },
             role:
             {
                required:"<?php echo _l('select', _l('contact_no')) ?>"
            },

        }
        
    	}); 
    	/* End of validate */ 
    });
/* End of function */
</script>
<script type="text/javascript">  
$(' #confirm_password').on('change', function ()
 {
  if ($('#password').val() != $('#confirm_password').val())
   {
  	$('#message').html('Confirm Passsword Not Match').css({'font-weight': 'bold','color':'red'});
   	return false;
   } 
  else 
  {
  	 $('#message').html('Password match').css({'font-weight': 'bold','color':'green'});
  }
    
});

$('#password').on('change', function ()
 {
  if ($('#password').val() != $('#confirm_password').val()) 
  {
  	$('#message').html('Confirm Passsword Not Match').css({'font-weight': 'bold','color':'red'});
   	return false;
  }
  else 
  {
  	 $('#message').html('Password match').css({'font-weight': 'bold','color':'green'});
  }
    
});
$('.toggle').on('click',function(e){
e.preventDefault();
var x = document.getElementById("confirm_password");
  if (x.type === "password")
   {
    	x.type = "text";
  	} 
  else
  {
    	x.type = "password";
  }
});
</script>  
