<?php
/*
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}



/*
 *Create a class called "Show_Product_Category" if it doesn't already exist
 */
if ( !class_exists( 'Show_Product_Category' ) ) {
	
	class Show_Product_Category{
		
		public function spl_category_list() {
			
			$category_args = array(
				 'taxonomy'     => 'product_cat',
				 'orderby'      => 'name',
				 'show_count'   => 0,
				 'pad_counts'   => 0,
				 'hierarchical' => 1,
				 'title_li'     => '',
				 'hide_empty'   => 0
			);
			
			$all_categories = get_categories($category_args);
			foreach($all_categories as $key=> $category_data){
				$array_category[$key]['name'] =  $category_data->name;
				$array_category[$key]['slug'] =  $category_data->slug;
			}
			
			return $array_category;
		}
		
		/*
		 *Save the category name.
		 */
		public function submit_data(){
				
				if(isset($_POST['hide_cate'])){
				
				$category_data = $_POST['select_hcategory'];
				
				$get_option_values = get_option( 'specific_category_hide');
				
					update_option( 'specific_category_hide', $category_data, '', 'yes');	
				if(!$get_option_values){
					add_option( 'specific_category_hide', $category_data, '', 'yes' );	
				}
				
			}
		}
		
	}
}

/*
 * Created new object of the Show_Product_Category.
 */
new Show_Product_Category();
