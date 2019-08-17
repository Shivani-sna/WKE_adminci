	
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
              <h4></i> <span class="text-semibold">Categories</span></h4>
            </div>
          </div>

          <div class="breadcrumb-line">
            <ul class="breadcrumb">
              <?php  ?>
              <li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a></li>
              <li class="active">Categories</li>
              

            </ul>
          </div>
        </div>
        <!-- page header -->

	<!-- Content area -->
				<div class="content">

					<!-- Page length options -->
					<div class="panel panel-flat">
						<div class="panel-heading">
								<a href="<?php echo base_url('admin/categories/add'); ?>" class="btn btn-primary">Add New</a>
							<a href="" class="btn btn-danger" id="delete_all">Delete Selected</a>

						<div class="panel-body">
						</div>


				      <table class="table datatable-basic" id="example">
              <thead>
                <tr>
                  <th><input type="checkbox" name="delete_id" id="select_all"></th>
                  <th>Name</th>
                  <th>Status</th>

                  <th class="text-center">Actions</th>
                 <!--   <th></th>
                  <th></th>
                  <th></th> -->
                </tr>
              </thead>
              <tbody>
                
                <?php foreach ($categories as $key => $category)
                { ?>
                  <tr>

                  
                  <td><input type="checkbox" class="checkbox"  name="delete"  id="<?php echo $category['id']; ?>"></td>
                  <td><?php echo $category['name']; ?></td>
                 
                  <td><input type="checkbox" class="switch"  id="<?php echo $category['id']; ?>" <?php if ($category['is_active']==1) {
                    echo "checked";
                  }  ?> ></td>
                  <td class="text-center">
   <a href="<?php echo site_url('admin/categories/edit/').$category['id']; ?>" id="<?php echo $category['id']; ?>" class="text-info">
                          <i class="icon-pencil7"></i></a>
                        <a href="" class="text-danger delete" id="<?php echo $category['id']; ?>"><i class=" icon-trash"></i></a>
                  </td>
                  <!-- <td></td>
                 <td></td>
                 <td></td> -->
                  </tr>
                <?php
                  } 

                ?>
              
              </tbody>
            </table>
					</div>
					<!-- /page length options -->
					<!-- Footer -->
					<!-- <div class="footer text-muted">
						&copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/project/Kopyov" target="_blank">Eugene Kopyov</a>
					</div> -->
					<!-- /footer -->

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
                  url:BASE_URL+'admin/categories/update_status',
                  type: 'POST',
                  data: {
                        category_id:id,
                        is_active:check
                     },
                })
                .done(function(msg){
                   
              if (msg=='Active')
                    {
                      toastr.success("<?php echo _l('activation_msg', _l('category')); ?>");
                    }
                    else
                    {
                        toastr.success("<?php echo _l('deactivation_msg', _l('category')); ?>");
                    }
          response = (msg == '0') ? true : false;
          return response;
        }).fail(function(data){
        console.log("fail method is called");
        }); 
      // }
       
   });
/* End of Update User Status Jquery for checkbox switch  */

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
        }).then(function(isConfirm) {
          if (isConfirm) {
                $.ajax({
                  url:BASE_URL+'admin/categories/delete',
                  type: 'POST',
                  data: {
                        category_id:id
                     },
                })
                .done(function() {
                  toastr.success("Category Deleted.");
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
        toastr.error("Please Select Tasks");
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
                  url:BASE_URL+'admin/categories/delete_selected',
                  type: 'POST',
                  data: {
                        ids:delete_array
                     },
                })
                .done(function() {
                  toastr.success("Categories Deleted.");
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

/* end of document ready */

});

</script>
