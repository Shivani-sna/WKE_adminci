	<?php 
		
		 $permission=array();
		
		 $permissions_array = unserialize($role['permissions']);
		 // print_r($permissions_array);
		
	 ?>
	
	<table class="table table-bordered">
<tr>
	<td>Features</td>
	<td>Capabilities</td>
</tr>
<?php

	foreach ($permissions as $key =>$permission ) {
	
		?>
	<tr>
		<td><?php echo ucfirst($permission['name']); ?></td>
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
						 		//print_r($capabilities);
						 		if ($capabilities!=NULL)
						 		 {
						 			foreach ($capabilities as $key => $view) {
						 			if ($view!=NULL) {
						 			if ($view==$value)
						 			 {
						 			 		$match = TRUE;
						 		 }
						 			}
						 			
						 			
						 		}
						 		}
						 		 
						 	}

						 }
					?>

					
						
	<input type="checkbox" name="permissions[<?php echo $permission['name']; ?>][]" value="<?php echo $value; ?>" <?php if ($match == TRUE)
	 {
		echo "checked";
	} ?> >

						<?php echo $value; ?>
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
<!-- </form>  -->