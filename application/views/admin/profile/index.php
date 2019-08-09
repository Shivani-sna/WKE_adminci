<?php 
	$session = $this->session->userdata('user');
	// print_r($user['password']);
	$password_user=$user['password'];
 ?>
<!-- page header -->
				<!-- <div class="page-header page-header-default">
					<div class="page-header-content">
						<div class="page-title">
							<h4></i> <span class="text-semibold"><?php //echo $session['firstname'].'&nbsp;'.$session['lastname']; ?></span></h4>
						</div>
					</div>

					<div class="breadcrumb-line">
						<ul class="breadcrumb">
							<?php  ?>
							<li><a href="<?php// echo base_url('admin/home'); ?>"><i class="icon-home2 position-left"></i> Home</a></li>
							 <li><a href="<?php //echo base_url('admin/profile'); ?>">Profile</a></li>
							<li class="active">Edit</li>

						</ul>
					</div>
				</div> -->
				<!-- page header -->


				<!-- Content area -->
				<div class="content">

					

					<!-- Centered forms -->
					<div class="row">
						
						<div class="col-md-4">
							<form action="<?php echo base_url('admin/myprofile/update/') ?>" id="myprofileform" method="POST">
								<div class="panel panel-flat">
									<div class="panel-heading">
										<div class="row">
											<div class="col-md-10">

												<h3 class="panel-title"><?php echo $user['firstname'].'&nbsp;'.$user['lastname']; ?></h3>
													
												</div>
										</div>
									</div>
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12">
											<div class="form-group">

												<i class="icon-user"></i>
												 <?php if ($user['role']==1)
													 {
														echo "Admin";
													} ?>
												</div>
												<div class="form-group">
													<strong><i class="icon-envelop5"></i></strong>
													<label><?php echo $user['email']; ?></label>
												</div>
												<div class="form-group">
													<strong><i class="icon-phone2"></i></strong>
													<label><?php echo $user['mobile_no']; ?></label>
												</div>
												
											<div class="form-group">
													<strong><i class="icon-alarm"></i></strong>
													<label>Login <?php echo time_stamp( $user['last_login']); ?></label>
												</div>
											
											
										</div>
										</div>
									</div>
									</form>
								</div>
							
						</div>
					
					</div>
					
				</div>
				