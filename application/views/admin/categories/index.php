
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
              <?php 
                  if (has_permissions('categories','create'))
                   {
                ?>
								<a href="<?php echo base_url('admin/categories/add'); ?>" class="btn btn-primary">Add New</a>
                  <?php
                  }
               ?>
               <?php 
                  if (has_permissions('categories','delete'))
                   {
                ?>
							<a href="" class="btn btn-danger" id="delete_all">Delete Selected</a>
              <?php
                  }
               ?>
				      <table class="table">
              <thead>
                <tr>
                  <?php 
                  if (has_permissions('categories','delete'))
                   {
                ?>
                  <th width="5%"><input type="checkbox" name="delete_id" id="select_all"></th>
                   <?php
                  }
               ?>
                  <th width="75%">Name</th>
                  <th width="5%">Status</th>

                  <?php if (has_permissions('categories','edit') || has_permissions('categories','delete')): ?>
                  <th width="10%" class="text-center">Actions</th>
                <?php endif ?>
            
                </tr>
              </thead>
              <tbody>
                
                <?php foreach ($categories as $key => $category)
                { ?>
                  <tr>

                    <?php 
                  if (has_permissions('categories','delete'))
                   {
                ?>
                  <td><input type="checkbox" class="checkbox"  name="delete"  id="<?php echo $category['id']; ?>"></td>
                    <?php
                  }
               ?>
                  <td><?php echo $category['name']; ?></td>
                 
                 <?php
                  $readonly_status = '';
                  if (!has_permissions('categories','edit'))
                   {
                    $readonly_status = "readonly";
                   }
               ?>
                  <td><input type="checkbox" class="switch"  id="<?php echo $category['id']; ?>" <?php if ($category['is_active']==1) {
                    echo "checked";
                  }  ?> <?php echo  $readonly_status; ?>></td>
                  <?php if (has_permissions('categories','edit') || has_permissions('categories','delete')): ?>
                  <td class="text-center">
               <?php
                  if (has_permissions('categories','edit'))
                   {
               ?>
   <a href="<?php echo site_url('admin/categories/edit/').$category['id']; ?>" id="<?php echo $category['id']; ?>" class="text-info">
                          <i class="icon-pencil7"></i></a>
              <?php
                  }
               ?>
                <?php 
                  if (has_permissions('categories','delete'))
                   {
                ?>
                        <a href="" class="text-danger delete" id="<?php echo $category['id']; ?>"><i class=" icon-trash"></i></a>
                <?php
                  }
               ?>
                  </td>
                    <?php endif ?>
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
         title: "<?php echo _l('deletion_msg', _l('category')); ?>",
          text: "<?php echo _l('recovery_msg', _l('category')); ?>",
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
                 if (msg=="success")
                   {
                     toastr.success("<?php echo _l('deleted', _l('category')); ?>");
                   
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
       toastr.error("<?php echo _l('select_before_delete_msg', _l('category')) ?>");
         // swal("", "Please Select Users", "warning");
         return false;
      }
       swal({
          title: "<?php echo _l('deletion_multiple_msg', _l('categories')); ?>",
          text: "<?php echo _l('recovery_multiple_msg', _l('categories')); ?>",
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
                .done(function()
                 {
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

/* end of document ready */

});

</script>
