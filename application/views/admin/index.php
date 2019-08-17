<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>WKE-Admin Site</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/icons/icomoon/styles.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/core.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/components.css'); ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url('assets/css/colors.css'); ?>" rel="stylesheet" type="text/css">
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

	<!-- /global stylesheets -->

<!-- sweet alert -->
	<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
	<style type="text/css">
		<style>
/* Tooltip container */
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
}
	</style>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  
	<!-- Core JS files -->
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/loaders/pace.min.js'); ?>"></script>
	
	<script type="text/javascript" src="<?php echo base_url('assets/js/core/libraries/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/core/libraries/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/loaders/blockui.min.js'); ?>"></script>
	<!-- /core JS files -->

	 <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/forms/styling/switchery.min.js'); ?>"></script>
	
	<!-- Theme JS files -->

	<script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
	<!-- <script type="text/javascript" src="<?php //echo base_url('assets/js/pages/login.js'); ?>"></script> -->
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/tables/datatables/datatables.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/forms/selects/select2.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/core/app.js'); ?>"></script>
	<!--  <script type="text/javascript" src="<?php //echo base_url('assets/js/pages/datatables_basic.js'); ?>"></script>    -->
	<!-- /theme JS files -->
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	 <!-- date picker -->
	 	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/ui/moment/moment.min.js')?>"></script>
	 <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/pickers/daterangepicker.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/pickers/anytime.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/pickers/pickadate/picker.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/pickers/pickadate/picker.date.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/pickers/pickadate/picker.time.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/pickers/pickadate/legacy.js'); ?>"></script>

	<script type="text/javascript" src="<?php echo base_url('assets/js/pages/picker_date.js'); ?>"></script>
	 <!-- /date picker -->

	 <!-- select box -->
	 
	<script type="text/javascript" src="<?php echo base_url('assets/js/core/libraries/jquery_ui/interactions.min.js'); ?>"></script>
	 <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/forms/selects/select2.min.js'); ?>"></script>
	 <script type="text/javascript" src="<?php echo base_url('assets/js/pages/form_select2.js'); ?>"></script>
	 <!-- select box -->
			 <script type="text/javascript">
	 	/*Jquery for checkbox switch */
$(function() {   
   var switches = Array.prototype.slice.call(document.querySelectorAll('.switch'));
    switches.forEach(function(html) {
        var switchery = new Switchery(html, {color: '#4CAF50'});
    });
    });
/*End of Jquery for checkbox switch */
	 </script>
<!-- sweet alert -->
	<style type="text/css">
	.error
	{
  	 color:red;
    }

    .input-group-addon {
    padding: 6px 12px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1;
    color: #555;
    text-align: center;
   
    border: 1px solid #ccc;
    border-radius: 4px;
}
.input-group-addon, .input-group-btn {
    width: 1%;
    white-space: nowrap;
    vertical-align: middle;
}
.input-group .form-control, .input-group-addon, .input-group-btn {
    display: table-cell;
}
.input-group {
    position: relative;
    display: table;
    border-collapse: separate;
}
	</style>
	<style type="text/css">
		.btn-info.active.focus, .btn-info.active:focus, .btn-info.active:hover, .btn-info:active.focus, .btn-info:active:focus, .btn-info:active:hover, .open>.dropdown-toggle.btn-info.focus, .open>.dropdown-toggle.btn-info:focus, .open>.dropdown-toggle.btn-info:hover {
    color: #fff;
    background-color: #269abc;
    border-color: #1b6d85;
}
	.btn-toolbar-container-out {
    margin-left: -10px;
}
.btn-bottom-toolbar {
    position: fixed;
    bottom: 0;
    padding: 15px;
    padding-right: 41px;
    margin: 0 0 0 -46px;
    -webkit-box-shadow: 0 -4px 1px -4px rgba(0,0,0,.1);
    box-shadow: 0 -4px 1px -4px rgba(0,0,0,.1);
    background: #fff;
    width: calc(100% - 211px);
    z-index: 5;
    border-top: 1px solid #ededed;
}

</style>


</head>

<body>
	<?php $session =$this->session->userdata('user'); ?>
	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo base_url('admin/dashboard'); ?>"><img src="<?php echo base_url("assets/images/logo_light.png"); ?>" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
						<span><?php echo $session['username']; ?></span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						
						<li><a href="<?php echo base_url('admin/myprofile/edit'); ?>" data-popup="tooltip" data-placement="left" data-original-title="Edit Profile" > Edit profile</a></li>
						<li><a href="<?php echo base_url('authentication/logout'); ?>"data-popup="tooltip" data-placement="left" data-original-title="Logout"> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->




	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">

					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content">
							<div class="media">
								<div class="media-body">
									<span class="media-heading text-semibold">
										<?php
										 //echo "<pre>";
										 
										 echo "Welcome".'&nbsp;'.$session['username'].'&nbsp;'; 
										?>
										<a style="color: white;" href="<?php echo base_url('authentication/logout'); ?>" align="padding-right"><i class="icon-switch2" data-popup="tooltip"  data-placement="right" data-original-title="Logout"></i></a>
											
										</span>

								<!-- 	<div class="text-size-mini text-muted">
										<i class="icon-pin text-size-small"></i> &nbsp;Santa Ana, CA
									</div> -->
								</div>


							</div>
						</div>
					</div>
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">

								<!-- Main -->
							
								<li <?php 
									if ($this->uri->segment(2)=='dashboard') 
									{
										echo 'class="active"';
									}
								 ?>><a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
								
								
								 <?php 
										if (has_permissions('users', 'view'))
										{
									?>
									<li <?php 
									if ($this->uri->segment(2)=='users') 
									{
										echo 'class="active"';
									}
								 ?>>
								 <a href="<?php echo base_url('admin/users'); ?>">
								 	<i class="icon-users4"></i>
								 	<span>Users</span>
								 </a>
								</li>
											
										<?php 
										}
										?>
								
								 <?php 
										if (has_permissions('projects', 'view'))
										{
									?>
										<li <?php 
									if ($this->uri->segment(2)=='projects') 
									{
										echo 'class="active"';
									}
								 ?>>
								 <a href="<?php echo base_url('admin/projects'); ?>"><i class="icon-menu3"></i><span>
								Projects</span></a></li>
											
										<?php 
										}
										?>
									 <?php 
										if (has_permissions('categories', 'view'))
										{
									?>
									<li <?php 
									if ($this->uri->segment(2)=='categories') 
									{
										echo 'class="active"';
									}
								 ?>><a href="<?php echo base_url('admin/categories'); ?>"><i class="icon-menu6"></i><span>
								Categories</span></a></li>
											
										<?php 
										}
										?>
										 <?php 
										if (has_permissions('roles', 'view'))
										{
									?>
									<li <?php 
									if ($this->uri->segment(2)=='roles') 
									{
										echo 'class="active"';
									}
								 ?>>
								 <a href="<?php echo base_url('admin/roles'); ?>">
								 	<i class="icon-menu6"></i>
								 	<span>Roles</span>
								 </a>
								</li>
											
										<?php 
										}
										?>
								
								

															<!-- /main -->
							</ul>
						</div>
					</div>
					<!-- /main navigation -->

				</div>
			</div>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper"> 
				

<?php echo $content; ?>
				<!-- Footer -->
					<div class="footer text-muted text-center">
						&copy; <?php echo date('Y') ?>. <a href="#">Admin Site</a> by <a target="_blank">Shivani Nagoria</a>
					</div>
					<!-- /footer -->
			</div> 
			<!-- /main content -->


		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->
	
</body>
</html>
  <?php

if ($this->session->flashdata('success'))
{
    ?>
    <script type="text/javascript">
    	

	$(function() {

    toastr.success("<?php echo $this->session->flashdata('success'); ?>");
  });
    </script>
<?php }


else

if ($this->session->flashdata('error'))
{
    ?>

    <script type="text/javascript">
    	

	$(function() {

    toastr.error("<?php echo $this->session->flashdata('error'); ?>");
  });
    </script>
   
<?php }
else

if ($this->session->flashdata('warning'))
{
    ?>
    <script type="text/javascript">
    	

	$(function() {

    toastr.warning("<?php echo $this->session->flashdata('warning') ?>");
  });
    </script>
   
  <!--   toastr.warning("<?php// echo $this->session->flashdata('warning'); ?>"); -->

<?php }
else

if ($this->session->flashdata('info'))
{
    ?>
     <script type="text/javascript">
    	

	$(function() {

    toastr.info("<?php echo $this->session->flashdata('info') ?>");
  });
    </script>
<?php }

?>
