<!-- page header -->
				<div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4></i> <span class="text-semibold">Add Project</span></h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<?php  ?>
							<li><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a></li>
							 <li><a href="<?php echo base_url('admin/projects'); ?>">Projects</a></li>
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
							<form action="<?php echo base_url('admin/projects/add'); ?>" id="projectform" method="POST">
								<div class="panel panel-flat">
									<div class="panel-heading">
										<div class="row">
											<div class="col-md-10">
												<h5 class="panel-title"><strong>Project</strong></h5>
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
													<label>Project Name:</label>
													<input type="text" class="form-control" placeholder="Project Name" id="name" name="name">
												</div>
												<div class="form-group">
													<small class="req text-danger">*</small>
													<label>Details:</label>
													<input type="text" class="form-control" placeholder="Details" id="details" name="details">
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
    $("#projectform").validate({
        rules: {
        	name:
        	{
        		 required: true,
        	},
        	
        },
        messages: {
        	name: {
                 required:"Please Enter Project name",
                    // email:"Please enter a valid email address"

            },
            

        }
        
    });  
    });
</script>

