<?php 
	 $permission=array();
	 $permissions_array = unserialize($role['permissions']);	
?>
<table class="table table-bordered">
	<tr>
		<th>Features</th>
		<th>Capabilities</th>
	</tr>
<?php
		foreach ($permissions as $key =>$permission )
		{
?>
	<tr>
		<th>
			<?php echo ucfirst($permission['name']); ?>
		</th>
		<td>
			<div>
<?php 
			foreach ($permission['capabilities'] as $key => $value)
			{
			$match =FALSE;
				foreach ($permissions_array as $data =>$capabilities)

				{
					if ($data == $permission['name'] ) 
					{
						if ($capabilities!=NULL)
						 {
							foreach ($capabilities as $key => $view)
							 {
								if ($view!=NULL)
								 {
									if ($view==$value)
									 {
									 	$match = TRUE;
									 }
								}
							}
						 }
					}
				}
				$id = $permission['name']."_".$value;
?>
			<input type="checkbox" name="permissions[<?php echo $permission['name']; ?>][]" value="<?php echo $value; ?>" <?php if ($match == TRUE) { echo "checked"; } ?>  id="<?php echo $id; ?>" class="permission">
			<label for="<?php echo $id; ?>"><?php echo $value; ?></label>
			</br>
<?php 
			}
?>
			</div>
		</td>
	</tr>
<?php
	}
?>
</table>
