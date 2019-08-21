<?php

                  if ($this->uri->segment(3)!=NULL)
                   {
                     $sort_redirect_to = $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3);
                  }
                  else
                  {
                    $sort_redirect_to = $this->uri->segment(1).'/'.$this->uri->segment(2);
                  }

                   $this->session->set_userdata('sort_redirect_to',$sort_redirect_to) ?>
		 <style type="text/css">

		 	.name
      {
        width:49% !important;
        display:inline-block !important;
      }
      
		 </style>
     <!-- page header -->
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4></i> <span class="text-semibold">Users</span></h4>
            </div>
          </div>

          <div class="breadcrumb-line">
            <ul class="breadcrumb">
              <?php ?>
              <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a></li>
              <li class="active">Users</li>


            </ul>
          </div>
        </div>
        <!-- page header -->

	<!-- Content area -->
				<div class="content">

					<!-- Page length options -->
        
					<div class="panel panel-flat">

						<div class="panel-heading">
								<?php 
                    if (has_permissions('users','create'))
                     {
                ?>
                  <a href="<?php echo base_url('admin/users/add'); ?>" class="btn btn-primary">Add New</a>  
                <?php
                    }
                 ?>

                 <?php 
                    if (has_permissions('users','Delete'))
                     {
                ?>
                <a href="" class="btn btn-danger" id="delete_all">Delete Selected</a>
                <?php
                    }
                 ?>
						<table class="table">
							<thead>
               
                <form method="POST" action="<?php echo base_url("admin/users/search"); ?>">
								<tr>
									<th></th>
									<th width="25%">
                   
                        <input type="text" name="firstname" placeholder="Firstname" class="form-control name" value="<?php echo $this->session->userdata('src_firstname'); ?>">
                        <input type="text" name="lastname" placeholder="Lastname" class="form-control name"  value="<?php echo $this->session->userdata('src_lastname'); ?>">
                   
                  </th>
									<th><input type="email" name="email" placeholder="email" class="form-control"  value="<?php echo $this->session->userdata('src_email'); ?>"></th>
									<th>
                    <select class="select" name="role" id="role">
                     <div class="form-group">
                      <option value="" name="select">Select Role</option>
                      <?php
                      foreach ($roles as $key => $role)
                      {
                      	?>
                               <?php 
                               $selected='';
                               if ($this->session->userdata('src_role')==$role['id'])
                                {
                                  $selected = "selected";
                                }

                                ?>
                        <option value="<?php echo $role['id']; ?>" <?php echo $selected; ?>><?php echo $role['name'] ?></option>

                      <?php
                      }

                      ?>
                 </select>
                  </th>
									<th>Last Login</th>
									<th>
                   Status        

                  </th>
                  <th><input type="submit" class="btn btn-primary" name="search" value="Search"></th>
								</tr>
                </form>
                 <tr>
                  <?php if (has_permissions('users','delete'))
                  { 
                  ?>
                    <th><input type="checkbox" name="delete_id" id="select_all"></th>
                    
                  <?php } ?>
                  <th><a href="<?php echo base_url('admin/users/sort_by/firstname') ?>" class="sort">Firstname</a> <a href="<?php echo base_url('admin/users/sort_by/lastname') ?>" class="sort">Lastname</a></th>
                  
                  <th><a href="<?php echo base_url('admin/users/sort_by/email') ?>" class="sort">Email</a></th>
                  <th><a href="<?php echo base_url('admin/users/sort_by/role') ?>" class="sort">Role</a></th>
                  <th>Last Login</th>
                  <th>Status</th>
                  <?php if (has_permissions('users','edit') || has_permissions('users','delete')): ?>
                  <th class="text-center">Actions</th>
                <?php endif ?>


                </tr>
							</thead>
							<tbody>

 <?php 
                if ($users == array())
                 {
                ?>                 
                 <tr><td colspan="4" class="text-center">No data Found</td></tr>
                <?php
              }
								

                foreach ($users as $key => $user)
                {
                	?>

									<tr>
                     <?php if (has_permissions('users','delete')): ?>
									<td>
                    <?php
$disabled = '';

	if ($user['id'] == get_loggedin_info('user_id'))
	{
		$disabled = "disabled";
	}

	?> 	<input type="checkbox" class="checkbox"  name="delete"  id="<?php
if ($user['id'] != get_loggedin_info('user_id'))
	{
		echo $user['id'];}
	?>" <?php echo $disabled; ?>>
</td>
 <?php endif ?>
									<td><?php echo ucfirst($user['firstname']).'&nbsp;'.ucfirst($user['lastname']); ?></td>
									<td><a href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; ?></a></td>
									<td><?php

	foreach ($roles as $key => $role)
	{
		if ($role['id'] == $user['role'])
		{
			echo $role['name'];
		}
	}

	?>

                  </td>
                  <?php
$login_datetime = $user['last_login'] != 'Never' ? date("d M Y, H:i:s", $user['last_login']) : "Never";
	?>
                  <!-- data-popup="tooltip" -->
									<td  title="<?php echo $login_datetime; ?>">

                    <?php
if ($user['last_login'] != "Never")
	{
		echo time_stamp($user['last_login']);
	}
	else
	{
		echo "Never";
	}

	?></td>
									 <?php
          $readonly = '';

	if ($user['id'] == get_loggedin_info('user_id'))
	{
		$readonly = "readonly";
	}

	?>
 <?php
$not_permissions = '';
  if (!has_permissions('users','edit'))
 {
   $not_permissions="readonly";
 }
  ?>
   

                    <td>
                    <input type="checkbox" class="switch"  id="<?php echo $user['id']; ?>" <?php
if ($user['is_active'] == 1)
  {
    echo "checked";
  }
  ?> <?php echo $readonly; ?> <?php echo $not_permissions; ?>>
</td>
 
	 <?php if (has_permissions('users','edit') || has_permissions('users','delete')): ?>
     
  
									<td class="text-center">
                       <?php 
                              if (has_permissions('users', 'edit'))
                               {
                                ?>
                       <a href="<?php echo site_url('admin/users/edit/').$user['id']; ?>" id="<?php echo $user['id']; ?>" class="text-info">
                          <i class="icon-pencil7"></i></a>
                           <?php
                              }
                           ?>
                          <?php 
                              if (has_permissions('users', 'delete'))
                               {
                                ?>
                                <a href="" class="text-danger delete" id="<?php echo $user['id']; ?>"><i class=" icon-trash"></i></a>
                             <?php
                              }
                           ?>
												
									</td>
                   <?php endif ?>
								</tr>
								<?php
}
?>

               
							</tbody>
						</table>
					</div>
<div class="table-foot">
  <ul class="pagination pull-right">
    <li>
      <?php echo $links; ?>
    </li>
  </ul>
</div>

				</div>
				<!-- /content area -->

 <script type="text/javascript">
$( document ).ready(function()
{

    
/*Update User Status Jquery for checkbox switch */
	$(".switch").change(function()
	 {

   	  var check = 0;
      var BASE_URL = "<?php echo base_url(); ?>";
      var id = $(this).attr('id');
      var session_id = "<?php echo get_loggedin_info('user_id'); ?>";
      //console.log(id);

       if (session_id!=id)
       {
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
              	})
              	.done(function(msg)
                {
              		 if (msg=='Active')
                    {
                      toastr.success("<?php echo _l('activation_msg', _l('user')); ?>");
                    }
                    else
                    {
                        toastr.success("<?php echo _l('deactivation_msg', _l('user')); ?>");
                    }

          response = (msg == '0') ? true : false;
          return response;
        }).fail(function(data){
        
        });
       }
       else
       {
      //  		swal("", "Please Select Users", "warning");
		  	 // return false;
       }
	 });
/* End of Update User Status Jquery for checkbox switch  */

/* simple delete on sigle value */
	$(".delete").click(function(e)
	{
      e.preventDefault();
      var BASE_URL = "<?php echo base_url(); ?>";
      var id = $(this).attr('id');
      var session_id = "<?php echo get_loggedin_info('user_id'); ?>";
      if (id==session_id)
      {
      	 toastr.error("You Can't Delete your Account");
      	return false;
      }
    
      swal({
            title: "<?php echo _l('deletion_msg', _l('user')); ?>",
          text: "<?php echo _l('recovery_msg', _l('user')); ?>",
          buttons: [
            'No, cancel it!',
            'Yes, I am sure!'
          ],
          dangerMode: true,
        }).then(function(isConfirm) {
          if (isConfirm) {
              	$.ajax({
              		url:BASE_URL+'admin/users/delete',
              		type: 'POST',
              		data: {
              			    user_id:id
              			 },
              	})
              	.done(function(msg)
                {
              		if (msg=="success")
                   {
                     toastr.success("<?php echo _l('deleted', _l('user')); ?>");
                   
                   }
                   else
                   {
                     toastr.error("<?php echo _l('access_denied'); ?>");
                   }
              	})
              	.fail(function() {
              		console.log("error");
              	})
              	.always(function() {
              		console.log("complete");
              	});
              	$("#"+id).closest("tr").remove();
             }

          });
        //});
  });
/* end of sigle delete*/
$("#delete_all").click(function(e)
	{
		e.preventDefault();
		var BASE_URL = "<?php echo base_url(); ?>";
		var delete_array = [];
		 $(".checkbox:checked").each(function(){
		 	var id = $(this).attr('id');
             delete_array.push(id);
            });

		 //console.log(delete_array);
		 if (delete_array == '')
		  {
        toastr.error("<?php echo _l('select_before_delete_msg', _l('user')) ?>");
		  	 // swal("", "Please Select Users", "warning");
		  	 return false;
		  }
		   swal({
          title: "<?php echo _l('deletion_multiple_msg', _l('users')); ?>",
          text: "<?php echo _l('recovery_multiple_msg', _l('users')); ?>",
          buttons: [
            'No, cancel it!',
          'Yes, I am sure!'


          ],
          dangerMode: true,
        }).then(function(isConfirm) {
          if (isConfirm) {
		   $.ajax({
              		url:BASE_URL+'admin/users/delete_selected',
              		type: 'POST',
              		data: {
              			    ids:delete_array
              			 },
              	})
              	.done(function() {
              		toastr.success("<?php echo _l('deleted', _l('users')); ?>");
              	})
              	.fail(function() {
              		console.log("error");
              	})
              	.always(function() {
              		console.log("complete");
              	});
              	$(delete_array).each(function(index, el)
              	{
              		//console.log(el);
              		$("#"+el).closest("tr").remove();
              	});
            }

          });
        //});
	});

/* select all checkbox*/
    $('#select_all').on('click',function()
    {
        if(this.checked){
        	//console.log('checked');
            $(".checkbox").each(function(){
               $(this).prop("checked","checked");
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
/* end of select all*/

/* remove all check */
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });
    /* end of remove check all ready */
	});
/* end of document ready */



</script>
