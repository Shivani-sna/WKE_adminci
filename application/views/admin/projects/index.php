<?php
    set_sort_redirect_url();
?>
<!-- page header -->
<div class="page-header page-header-default">
  <div class="page-header-content">
    <div class="page-title">
      <h4></i> <span class="text-semibold">Projects</span></h4>
    </div>
  </div>
  <div class="breadcrumb-line">
    <ul class="breadcrumb">
      <li>
        <a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a>
      </li>
      <li class="active">
        Projects
      </li>
    </ul>
  </div>
</div>
<!-- page header -->
<!-- Content area -->
<div class="content">
  <!-- Page length options -->

  <div class="panel panel-flat">
<?php 
  if (has_permissions('projects','create') || has_permissions('projects','delete'))
  {
?>
    <div class="panel-heading">
<?php 
      if (has_permissions('projects','create'))
      {
?>
     <a href="<?php echo base_url('admin/projects/add'); ?>" class="btn btn-primary">Add New</a> 
 <?php
      }
?>
<?php 
      if (has_permissions('projects','delete'))
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
      <form method="POST" action="<?php echo base_url("admin/projects/search"); ?>">
        <div class="form-group">
          <div class="col-md-2">
            <input type="text" name="project_id" placeholder="Project ID" class="form-control" value="<?php echo $src_project_id; ?>">
          </div>
           <div class="col-md-9">
            <input type="text" value="<?php echo $src_name; ?>" name="name" placeholder="Project Name" class="form-control">
          </div>
          <div class="col-md-1">
            <input type="submit" class="btn btn-info" name="search" value="Search">
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
    if (has_permissions('projects','delete'))
    {
?>
      <th width="5%">
        <input type="checkbox" name="delete_id" id="select_all">
      </th>
<?php 
    }  
?>
     <th width="15%">
        <a href="<?php echo base_url('admin/projects/sort_by/project_id'); ?>" class="sort">Project ID</a>
      </th>
     <th width="45%">
      <a href="<?php echo base_url('admin/projects/sort_by/name'); ?>" class="sort">Project Name</a>
    </th>
    <th width="25%">
      Details
    </th>
<?php
   if (has_permissions('projects','edit') || has_permissions('projects','delete'))
    { 
?>
    <th width="10%" class="text-center">
      Actions
    </th>
<?php
    }
?>
  </tr>
  </thead>
  <tbody>

<?php 
  if (empty($projects))
    {

?>                 
   <tr>
    <td colspan="4" class="text-center">
      No Data Found
    </td>
  </tr>
<?php
    }
   foreach ($projects as $key => $project)
  {
?>
  <tr>
<?php
   if (has_permissions('projects','delete'))
   {
?>
    <td>
    	<input type="checkbox" class="checkbox"  name="delete"  id="<?php  echo $project['id']; ?>">
    </td>
<?php 
   } 
?>
    <td>
<?php 
      echo $project['project_id'];
?>
   </td>
	 <td>
<?php 
      echo ucfirst($project['name']);
?>
   </td>
	 <td>
<?php 
      echo ucfirst($project['details']);
?>
    </td>
<?php  
  if (has_permissions('projects','edit') || has_permissions('projects','delete'))
    {
?>
    <td class="text-center">
  <?php 
    if (has_permissions('projects','edit')) 
    {
    ?>
     <a href="<?php echo site_url('admin/projects/edit/').$project['id']; ?>" id="<?php echo $project['id']; ?>" class="text-info">
              <i class="icon-pencil7"></i></a>
  <?php  
    }  
  ?>
    <?php 
    if (has_permissions('projects','delete')) 
    {
    ?>
      <a href="" class="text-danger delete" id="<?php echo $project['id']; ?>"><i class=" icon-trash"></i></a>
  <?php  
    } 
  ?>
    </td>
<?php 
  } //end of delete and edit 
?>
    </tr>
<?php
    } //end of foreach 
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
/* simple delete on sigle value */
	$(".delete").click(function(e) 
	{ 
    e.preventDefault();
    var BASE_URL = "<?php echo base_url(); ?>";
    var id = $(this).attr('id');
    swal({
      title: "<?php echo _l('deletion_msg', _l('project')); ?>",
      text: "<?php echo _l('recovery_msg', _l('project')); ?>",
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
      		url:BASE_URL+'admin/projects/delete',
      		type: 'POST',
      		data: {
      			    project_id:id
      			 },
      	})
      	.done(function()
         {
      		if (msg=="success")
           {
             toastr.success("<?php echo _l('deleted', _l('project')); ?>");
           
           }
           else
           {
             toastr.error("<?php echo _l('access_denied'); ?>");
           }
      	});
      	$("#"+id).closest("tr").remove();
      }
    });
  });
/* end of sigle delete*/
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
         toastr.error("<?php echo _l('select_before_delete_msg', _l('projects')) ?>");
		  	 return false;
		  }
		   swal({
         title: "<?php echo _l('deletion_multiple_msg', _l('projects')); ?>",
          text: "<?php echo _l('recovery_multiple_msg', _l('projects')); ?>",
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
              		url:BASE_URL+'admin/projects/delete_selected',
              		type: 'POST',
              		data: {
              			    ids:delete_array
              			 },
              	})
              	.done(function()
                 {
              		toastr.success("<?php echo _l('deleted', _l('projects')); ?>");
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
