		
		 <style type="text/css">
		 	.checkbox
		 	{
		 		background-color: red;
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
              <?php  ?>
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
								<a href="<?php echo base_url('admin/users/add'); ?>" class="btn btn-primary">Add New</a>
							<a href="" class="btn btn-danger" id="delete_all">Delete Selected</a>

						<div class="panel-body">
						</div>

						<table class="table datatable-show-all" id="example">
							<thead>
								<tr>
									<th><input type="checkbox" name="delete_id" id="select_all"></th>
									<th><input type="text" name="firstname" placeholder="FIrstname" class="form-control"></th>
									<th><input type="email" name="email" placeholder="email" class="form-control"></th>
									<th><select class="select" name="role" id="role">
                      <!-- <option>Select Role</option> -->
                          <?php 
                              foreach ($roles as $key => $role)
                               {
                                ?>
                                <div class="form-group">
                    
                      
                        
                      <option value="" name="select">Select Role</option>
                        <option value="<?php echo $role['id']; ?>" name="role"><?php echo $role['name'] ?></option>
                        
                            <?php

                            }

                           ?>

                      
                           </select>
</th>
									<th>Last Login</th>
									<th>Status</th>
									<th class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($users as $key => $user)
								{ ?>
									
									<tr>
									<td><?php 
									$disabled = '';
									if ($user['id']==get_loggedin_user_id())
									 {
										 $disabled="disabled";
									} 

									 ?> 	<input type="checkbox" class="checkbox"  name="delete"  id="<?php if ($user['id']!=get_loggedin_user_id()){ echo $user['id'];} ?>" <?php echo $disabled; ?>></td>
									<td><?php echo ucfirst($user['firstname']).'&nbsp;'.ucfirst($user['lastname']); ?></td>
									<td><a href="mailto:<?php echo $user['email']; ?>"><?php echo $user['email']; ?></a></td>
									<td><?php 
                        foreach ($roles as $key => $role)
                        {
                          if ($role['id']==$user['role'])
                           {
                            echo $role['name'];
                          }
                        }
                  ?>
                    
                  </td>
                  <?php
                      $login_datetime = $user['last_login']!='Never' ? date("d M Y, H:i:s", $user['last_login']) : "Never"; 
                  ?>
                  <!-- data-popup="tooltip" -->
									<td  title="<?php echo $login_datetime;  ?>">
                    
                    <?php if ($user['last_login']!="Never")
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
									if ($user['id']==get_loggedin_user_id())
									 {
										 $readonly="readonly";
									} 

									 ?> 
									<td ><input type="checkbox" class="switch"  id="<?php echo $user['id']; ?>" <?php if ($user['is_active']==1) {
										echo "checked";
									}  ?> <?php echo $readonly; ?>></td>
									<td class="text-center">

                       <a href="<?php echo site_url('admin/users/edit/').$user['id']; ?>" id="<?php echo $user['id']; ?>" class="text-info">
                          <i class="icon-pencil7"></i></a>
												<a href="" class="text-danger delete" id="<?php echo $user['id']; ?>"><i class=" icon-trash"></i></a>
									</td>
								</tr>
								<?php
									} 
								?>
								
							</tbody>
						</table>
					</div>
			

				</div>
				<!-- /content area -->

 <script type="text/javascript">
$( document ).ready(function() 
{
	
    $('#example').DataTable();

$(function() {


    // Table setup
    // ------------------------------

    // Setting datatable defaults
    $.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        columnDefs: [{ 
            orderable: false,
          
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
/*Update User Status Jquery for checkbox switch */
	$(".switch").change(function()
	 {
	 	
   	  var check = 0;
      var BASE_URL = "<?php echo base_url(); ?>";
      var id = $(this).attr('id');
      var session_id = "<?php echo get_loggedin_user_id(); ?>";
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
        console.log("fail method is called");
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
      var session_id = "<?php echo get_loggedin_user_id(); ?>";
      if (id==session_id)
      {
      	 toastr.error("You Can't Delete your Account");
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
        }).then(function(isConfirm) {
          if (isConfirm) {
              	$.ajax({
              		url:BASE_URL+'admin/users/delete',
              		type: 'POST',
              		data: {
              			    user_id:id
              			 },
              	})
              	.done(function() {
              		toastr.success("Users Deleted.");
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
        toastr.error("Please Select Users");
		  	 // swal("", "Please Select Users", "warning");
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
              		toastr.success("Users Deleted.");
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
