<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4></i> <span class="text-semibold">Edit Profile</span></h4>
		</div>
	</div>
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
				<button type="submit" class="btn btn-success" name="submit" id="save">Save</button>
			</div>
			</div>
			</div>
		</div>
		</form>
</div>
</div>
<div class="col-md-5">
<form action="<?php echo base_url('admin/myprofile/edit_password/') ?>" id="mypasswordform" method="POST">
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
		</div>
		<div class="form-group">
			<a class="btn toggle"><i class="icon-eye"></i></a>
			Show Password
		</div>
		<div class="form-group">
			<label>Repeat New Password:</label>
			<input type="password" class="form-control" placeholder="Password" id="repeat_password" name="repeat_password">
			<span class="valid"></span>
		</div>
		<div class="form-group" align="right">
			<button type="submit" class="btn btn-success" name="submit_password" id="submit_password">Save</button>
		</div>
	</div>
</div>

</div>
</form>
</div>

</div>
<!-- /content area -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<script type="text/javascript">
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
                },

            email: {
                    required: true,
                    email: true
                },
           
        },
       messages: {
        	firstname: {
                 required:"<?php echo _l('required_field_msg', _l('firstname')) ?>",
					},
            lastname: {
                 required:"<?php echo _l('required_field_msg', _l('lastname')) ?>",
            		},
              mobile_no: {
                 required:"<?php echo _l('required_field_msg', _l('contact_no')) ?>",
                   mobile_no:"Please Enter Digits"
		           },
            email: {
                 required:"<?php echo _l('required_field_msg', _l('email')) ?>",
                    email:"<?php echo _l('required_field_valid', _l('email')) ?>"
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
                 required:"<?php echo _l('required_field_msg', _l('old_password')) ?>",
            },
            newpassword: {
                 required:"<?php echo _l('required_field_msg', _l('password')) ?>",
            },
            repeat_password: {
                 required:"<?php echo _l('required_field_valid', _l('password')) ?>",
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
	 	 $(".msg").html("<strong style='color:green'><?php echo _l('match', _l('password')) ?></strong>");
	 } 
	 else
	 {
	 	 $(".msg").html("<strong style='color:red'><?php echo _l('not_match', _l('password')) ?></strong>");
	 	 return false;
	 }
});
$("#repeat_password").change(function(event) {
	event.preventDefault();
	var newpassword = $('#newpassword').val();
	var repeat_password = $('#repeat_password').val();

	if (newpassword==repeat_password)
	 {
	 	 $(".valid").html("<strong style='color:green'><?php echo _l('match', _l('repeat_password')) ?></strong>");
	 	
	 }
	 else
	 {
	 	 $(".valid").html("<strong style='color:red'><?php echo _l('not_match', _l('repeat_password')) ?></strong>");
	 }
	
});
$("#newpassword").change(function(event)
 {
	event.preventDefault();
	var newpassword = $('#newpassword').val();
	var repeat_password = $('#repeat_password').val();

	if (newpassword==repeat_password)
	 {
	 	 $(".valid").html("<strong style='color:green'><?php echo _l('repeat_password_match'); ?></strong>");
	 	
	 }
	 else
	 {
	 	 $(".valid").html("<strong style='color:red'><?php echo _l('repeat_password_not_match'); ?></strong>");
	 }
	
});
$('.toggle').on('click',function(e)
{
	e.preventDefault();
	var x = document.getElementById("newpassword");
	  if (x.type === "password") {
	    x.type = "text";
	  } else {
	    x.type = "password";
	  }
});
</script> 

