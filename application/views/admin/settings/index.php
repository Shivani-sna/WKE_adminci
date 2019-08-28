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
			</ul>
		<form action="<?php echo base_url('admin\settings\add'); ?>" method="POST">
		<div class="tab-content col-md-12">

		<!-- tab pane for group-general -->
		<div class="tab-pane active has-padding" id="group-general">

<?php
	foreach ($settings as  $setting)
		{
			if ($setting['name']=="company_name")
			 {
?>
			<div class="form-group ">
				<label>Company Name:</label>
				<input type="text" name="company_name" class="form-control" value="<?php echo $setting['value'] ?>">
			</div>
<?php
			}
			if ($setting['name']=="allowed_file_types")
			{
								
?>
			<div class="form-group">
				<label>Allowed File Types:</label>
				<input type="text" name="allowed_file_types" class="form-control"  value="<?php echo $setting['value'] ?>">
				<span class="help-block">Accepted formats: gif, png, jpg. Max file size 2Mb. Add comma separated extensions</span>
			</div>
<?php
			}
		}
?>
		</div>
		<!-- /tab pane for group-general -->

		<!-- tab pane for group-date-time -->
		<div class="tab-pane has-padding" id="group-date-time">
<?php
	foreach ($settings as  $setting)
		{
			if ($setting['name']=="date_format")
			 {
?>
			<div class="form-group ">
				<label>Date Format:</label>
				<select class="select" name="date_format" id="role">
					<option value="j-M-Y" <?php echo ($setting['value']=="j-M-Y")? "selected" : " "; ?>>
						<?php echo date("j-M-Y"); ?>
					</option>
					<option value="j-m-Y" <?php echo ($setting['value']=="j-m-Y")? "selected" : " "; ?>>
						<?php echo date("j-m-Y"); ?>
					</option>
					<option value="jS F, Y" <?php echo ($setting['value']=="jS F, Y")? "selected" : " "; ?>>
						<?php echo date("jS F, Y"); ?>
					</option>
				</select>
			</div>
<?php
			}
			if ($setting['name']=="time_format")
			{
								
?>
			<div class="form-group">
				<label>Time Format:</label>
				<select class="select" name="time_format" >
					<option value="h" <?php echo ($setting['value']=="h")? "selected" : " "; ?>>12 hours</option>
					<option value="H" <?php echo ($setting['value']=="H")? "selected" : " "; ?>>24 hours</option>
					<option value="h:i A" <?php echo ($setting['value']=="h:i A")? "selected" : " "; ?>><?php echo date('h:i  A') ?></option>
					
				</select>
			</div>
<?php
			}
		}
?>
		<!-- /tab pane for group-date-time -->		
	</div>
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
