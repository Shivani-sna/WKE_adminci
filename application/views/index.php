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
	<style type="text/css">
		.error
	{
  	 color:red;
    }
	</style>
	<!-- Core JS files -->

	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/loaders/pace.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/core/libraries/jquery.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/core/libraries/bootstrap.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/loaders/blockui.min.js'); ?>"></script>
	<!-- /core JS files -->
	<!-- Theme JS files -->
	
	<script type="text/javascript" src="<?php echo base_url('assets/js/core/app.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/forms/styling/uniform.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/core/app.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/pages/login.js'); ?>"></script>
	<!-- /theme JS files -->
</head>

<body class="login-container">
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">

					<?php echo $content; ?>


					<!-- Footer -->
					<div class="footer text-muted text-center">
						&copy; <?php echo date('Y') ?>. <a href="#">Admin Site</a> by <a target="_blank">Shivani Nagoria</a>
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
