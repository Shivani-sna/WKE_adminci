<!-- page header -->
<?php date_default_timezone_set('Asia/Kolkata'); ?>

<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4></i> <span class="text-semibold">Settings</span></h4>
		</div>
	</div>
	<div class="breadcrumb-line">
		<ul class="breadcrumb">
			<li>
				<a href="<?php echo base_url('admin/dashboard'); ?>"><i class="icon-home2 position-left"></i>Dashboard</a>
			</li>
			<li class="active">Settings</li>
		</ul>
	</div>
</div>
<!-- page header -->
<!-- Vertical tabs -->
<div class="content">
	<div class="row">
	<div class="col-md-12">
		<div class="panel panel-flat">
		<div class="panel-body">
			<div class="tabbable nav-tabs-vertical nav-tabs-left">
			<ul class="nav nav-tabs nav-tabs-highlight">
					<li class="active">
						<a href="#group-general" data-toggle="tab">General</a>
					</li>
					<li>
						<a href="#group-date-time" data-toggle="tab">Date & Time</a>
					</li>
					<li>
						<a href="#group-social-media" data-toggle="tab">Social Media</a>
					</li>
			</ul>
		<form action="<?php echo base_url('admin\settings\add'); ?>" method="POST">
		<div class="tab-content col-md-12">

		<!-- tab pane for group-general -->
		<div class="tab-pane active has-padding" id="group-general">
			<div class="form-group ">
				<label>Company Name:</label>
				<input type="text" name="company_name" class="form-control" value="<?php echo get_settings('company_name'); ?>">
			</div>
			<div class="form-group">
				<label>Allowed File Types:</label>
				<input type="text" name="allowed_file_types" class="form-control"  value="<?php echo get_settings('allowed_file_types'); ?>">
				<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb. Add comma separated extensions</span>
			</div>
		</div>
		<!-- /tab pane for group-general -->

		<!-- tab pane for group-date-time -->
		<div class="tab-pane has-padding" id="group-date-time">
			<div class="form-group ">
				<label>Date Format:</label>
				<select class="select" name="date_format" id="role">
					<option value="j-M-Y" <?php echo (get_settings('date_format')=="j-M-Y")? "selected" : " "; ?>>
						<?php echo date("j-M-Y"); ?>
					</option>
					<option value="j-m-Y" <?php echo (get_settings('date_format')=="j-m-Y")? "selected" : " "; ?>>
						<?php echo date("j-m-Y"); ?>
					</option>
					<option value="jS F, Y" <?php echo (get_settings('date_format')=="jS F, Y")? "selected" : " "; ?>>
						<?php echo date("jS F, Y"); ?>
					</option>
				</select>
			</div>
			<div class="form-group">
				<label>Time Format:</label>
				<select class="select" name="time_format" >
					<option value="h:i A" <?php echo (get_settings('time_format')=="h:i A")? "selected" : " "; ?>>02:30 PM (12 hours)</option>
					<option value="H:i" <?php echo (get_settings('time_format')==":i")? "selected" : " "; ?>>14:30 (24 hours)</option>		
				</select>
			</div>
</div>
	<!-- /tab pane for group-date-time -->	

	<!-- tab pane for group-social-media -->
	<div class="tab-pane has-padding" id="group-social-media">
		<div class="form-group has-feedback has-feedback-left">
			
			
			<label>Facebook URL:</label>

			<input type="text" name="facebook_url" value="<?php echo get_settings('facebook_url') ?>" class="form-control">
			<div class="form-control-feedback">
				<i class="icon-facebook2"></i>
			</div>
		</div>
	</div>
	<!-- /tab pane for group-social-media -->
</div>
</div>
</div>
</div>
</div>
<!-- end of flate panel -->
<div class="btn-bottom-toolbar text-right btn-toolbar-container-out">
	<button type="submit" class="btn btn-success" name="submit">Save</button>
	<a class="btn btn-default" onclick="window.history.back();">Back</a>
</div>
</form>
