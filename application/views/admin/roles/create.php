<!-- page header -->
<?php


?>
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4></i> <span class="text-semibold">Add Role</span></h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<?php  ?>
							<li><a href="<?php echo base_url('admin/home'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a></li>
							 <li><a href="<?php echo base_url('admin/Roles'); ?>">Role</a></li>
							<li class="active">Add</li>

						</ul>
					</div>
				</div>
				<!-- page header -->

				<!-- Content area -->
				<div class="content">

					

					<!-- Centered forms -->
					<div class="row">
						
						<div class="col-md-8 col-md-offset-2">
							<form method="POST" action="<?php echo base_url('admin/roles/add'); ?>" id="roleform">
								<div class="panel panel-flat">
									<div class="panel-heading">
										<div class="row">
											<div class="col-md-10">
												<h5 class="panel-title">Role</h5>
											</div>
										</div>
									</div>
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<small class="req text-danger">*</small>
													<label>Role Name:</label>
													<input type="text" class="form-control" placeholder="Role Name" id="name" name="name">
													
												</div>
												<div>
													<?php echo $array; ?>
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
    $("#roleform").validate({
        rules: {
        	name:
        	{
        		 required: true,
        	},
        	
        },
        messages: {
        	name: {
                 required:"Please Enter Role Name",
    

            },
            

        }
        
    });  
    });
</script>

