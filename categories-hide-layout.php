<?php

 echo Show_Product_Category::submit_data();
										
?>
<form method="post" class="scategory_hide">
	<div class="sp_cat_hide">
		<h1>Specific category hide from product</h1>
	</div>
	<div>
		<form  method="post" name="submit_data">
			<table>
				<tbody>
					<tr>
						<th><label for="user_login">Select category</label></th>
						<td>
							<select data-placeholder="Begin typing a name to filter..." multiple class="chosen-select" name="select_hcategory[]">
								<option value=""></option>
									<?php
										$select_values = get_option('specific_category_hide');
										$list_category = Show_Product_Category::spl_category_list();
										
									 	foreach($list_category as$key=> $show_category){
										 
											$result=array_intersect($list_category[$key],$select_values);
										
											if($show_category['slug'] == $result['slug']){
												echo '<option value="'.$show_category['slug'].'" selected>'.$show_category['name'].'</option>';
											}
											else{
												echo '<option value="'.$show_category['slug'].'">'.$show_category['name'].'</option>';
											}
										}
									?>
							</select>
						</td>
						</tr>
				</tbody>
			</table>
			<p class="submit">
				<input type="submit" name="hide_cate" class="button button-primary" value="Save">
			</p>
		 </form>
	</div>
</form>