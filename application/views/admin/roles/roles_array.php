<table class="table table-bordered">
	<tr>
		<th>
			Features
		</th>
		<th>
			Capabilities
		</th>
	</tr>
<?php
	foreach ($permissions as $key =>$permission ) 
	{
?>
	<tr>
		<th><?php echo ucfirst($permission['name']); ?></th>
		<td>
			<div>
<?php 
			foreach ($permission['capabilities']as $key => $value)
			{
				$permission_array= array();
				$id = $permission['name']."_".$value;
?>
			<input type="checkbox" name="permissions[<?php echo $permission['name']; ?>][]" value="<?php echo $value; ?>" id="<?php echo $id; ?>" class="permission">
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
