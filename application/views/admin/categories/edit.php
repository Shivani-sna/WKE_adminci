<!-- page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4></i> <span class="text-semibold">Edit Category</span></h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<?php  ?>
							<li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a></li>
							 <li><a href="<?php echo base_url('admin/categories'); ?>">Categories</a></li>
							<li class="active">Edit</li>

						</ul>
					</div>
				</div>
				<!-- page header -->

				<!-- Content area -->
				<div class="content">

					

					<!-- Centered forms -->
					<div class="row">
						
						<div class="col-md-8 col-md-offset-2">
							<form action="<?php echo base_url('admin/categories/edit/').$category['id']; ?>" id="categoryform" method="POST">
								<div class="panel panel-flat">
									<div class="panel-heading">
										<div class="row">
											<div class="col-md-10">
												<h5 class="panel-title"><strong>Category</strong></h5>
												<!-- <div class="heading-elements">
													<ul class="icons-list">
								                		<li><a data-action="collapse"></a></li>
								                		<li><a data-action="reload"></a></li>
								                		<li><a data-action="close"></a></li>
								                	</ul>
							                	</div> -->
											</div>
										</div>
									</div>
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<small class="req text-danger">*</small>
													<label>Name:</label>
													<input type="text" class="form-control" placeholder="Category Name" id="name" name="name" value="<?php echo $category['name']; ?>">
												</div>
												
						
									<div class="form-group">
										<label>Status :</label>
										<input type="checkbox" class="switch"  id="<?php echo $category['id']; ?>" <?php if ($category['is_active']==1) {
                    echo "checked";
                  }  ?>>
									</div>
									

												
												
											</div>
										</div>
									</div>
									
								</div>
							
						</div>
				</div>

					<!-- /form centered -->
					<div class="btn-bottom-toolbar text-right btn-toolbar-container-out">
						<button type="submit" class="btn btn-primary" name="submit">Save</button>
						 <a class="btn btn-success" onclick="window.history.back();">Back</a>
        				 
      				</div>

					</form>
				<!-- /content area -->

<script type="text/javascript">
$(function () {
    $("#categoryform").validate({
        rules: {
        	name:
        	{
        		 required: true,
        	},
        	
        },
        messages: {
        	name: {
                 required:"<?php echo _l('required_field_msg', _l('category_name')) ?>",
                    // email:"Please enter a valid email address"

            },
            

        }
        
    });  
    });

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
  });

</script>

