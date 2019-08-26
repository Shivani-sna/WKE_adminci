<!-- page header -->
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
		<div class="panel-heading">
			<h6 class="panel-title"><strong>Settings</strong></h6>
		</div>
		<div class="panel-body">
	<form method="POST" action="<?php echo base_url('admin/settings/add'); ?>" >
	<div class="tabbable nav-tabs-vertical nav-tabs-left">
		<ul class="nav nav-tabs nav-tabs-highlight">
			<?php
				foreach ($settings as $key => $setting)
				{
			?>
				<li <?php if($key=='date'){ echo "class='active'"; }?>><a href="#left-<?php echo $setting; ?>" data-toggle="tab" aria-expanded="true"><i class="icon-menu7 position-left"></i> <?php echo $setting; ?></a></li>
			<?php
				}
			?>									
		</ul>

		<div class="tab-content">	
			<!-- Date Form -->
			<div class="tab-pane has-padding active" id="left-Date">
				<div class="row">
					
						<div class="col-md-12">
								<div class="form-group">
								<small class="req text-danger">* </small>
								<label>Date Format</label>
								<select class="select" name="date_format">
								<div class="form-group">
									<option value="d-m-Y">d-m-Y</option>
									<option value="d/m/Y">d/m/Y</option>
									<option value="m-d-Y">m-d-Y</option>
									<option value="Y-m-d">Y-m-d</option>
								</select>
							</div>
						</div>
					
			</div>
			</div>
			<!--/Date Form -->
			<!-- Language Form -->
			<div class="tab-pane has-padding active" id="left-Language">
				<div class="row">
					
						<div class="col-md-12">
								<div class="form-group">
								<small class="req text-danger">* </small>
								<label>Language</label>
								<select class="select" name="language" >
								<div class="form-group">
									<option value="English">English</option>
									<option value="Chinese">Chinese</option>
									<option value="France">France</option>
								</select>
							</div>
						</div>
					
			</div>
			</div>
			<!--/Language Form -->
			<!-- General Form -->
			<div class="tab-pane has-padding active" id="left-General">
				<div class="row">
					
						<div class="col-md-12">
								<div class="form-group">
								<small class="req text-danger">* </small>
								<label>Company Name</label>
								<input type="text" name="company_name" class="form-control">
							</div>
						</div>
					
			</div>
			</div>
			<!--/General Form -->
			<div class="tab-pane has-padding" id="left-Time">
				s marfa nulla single-origin coffee squid laeggin.
			</div>
		</div>
	</div>
</div>
</div>
</div>
<div class="btn-bottom-toolbar text-right btn-toolbar-container-out">
		<button type="submit" class="btn btn-success" name="submit">Save</button>
		<a class="btn btn-default" onclick="window.history.back();">Back</a>
	</div>
	</form>
<!-- /vertical tabs -->
</div>
<script type="text/javascript">

// jQuery('ul.nav-tabs-highlight li').click(function()
//  {
// 	$('.nav-tabs-highlight li.active').removeClass('active');
// 	$(this).addClass('active');
// });

</script>
