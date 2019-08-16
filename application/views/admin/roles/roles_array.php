	<?php 
// 	echo "<pre>";
// print_r($permissions);
		 // echo "<pre>";
		 // print_r($role);
		 // $permission=array();
		 // echo "</br>";
		 // $permissions = unserialize($role['permissions']);
		 //  print_r($permissions);
		 //  die();
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
																	foreach ($permission['capabilities']as $key => $value)
																	 {
																	 	
																		$permission_array= array();
																		?>
<input type="checkbox" name="permissions[<?php echo $permission['name']; ?>][]" value="<?php echo $value; ?>">

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
													<!-- 
													 <input type="hidden" name="permissions_name[]" value="<?php echo $permissions; ?>">  -->
														
												</table>
											<!-- </form>  -->