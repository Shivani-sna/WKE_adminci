<?php
  set_sort_redirect_url();
?>
<!-- page header -->
<div class="page-header page-header-default">
  <div class="page-header-content">
    <div class="page-title">
      <h4></i> <span class="text-semibold">Roles</span></h4>
    </div>
  </div>
  <div class="breadcrumb-line">
      <ul class="breadcrumb">      
        <li>
          <a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a>
        </li>
        <li class="active">Roles</li>
      </ul>
  </div>
</div>
<!-- page header -->
<!-- Content area -->
<div class="content">

<!-- Page length options -->
<div class="panel panel-flat">
<?php 
        if (has_permissions('roles','create')||has_permissions('roles','delete'))
        {
?>
	<div class="panel-heading">
<?php 
        if (has_permissions('roles','create'))
        {
?>
          <a href="<?php echo base_url('admin/roles/add'); ?>" class="btn btn-primary">Add New</a>
<?php
        }
        if (has_permissions('roles','delete'))
        {
?>
		      <a href="" class="btn btn-danger" id="delete_all">Delete Selected</a>
<?php
        }
?>
   </div>
<?php
  }
?>
   <div class="panel-body">
    <div class="row">
      <form method="POST" action="<?php echo base_url('admin/roles/search'); ?>">
        <div class="form-group">
          <div class="col-md-11">
           <input type="text" name="name" class="form-control name" placeholder="Role Name" value="<?php echo $src_rolename; ?>">
          </div>
          <div class="col-md-1">
            <input type="submit" class="btn btn-primary" name="search" value="Search">
          </div>
          </div>
        </form>
      </div>
  </div>
  <div class="table-responsive">
    <table class="table">
    <thead>
      <tr>
<?php 
        if (has_permissions('roles','delete'))
         {
?>
        <th width="5%"><input type="checkbox" name="delete_id" id="select_all"></th>
<?php
        }
?>
        <th width="85%">
          <a href="<?php echo base_url('admin/roles/sort_by/name'); ?>" class="sort">Role Name</a>
        </th>
<?php             
        if (has_permissions('roles','edit') || has_permissions('roles','delete'))
        { 
?>
        <th class="text-center">Actions</th>
<?php 
        } 
?>
      </tr>
      </thead>
      <tbody>
      <?php 
      if ($roles == array())
       {
      ?>                 
       <tr>
          <td colspan="4" class="text-center">No Data Found</td>
        </tr>
<?php
        } 
      foreach ($roles as $key => $role)
      { 
?>
      <tr>
<?php 
      if (has_permissions('roles','delete'))
       {
?>
        <td>
          <input type="checkbox" class="checkbox"  name="delete"  id="<?php echo $role['id']; ?>">
        </td>
<?php
      }
?>
       <td>
          <?php echo $role['name']; ?>
      </td>
<?php 
      if (has_permissions('roles','edit') || has_permissions('roles','delete'))
      {
?>
      <td class="text-center">
<?php 
      if (has_permissions('roles','edit'))
      {
?>
        <a href="<?php echo site_url('admin/roles/edit/').$role['id']; ?>" id="<?php echo $role['id']; ?>" class="text-info"><i class="icon-pencil7"></i>
        </a>
<?php 
      }
?>
<?php if (has_permissions('roles','delete'))
      {
?>
        <a href="" class="text-danger delete" id="<?php echo $role['id']; ?>"><i class=" icon-trash"></i></a>
<?php 
       }
 ?>
      </td>
<?php 
      } //end of roles edit and delete
?>
    </tr>
<?php
    } //end of foreach
?> 
      </tbody>
    </table>
  </div>
</div>
<!-- /content area -->
<div class="pagination pull-right">
  <ul class="pagination pull-right">
    <li>
      <?php echo $links; ?>
    </li>
  </ul>
</div>

<script type="text/javascript">
$( document ).ready(function() 
{
/* simple delete on sigle value */
  $(".delete").click(function(e) 
  { 
    e.preventDefault();
    var BASE_URL = "<?php echo base_url(); ?>";
    var id = $(this).attr('id');
    swal({
          title: "Are you sure?",
          text: "You will not be able to recover User!",
          buttons: [
            'No, cancel it!',
            'Yes, I am sure!'
          ],
          dangerMode: true,
        }).then(function(isConfirm)
         {
          if (isConfirm)
           {
            $.ajax
            ({
              url:BASE_URL+'admin/roles/delete',
              type: 'POST',
              data: {
                     role_id:id
                    },
            })
            .done(function(data) 
            {
              if (data=='error')
               {
                  toastr.error('you have not delete Role ');
               }
               else
               {
                 toastr.success('Role Deleted');
                 $("#"+id).closest("tr").remove();
               }
            });               
         }
      });
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
        toastr.error("Please Select Roles");
        return false;
      }
       swal({
          title: "Are you sure?",
          text: "You will not be able to recover User!",
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
                  url:BASE_URL+'admin/roles/delete_selected',
                  type: 'POST',
                  data: {
                         ids:delete_array
                        },
                })
                .done(function(data) 
                {
                  toastr.success("roles Deleted.");
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
    $(".checkbox").each(function()
    {
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
