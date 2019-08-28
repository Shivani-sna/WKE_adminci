<?php
    set_sort_redirect_url();
    
?>
<!-- page header -->
<div class="page-header page-header-default">
  <div class="page-header-content">
    <div class="page-title">
      <h4></i> <span class="text-semibold">Users</span></h4>
    </div>
  </div>
  <div class="breadcrumb-line">
    <ul class="breadcrumb">
      <li>
        <a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a>
      </li>
      <li class="active">
        Users
      </li>
    </ul>
  </div>
</div>
<!-- page header -->

<!-- Content area -->
<div class="content">
  <!-- panel panel-flat-->
  <div class="panel panel-flat">
<?php 
    if (has_permissions('users','create'))
    {
?>
     <!-- panel-heading-->
    <div class="panel-heading">
<?php 
      if ( has_permissions('users','create') || has_permissions('users','Delete') )
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
  </div>
   <!-- panel-heading-->
<?php
    }
?>
    <!-- panel-body-->
    <div class="panel-body">
      <div class="row">
        <form method="POST" action="<?php echo base_url("admin/users/search"); ?>">
          <div class="form-group">
            <div class="col-md-2">
              <input type="text" name="firstname" placeholder="Firstname" class="form-control name" value="<?php echo $src_firstname; ?>">
            </div>
            <div class="col-md-2">
              <input type="text" name="lastname" placeholder="Lastname" class="form-control name"  value="<?php echo $src_lastname; ?>">
            </div>
            <div class="col-md-3">
              <input type="email" name="email" placeholder="Email" class="form-control"  value="<?php echo $src_email; ?>">
            </div>
            <div class="col-md-2">
              <select class="select" name="role" id="role">
                <option value="" name="select">Select Role</option>
<?php
                  foreach ($roles as $key => $role)
                  {
                      $selected='';

                      if ($src_role==$role['id'])
                      {
                        $selected = "selected";
                      }
?>
                  <option value="<?php echo $role['id']; ?>" <?php echo $selected; ?>><?php echo $role['name'] ?></option>
<?php
                  }

?>
              </select>
            </div>
            <div class="col-md-2">
              <select class="select text-center" name="is_active">   
                <option value="" name="select">Select Status</option>
                <option value="1" <?php if($src_is_active=='1'){ echo "selected";} ?>>Active</option>
                <option value="0" <?php if($src_is_active=='0'){ echo "selected";} ?>>Inactive</option>
              </select>
            </div>

            <div class="col-md-1">
              <button type="submit" class="btn btn-info" name="search" value="search"> Search</button>
            </div>
          </div>
        </form>
      </div>
      </div>
      <!-- table-responsive-->
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
<?php 
            if (has_permissions('users','delete'))
            { 
?>
              <th>
                  <input type="checkbox" name="delete_id" id="select_all">
              </th>
<?php
            }
?>
              <th>
                <a href="<?php echo base_url('admin/users/sort_by/firstname') ?>" class="sort">Firstname</a> <a href="<?php echo base_url('admin/users/sort_by/lastname') ?>" class="sort">Lastname</a>
              </th>
              <th>
                <a href="<?php echo base_url('admin/users/sort_by/email') ?>" class="sort">Email</a>
              </th>
              <th>
                <a href="<?php echo base_url('admin/users/sort_by/role') ?>" class="sort">Role</a>
              </th>
              <th>
                Last Login
              </th>
              <th>
                Status
              </th>
<?php
               if (has_permissions('users','edit') || has_permissions('users','delete'))
                { 
?>
              <th class="text-center">
                Actions
              </th>
<?php
                } 
 ?>
            </tr>
          </thead>
          <tbody>
<?php 
          if (empty($users))
          {
?>                 
            <tr>
              <td colspan="4" class="text-center">
                No data Found
              </td>
            </tr>
<?php
          }
          foreach ($users as $key => $user)
          {
?>
          <tr>
<?php 
          if (has_permissions('users','delete'))
          {

            $disabled = '';
          if ($user['id'] == get_loggedin_info('user_id'))
          {
            $disabled = "disabled";
          }
?>
            <td>
              <input type="checkbox" class="checkbox"  name="delete"  id="<?php if ($user['id'] != get_loggedin_info('user_id')) {  echo $user['id']; }?>" <?php echo $disabled; ?>>
            </td>
<?php 
          } 
?>
            <td>
              <?php echo ucfirst($user['firstname']).'&nbsp;'.ucfirst($user['lastname']); ?>
            </td>
            <td>
              <a href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; ?></a>
            </td>
            <td>
<?php
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

  $login_datetime = $user['last_login'] != 'Never' ? display_date_time($user['last_login']) : "Never";
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
?>
        </td>
<?php
      $readonly = '';

      if ($user['id'] == get_loggedin_info('user_id') || !has_permissions('users','edit'))
      {
        $readonly = "readonly";
      }
?>
      <td>
        <input type="checkbox" class="switch"  id="<?php echo $user['id']; ?>" <?php if ($user['is_active'] == 1) { echo "checked"; } ?> <?php echo $readonly; ?>>
      </td>
<?php 
      if (has_permissions('users','edit') || has_permissions('users','delete'))
      { 
?>
      <td class="text-center">
<?php 
        if (has_permissions('users', 'edit'))
         {
?>
        <a href="<?php echo site_url('admin/users/edit/').$user['id']; ?>" id="<?php echo $user['id']; ?>" class="text-info"><i class="icon-pencil7"></i></a>
<?php
        }/* End of permissions edit */ 
      if (has_permissions('users', 'delete'))
       {
?>
        <a href="" class="text-danger delete" id="<?php echo $user['id']; ?>"><i class=" icon-trash"></i></a>
<?php
        }/* End of permissions delete */
?>
      </td>
<?php
      }/* End of permissions edit and delete */
 ?>
</tr>
<?php
    }/* End of foreach */
?>
      </tbody>
    </table>
  </div>
</div>

<div class="pagination pull-right">
    <ul class="pagination pull-right">
        <li>
            <?php echo $links; ?>
        </li>
    </ul>
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
    if (session_id!=id)
     {
     	if($(this).is(":checked"))
       {
       		check = 1;
       }
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
          		
                toastr.success(msg);
              
              response = (msg == '0') ? true : false;
              return response;
            });
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
        }).then(function(isConfirm)
        {
          if (isConfirm)
           {
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
/* end of single delete*/

$("#delete_all").click(function(e)
	{
		e.preventDefault();
		var BASE_URL = "<?php echo base_url(); ?>";
		var delete_array = [];

		$(".checkbox:checked").each(function()
    {
		 	var id = $(this).attr('id');
      delete_array.push(id);
    });

	  if (delete_array == '')
	  {
      toastr.error("<?php echo _l('select_before_delete_msg', _l('user')) ?>");
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
    }).then(function(isConfirm)
     {
      if (isConfirm)
      {
       $.ajax({
          		url:BASE_URL+'admin/users/delete_selected',
          		type: 'POST',
          		data: {
          			     ids:delete_array
          			    },
          	})
          	.done(function()
            {
          		toastr.success("<?php echo _l('deleted', _l('users')); ?>");
          	});
          	$(delete_array).each(function(index, el)
          	{
          		$("#"+el).closest("tr").remove();
          	});
        }
      });
	});

/* select all checkbox*/
$('#select_all').on('click',function()
{
  if(this.checked)
  {
    $(".checkbox").each(function(){
       $(this).prop("checked","checked");
    });
  }
  else
  {
   $('.checkbox').each(function()
   {
      this.checked = false;
  });
  }
});
/* end of select all*/

/* remove all check */
$('.checkbox').on('click',function()
{
  if($('.checkbox:checked').length == $('.checkbox').length)
  {
      $('#select_all').prop('checked',true);
  }
  else
  {
      $('#select_all').prop('checked',false);
  }
});
/* end of remove check all ready */

});
/* end of document ready */
</script>
