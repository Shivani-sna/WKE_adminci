<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4></i> <span class="text-semibold">Edit Role</span></h4>
		</div>
	</div>
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li>
				<a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a>
			</li>
			<li>
				<a href="<?php echo base_url('admin/Roles'); ?>">Roles</a>

			</li>
			<li class="active">Add</li>
		</ul>
	</div>
</div>
<!-- Content area -->
<div class="content">

	<div class="row">
	<div class="col-md-6">
	<form method="POST" action="<?php echo base_url('admin/roles/edit/').$role['id']; ?>" id="roleform">
		<div class="panel panel-flat">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-12">
						<h5 class="pull-left"><strong>Edit Role <?php echo $role['name']; ?></strong></h5>
	
					
											<?php 
        if (has_permissions('roles','create'))
        {
?>
        
         	 <a href="<?php echo base_url('admin/roles/add'); ?>" class="btn btn-primary pull-right">New Role</a>

         </div>
         <div class="row">
				<div class="col-md-12">
					<div class="alert alert-warning no-border">
										<button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
										<span class="text-semibold">
										<?php echo _l('edit_role_warning_msg'); ?>
									</span>
								    </div>
				</div>
		</div>
<?php
        }
        ?>
				</div>
			</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<small class="req text-danger">*</small>
						<label>Role Name:</label>
						<input type="text" class="form-control" placeholder="Role Name" id="name" name="name" value="<?php echo $role['name']; ?>">
					</div>
				<div>
<?php 
				echo $array; 
?>
				</div>
					<div class="validate_permission"></div>
				</div>
			</div>
		</div>
		</div>
	</div>
	<div class="col-md-6">
	<!-- Basic datatable -->
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title"><strong>Users which are currently using the role: <?php echo $role['name']; ?></strong></h5>

		</div>
		<div class="panel-body">
			<table class="table datatable-basic" id="example">
			<thead>
				<tr>
					<th> Name </th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
<?php
				foreach ($users as $user) 
				{
				
?>
				<tr>
					<td><?php echo ucfirst($user['firstname'])."&nbsp;". ucfirst($user['lastname']); ?></td>
					<td><a href="mailto:"><?php echo $user['email']; ?></a></td>
				</tr>
<?php
				}
?>
			</tbody>
		</table>
		</div>
		</div>
	</div>
	<div class="btn-bottom-toolbar text-right btn-toolbar-container-out">
		<button type="submit" class="btn btn-success" name="submit">Save</button>
		<a class="btn btn-default" onclick="window.history.back();">Back</a>
	</div>
</form>
<!-- /content area -->
<script type="text/javascript">
		$(document).ready(function() {
	/* ------------------------------------------------------------------------------
*
*  # Basic datatables
*
*  Specific JS code additions for datatable_basic.html page
*
*  Version: 1.0
*  Latest update: Aug 1, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{ 
            orderable: false,
            width: '100px',
            targets: [ 5 ]
        }],
        dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Filter:</span> _INPUT_',
            lengthMenu: '<span>Show:</span> _MENU_',
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });


    // Basic datatable
    $('.datatable-basic').DataTable();


    // Alternative pagination
    $('.datatable-pagination').DataTable({
        pagingType: "simple",
        language: {
            paginate: {'next': 'Next &rarr;', 'previous': '&larr; Prev'}
        }
    });


    // Datatable with saving state
    $('.datatable-save-state').DataTable({
        stateSave: true
    });


    // Scrollable datatable
    $('.datatable-scroll-y').DataTable({
        autoWidth: true,
        scrollY: 300
    });



    // External table additions
    // ------------------------------

    // Add placeholder to the datatable filter option
    $('.dataTables_filter input[type=search]').attr('placeholder','Type to filter...');


    // Enable Select2 select for the length option
    $('.dataTables_length select').select2({
        minimumResultsForSearch: Infinity,
        width: 'auto'
    });
    
});


    $('#example').DataTable();
//     $('#example').dataTable( {
//   "autoWidth": false
// } );
} );
</script>
<script type="text/javascript">
$(function () {
    $("#roleform").validate({
        rules: {
        	name:
        	{
        		 required: true,
        	},
        	
        },
        messages: {
        	name: {
                 required:"<?php echo _l('required_field_msg', _l('role_name')) ?>",
 				 },
				 }      
    });  
    });
function onSubmit() 
{ 
    var check_permission = $(".permission").serializeArray(); 
    if (check_permission.length === 0) 
    { 
         $(".validate_permission").html("<p style='color:red'><?php echo _l('select_before_delete_msg', _l('permission')) ?></p>");
        return false;
    } 
}

// register event on form, not submit button
$('#roleform').submit(onSubmit)
</script>

