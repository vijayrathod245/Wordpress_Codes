<?php
/**
 * Plugin Name:       Specific category hide
 * Plugin URI:        #
 * Description:       Specific category hide in WooCommerce.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Author:            Maulik
 * Author URI:        #
 * License:           GPL v2 or later
 * License URI:       #
 * Text Domain:       hide-category
 * Domain Path:       /languages
 */

/*
 * Exit if accessed directly
 */
if (!defined('ABSPATH')) {
    exit;
}

define('SP_TEXTDOMAIN', 'specific-hide-category');
define('SP_DIR', plugin_dir_url( __FILE__ ));

/*
 *Create a class called "Specific_Category_Hide" if it doesn't already exist
 */
if ( !class_exists( 'Specific_Category_Hide' ) ) {

	Class Specific_Category_Hide{
		
		public function __construct() {
			add_action('init', array($this, 'sch_check_notice'));
			add_action('admin_enqueue_scripts', array($this, 'hide_category_scripts'));
			add_action( 'woocommerce_product_query', array($this,'custom_pre_get_posts_query')); 
			
		}
		
		public function sch_check_notice() {

			if (!defined('WC_VERSION')) {
				add_action('admin_notices', array($this, 'sc_load_error'));
			}
			else{
				add_action( 'admin_menu', array($this, 'sph_layouts_menu'),100);
			}
			
		}
		
		public function sc_load_error() {
		
            $buy_now_url = esc_url('https://woocommerce.com/');

            $message = '<p><strong>' . __('Specific category hide', SP_TEXTDOMAIN) . '</strong>' . __(' plugin not working because you need to install the WooCommerce plugin', SP_TEXTDOMAIN) . '</p>';
            $message .= '<p>' . sprintf('<a href="%s" class="button-primary" target="_blank">%s</a>', $buy_now_url, __('Get WooCommerce', SP_TEXTDOMAIN)) . '</p>';
        
			echo '<div class="error"><p>' . $message . '</p></div>';

		}
		
		public function sph_layouts_menu(){
			
			add_submenu_page( 'woocommerce',  __( 'WooCommerce scategory hide', SP_TEXTDOMAIN), 'Specific category hide', 'manage_woocommerce','wc-scategory-hide', 'specific_category_hide');
			
					
			/**
			*@return html Display
			*/
			function specific_category_hide(){
				include_once('includes/category_hide_function.php');
				include_once('includes/categories-hide-layout.php');
				
			}
		}
		
		function custom_pre_get_posts_query($data) {

			$tax_query = (array) $data->get( 'tax_query' );
			$select_values = get_option('specific_category_hide');
			$tax_query[] = array(
				   'taxonomy' => 'product_cat',
				   'field' => 'slug',
				   'terms' => $select_values,
				   'operator' => 'NOT IN'
			);
			$data->set( 'tax_query', $tax_query );
		}
		/**
		 *@return style and script in admin site
		 */
		public function hide_category_scripts(){
			   wp_enqueue_script( 'sp_script', SP_DIR. '/assets/admin/js/sphide_admin.js',array());
			   wp_enqueue_style( 'sphide_style', SP_DIR. '/assets/admin/css/sphide_style.css',array());
			  wp_enqueue_script( 'admin_script', SP_DIR. '/assets/admin/js/admin_hide_custom.js',array());

		}
		
	}	
}

/*
 * Created new object of the Specific_Category_Hide.
 */
new Specific_Category_Hide();